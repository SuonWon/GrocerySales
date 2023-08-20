<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GenerateId;
use App\Models\Item;
use App\Models\StockDamage;
use App\Models\StockDamageDetails;
use App\Models\StockInWarehouse;

use App\Models\UnitMeasurement;
use App\Models\Warehouse;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
class StockDamageController extends Controller
{
    protected $datetime;
   

    public function __construct()
    {
        $this->datetime = Date('Y-m-d H:i:s');
        
    }

    public function index(Request $request){

        $query = StockDamage::orderBy('stock_damages.DamageDate', 'desc')
            ->Join('warehouses', 'stock_damages.WarehouseNo', '=', 'warehouses.WarehouseCode')
            ->select('stock_damages.*','warehouses.WarehouseCode','warehouses.WarehouseName')
            ->where(function($query){
                $query->where('stock_damages.Status', 'O');
            });

        $deletequery = StockDamage::orderBy('stock_damages.DamageDate', 'desc')
            ->Join('warehouses', 'stock_damages.WarehouseNo', '=', 'warehouses.WarehouseCode')
            ->select('stock_damages.*','warehouses.WarehouseCode','warehouses.WarehouseName')
            ->where(function($query){
                $query->where('stock_damages.Status', 'D');
            });

        
        if ($request->input('StartDate') !== null && $request->input('EndDate') !== null) {
            $startDate = $request->input('StartDate');
            $endDate = $request->input('EndDate');

            

            if($endDate < $startDate){
                return back()->with('warning','start date must be lower than end date');
            }

            $query->whereBetween('DamageDate', [$startDate, $endDate]);

            $deletequery->whereBetween('DamageDate', [$startDate, $endDate]);

            

        } else if ($request->input('StartDate') !== null && $request->input('EndDate') == null) {

            $query->where('DamageDate', '>=', $request->input('StartDate'));

            $deletequery->where('DamageDate', '>=', $request->input('StartDate'));

            

        } else if ($request->input('StartDate') == null && $request->input('EndDate') !== null) {

            $query->where('DamageDate', '<=', $request->input('EndDate'));

            $deletequery->where('DamageDate', '<=', $request->input('EndDate'));

            

        } else {
            // If both startDate and endDate are null, retrieve records for the current month
        
            $query->where('DamageDate', '>=', Carbon::now()->subMonths(6)->startOfMonth()->toDateString())
                    ->where('DamageDate', '<=', Carbon::now()->endOfMonth()->toDateString());

            $deletequery->where('DamageDate', '>=', Carbon::now()->subMonths(6)->startOfMonth()->toDateString())
                ->where('DamageDate', '<=', Carbon::now()->endOfMonth()->toDateString());
        
        }

        $CompleteStatus = $request->input('CompleteStatus');

        if ($CompleteStatus === 'complete') {

            $query->where('Status', 'O');

        }else if($CompleteStatus == "delete"){

            $query->where('Status', 'D');

        }else if($CompleteStatus == "all"){

            $query->orwhere('Status', 'O')->orwhere('Status','D');

        }

        $DamageNo = $request->input('DamageNo');

        if($DamageNo != null){
                $query->where('DamageNo', 'LIKE', '%' . $DamageNo . '%');
        }
        
        
        
        $stockdamages = $query->get();
        $deletestockdamages = $deletequery->get();
  
        return view('stock.stockdamage.index',[
            'stockdamages' => $stockdamages,
            'deletestockdamages' => $deletestockdamages
        ]);
    }

    public function create()
    {
        $items = Item::where('Discontinued','=',1)->get();
        $warehouses = Warehouse::all();
        $units = UnitMeasurement::where('IsActive', 1)->get();
        $todayDate = Carbon::now()->format('Y-m-d');

  
        return view('stock.stockdamage.add',[
            'items' => $items,
            'warehouses' => $warehouses,
            'units' => $units,
            'todayDate' => $todayDate,
        ]);
    }

    public function store(){

        $jsonData = json_decode(request()->getContent(), true);
        

        // Validate the JSON data
        $formData = Validator::make($jsonData, [

            'DamageDate' => ['required'],
            'WarehouseNo' => ['required'],
            'Remark' => ['nullable'],
            'Status' => ['required'],
            
            'stockdamagedetails' => ['required']
        ])->validate();

        $DamageNo = GenerateId::generatePrimaryKeyId('stock_damages', 'DamageNo', 'DM-', true);

        $formData['DamageNo'] = $DamageNo;

        

        $stockdamagedetails = $formData['stockdamagedetails'];

        // Add additional data to the form data
        $formData['CreatedBy'] = auth()->user()->Username;
        $formData['ModifiedDate'] = null;

        try {
            // Create a new sales invoice record
            $newStockDamage = StockDamage::create($formData);

            if (isset($newStockDamage)) {



                foreach ($stockdamagedetails as $stockdamagedetail) {


                    $data = [];
                    $data['DamageNo'] = $DamageNo;
                    


                    
                    $data['LineNo'] = $stockdamagedetail['LineNo'];
                   
                    $data['ItemCode'] = $stockdamagedetail['ItemCode'];
                    $data['Quantity'] = $stockdamagedetail['Quantity'];
                    
                    $data['PackedUnit'] = $stockdamagedetail['PackedUnit'];
                    $data['QtyPerUnit'] = $stockdamagedetail['QtyPerUnit'];
                    $data['TotalViss'] = $stockdamagedetail['TotalViss'];
                    
                    $data['UnitPrice'] = $stockdamagedetail['UnitPrice'];
                    $data['Amount'] = $stockdamagedetail['Amount'];
                    
                    // $warehouseCode = $stockdamagedetail['WarehouseNo'];
                    // $ItemCode = $stocktransferdetail['ItemCode'];
                    // $totalViss = $stocktransferdetail['TotalViss'];

                    try {

                        //logger($data);
                        $newStockDamageDetails = StockDamageDetails::create($data);

                       
                        StockInWarehouse::where('WarehouseCode',$formData['WarehouseNo'])->where('ItemCode',$stockdamagedetail['ItemCode'])->decrement('StockQty', $stockdamagedetail['TotalViss']);

                      

                    } catch (QueryException $e) {

                        return response()->json(['message' => $e->getMessage()]);
                    }
                }

                return response()->json(['message' => "good", 'DamageNo' => $DamageNo]);
            }
        } catch (QueryException $e) {

            return response()->json(['message' => $e->getMessage()]);
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function show(StockDamage $stockdamage)
    {

        $stockdamagedetails = StockDamageDetails::orderBy('LineNo', 'asc')
            ->where('DamageNo', $stockdamage->DamageNo)
            ->join('items', 'stock_damage_details.ItemCode', '=', 'items.ItemCode')
            ->join('unit_measurements', 'stock_damage_details.PackedUnit', '=', 'unit_measurements.UnitCode')
            ->select('stock_damage_details.*', 'items.ItemCode', 'items.ItemName', 'items.WeightByPrice', 'unit_measurements.UnitCode', 'unit_measurements.UnitDesc')
            ->get();

        $stockdamage->stockdamagedetails = $stockdamagedetails;

        $warehouses = Warehouse::all();
        $items = Item::where('Discontinued', '=', 1)->get()->sortBy('ItemName');
        $units = UnitMeasurement::where('IsActive', 1)->get();

      
        return view('stock.stockdamage.edit', [
            'stockdamage' => $stockdamage,
            'warehouses' => $warehouses,
            'items' => $items,
            'units' => $units
        ]);
    }

    public function update(StockDamage $stockdamage){

        $jsonData = json_decode(request()->getContent(), true);
        
        
        // Validate the JSON data
        $formData = Validator::make($jsonData, [

            
            'DamageDate' => ['required'],
            'WarehouseNo' => ['required'],
            'OldWarehouseNo' => ['required'],
            
            'Remark' => ['nullable'],
            'Status' => ['required'],
            
            'stockdamagedetails' => ['required']
            
            
        ])->validate();

        $OldWarehouseNo = $formData['OldWarehouseNo'];
        

        $formData['DamageNo'] = $stockdamage->DamageNo;
        $formData['ModifiedBy'] = auth()->user()->Username;
        $formData['ModifiedDate'] = $this->datetime;

        
        $stockdamagedetails = $formData['stockdamagedetails'];
        unset($formData['stockdamagedetails'],$formData['OldWarehouseNo']);

        try {
            // Create a new sales invoice record
            $updateStockDamage = StockDamage::where('DamageNo', $stockdamage->DamageNo)->update($formData);

            if (isset($updateStockDamage)) {

                
                StockDamageDetails::where('DamageNo',$stockdamage->DamageNo)->delete();



                foreach ($stockdamagedetails as $stockdamagedetail) {


                    $data = [];
                    $data['DamageNo'] = $stockdamage->DamageNo;
                                            
                    $data['LineNo'] = $stockdamagedetail['LineNo'];
                   
                    $data['ItemCode'] = $stockdamagedetail['ItemCode'];
                    $data['Quantity'] = $stockdamagedetail['Quantity'];
                    
                    $data['PackedUnit'] = $stockdamagedetail['PackedUnit'];
                    $data['QtyPerUnit'] = $stockdamagedetail['QtyPerUnit'];
                    $data['TotalViss'] = $stockdamagedetail['TotalViss'];
                    
                    $data['UnitPrice'] = $stockdamagedetail['UnitPrice'];
                    $data['Amount'] = $stockdamagedetail['Amount'];
                    
                    // $warehouseCode = $stocktransferdetail['WarehouseNo'];
                    // $ItemCode = $stocktransferdetail['ItemCode'];
                    // $totalViss = $stocktransferdetail['TotalViss'];

                    try {

                        //logger($data);
                        $newStockDamageDetails = StockDamageDetails::create($data);

                        
                        StockInWarehouse::where('WarehouseCode',$OldWarehouseNo)->where('ItemCode',$stockdamagedetail['OldItemCode'])->increment('StockQty', $stockdamagedetail['OldTotalViss']);

                       

                      
                        StockInWarehouse::where('WarehouseCode',$formData['WarehouseNo'])->where('ItemCode',$stockdamagedetail['ItemCode'])->decrement('StockQty', $stockdamagedetail['TotalViss']);


                    } catch (QueryException $e) {

                        return response()->json(['message' => $e->getMessage()]);
                    }
                }

                return response()->json(['message' => "good"]);
            }
        } catch (QueryException $e) {

            return response()->json(['message' => $e->getMessage()]);
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function destory(StockDamage $stockdamage)
    {


        $data = [];
        $data['DeletedBy'] = auth()->user()->Username;
        $data['DamageNo'] = $stockdamage->DamageNo;
        $data['DeletedDate'] = $this->datetime;
        $data['Status'] = 'D';

        $stockdamagedetails = StockDamageDetails::where('DamageNo',$stockdamage->DamageNo)->get();

 

        try {

            $deletestockdamage = StockDamage::where('DamageNo', $stockdamage->DamageNo)->update($data);

            

            if($deletestockdamage){

                foreach ($stockdamagedetails as $stockdamagedetail) {

                    //Increase Item Total Viss To FromWarehouse because of delete stock transfer
                    StockInWarehouse::where('WarehouseCode',$stockdamage->WarehouseNo)->where('ItemCode',$stockdamagedetail['ItemCode'])->increment('StockQty', $stockdamagedetail['TotalViss']);
                    
                    
                }
                
            }

            return redirect()->route('stockdamage')->with('success', 'Delete stockdamage successful');

        } catch (QueryException $e) {

            // return response()->json(['message' => $e->getMessage()]);

            return back()->with(['error' => $e->getMessage()]);
        } catch (Exception $e){

            return back()->with(['error' => $e->getMessage()]);
        }
    }

}
