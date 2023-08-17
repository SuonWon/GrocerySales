<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\GenerateId;
use App\Models\Item;
use App\Models\StockAdjustment;
use App\Models\StockAdjustmentDetails;
use App\Models\StockInWarehouse;

use App\Models\UnitMeasurement;
use App\Models\Warehouse;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class StockAdjustmentController extends Controller
{
    protected $datetime;
   

    public function __construct()
    {
        $this->datetime = Date('Y-m-d H:i:s');
        
    }

    public function index(Request $request){
        $query = StockAdjustment::orderBy('stock_adjustments.AdjustmentDate', 'desc')
        ->Join('warehouses', 'stock_adjustments.Warehouse', '=', 'warehouses.WarehouseCode')
        ->select('stock_adjustments.*','warehouses.WarehouseCode','warehouses.WarehouseName')
        ->where(function($query){
            $query->where('stock_adjustments.Status', 'O');
        });

        $deletequery = StockAdjustment::orderBy('stock_adjustments.AdjustmentDate', 'desc')
                    ->Join('warehouses', 'stock_adjustments.Warehouse', '=', 'warehouses.WarehouseCode')
                    ->select('stock_adjustments.*','warehouses.WarehouseCode','warehouses.WarehouseName')
                    ->where(function($query){
                        $query->where('stock_adjustments.Status', 'D');
                    });


        if ($request->input('StartDate') !== null && $request->input('EndDate') !== null) {
        $startDate = $request->input('StartDate');
        $endDate = $request->input('EndDate');



        if($endDate < $startDate){
            return back()->with('warning','start date must be lower than end date');
        }

        $query->whereBetween('AdjustmentDate', [$startDate, $endDate]);

        $deletequery->whereBetween('AdjustmentDate', [$startDate, $endDate]);



        } else if ($request->input('StartDate') !== null && $request->input('EndDate') == null) {

        $query->where('AdjustmentDate', '>=', $request->input('StartDate'));

        $deletequery->where('AdjustmentDate', '>=', $request->input('StartDate'));



        } else if ($request->input('StartDate') == null && $request->input('EndDate') !== null) {

        $query->where('AdjustmentDate', '<=', $request->input('EndDate'));

        $deletequery->where('AdjustmentDate', '<=', $request->input('EndDate'));



        } else {
        // If both startDate and endDate are null, retrieve records for the current month

        $query->where('AdjustmentDate', '>=', Carbon::now()->subMonths(6)->startOfMonth()->toDateString())
                ->where('AdjustmentDate', '<=', Carbon::now()->endOfMonth()->toDateString());

        $deletequery->where('AdjustmentDate', '>=', Carbon::now()->subMonths(6)->startOfMonth()->toDateString())
            ->where('AdjustmentDate', '<=', Carbon::now()->endOfMonth()->toDateString());

        }

        $CompleteStatus = $request->input('CompleteStatus');

        if ($CompleteStatus === 'complete') {

        $query->where('Status', 'O');

        }else if($CompleteStatus == "delete"){

        $query->where('Status', 'D');

        }else if($CompleteStatus == "all"){

        $query->orwhere('Status', 'O')->orwhere('Status','D');

        }

        $AdjustmentNo = $request->input('AdjustmentNo');

        if($AdjustmentNo != null){
            $query->where('AdjustmentNo', 'LIKE', '%' . $AdjustmentNo . '%');
        }



        $stockadjustments = $query->get();
        $deletestockadjustments = $deletequery->get();

        dd($stockadjustments);

        return view('stock.stockadjustment.index',[
        'stockadjustments' => $stockadjustments,
        'deletestockadjustments' => $deletestockadjustments
        ]);
       
    }

    

    public function create()
    {
        $items = Item::where('Discontinued','==',1)->get();
        $warehouses = Warehouse::all();
        

        $units = UnitMeasurement::where('IsActive', 1)->get();

  
        return view('stock.stockadjustment.add',[
            'items' => $items,
            'warehouses' => $warehouses,
            'units' => $units
        ]);
    }

    public function store(){

        $jsonData = json_decode(request()->getContent(), true);
        

        // Validate the JSON data
        $formData = Validator::make($jsonData, [

            'AdjustmentDate' => ['required'],
            'Warehouse' => ['required'],
            'Remark' => ['nullable'],
            'Status' => ['required'],
            
            'stockadjustmentdetails' => ['required']
        ])->validate();

        $AdjustmentNo = GenerateId::generatePrimaryKeyId('stock_adjustments', 'AdjustmentNo', 'AD-', true);

        $formData['AdjustmentNo'] = $AdjustmentNo;

        

        $stockadjustmentdetails = $formData['stockadjustmentdetails'];
   
        // Add additional data to the form data
        $formData['CreatedBy'] = auth()->user()->Username;
        $formData['ModifiedDate'] = null;

        try {
            // Create a new sales invoice record
            $newStockAdjustment = StockAdjustment::create($formData);

            if (isset($newStockAdjustment)) {



                foreach ($stockadjustmentdetails as $stockadjustmentdetail) {


                    $data = [];
                    $data['AdjustmentNo'] = $AdjustmentNo;
                    


                    
                    $data['LineNo'] = $stockadjustmentdetail['LineNo'];
                   
                    $data['ItemCode'] = $stockadjustmentdetail['ItemCode'];
                    $data['Quantity'] = $stockadjustmentdetail['Quantity'];
                    
                    $data['PackedUnit'] = $stockadjustmentdetail['PackedUnit'];
                    $data['QtyPerUnit'] = $stockadjustmentdetail['QtyPerUnit'];
                    $data['TotalViss'] = $stockadjustmentdetail['TotalViss'];
                    
                    $data['UnitPrice'] = $stockadjustmentdetail['UnitPrice'];
                    $data['Amount'] = $stockadjustmentdetail['Amount'];
                    $data['AdjustType'] = $stockadjustmentdetail['AdjustType'];
                     
                    // $warehouseCode = $stockdamagedetail['WarehouseNo'];
                    // $ItemCode = $stocktransferdetail['ItemCode'];
                    // $totalViss = $stocktransferdetail['TotalViss'];

                    try {

                        //logger($data);
                        $newStockAdjustmentDetails = StockAdjustmentDetails::create($data);

                        if($stockadjustmentdetail['AdjustType'] == "add"){
                            StockInWarehouse::where('WarehouseCode',$formData['Warehouse'])->where('ItemCode',$stockadjustmentdetail['ItemCode'])->increment('StockQty', $stockadjustmentdetail['TotalViss']);
                        }else if($stockadjustmentdetail['AdjustType'] == "minus"){
                            StockInWarehouse::where('WarehouseCode',$formData['Warehouse'])->where('ItemCode',$stockadjustmentdetail['ItemCode'])->decrement('StockQty', $stockadjustmentdetail['TotalViss']);
                        }

                       
                        

                      

                    } catch (QueryException $e) {

                        return response()->json(['message' => $e->getMessage()]);
                    }
                }

                return response()->json(['message' => "good", 'AdjustmentNo' => $AdjustmentNo]);
            }
        } catch (QueryException $e) {

            return response()->json(['message' => $e->getMessage()]);
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function show(StockAdjustment $stockadjustment)
    {

        $stockadjustmentdetails = StockAdjustmentDetails::orderBy('LineNo', 'asc')
            ->where('AdjustmentNo', $stockadjustment->AdjustmentNo)
            ->join('items', 'stock_adjustment_details.ItemCode', '=', 'items.ItemCode')
            ->join('unit_measurements', 'stock_adjustment_details.PackedUnit', '=', 'unit_measurements.UnitCode')
            ->select('stock_adjustment_details.*', 'items.ItemCode', 'items.ItemName', 'unit_measurements.UnitCode', 'unit_measurements.UnitDesc')
            ->get();

        $stockadjustment->stockadjustmentdetails = $stockadjustmentdetails;

        $warehouses = Warehouse::all();
        $items = Item::where('Discontinued', '=', 1)->get()->sortBy('ItemName');
        $units = UnitMeasurement::where('IsActive', 1)->get();

      
        dd($stockadjustment);
        return view('stock.stockadjustment.edit', [
            'stockadjustment' => $stockadjustment,
            'warehouses' => $warehouses,
            'items' => $items,
            'units' => $units
        ]);
    }

    public function update(StockAdjustment $stockadjustment){

        $jsonData = json_decode(request()->getContent(), true);
        
        
        // Validate the JSON data
        $formData = Validator::make($jsonData, [

            
            'AdjustmentDate' => ['required'],
            'Warehouse' => ['required'],
            'OldWarehouse' => ['required'],
            
            'Remark' => ['nullable'],
            'Status' => ['required'],
             
            'stockadjustmentdetails' => ['required']
            
            
        ])->validate();

        $OldWarehouse = $formData['OldWarehouse'];
        

        $formData['AdjustmentNo'] = $stockadjustment->AdjustmentNo;
        $formData['ModifiedBy'] = auth()->user()->Username;
        $formData['ModifiedDate'] = $this->datetime;

        
        $stockadjustmentdetails = $formData['stockadjustmentdetails'];
        unset($formData['stockadjustmentdetails'],$formData['OldWarehouse']);

        try {
            // Create a new sales invoice record
            $updateStockDamage = StockAdjustment::where('AdjustmentNo', $stockadjustment->AdjustmentNo)->update($formData);

            if (isset($updateStockDamage)) {

                
                StockAdjustmentDetails::where('AdjustmentNo',$stockadjustment->AdjustmentNo)->delete();



                foreach ($stockadjustmentdetails as $stockadjustmentdetail) {
                    

                    $data = [];
                    $data['AdjustmentNo'] = $stockadjustment->AdjustmentNo;
                                            
                    $data['LineNo'] = $stockadjustmentdetail['LineNo'];
                   
                    $data['ItemCode'] = $stockadjustmentdetail['ItemCode'];
                    $data['Quantity'] = $stockadjustmentdetail['Quantity'];
                    
                    $data['PackedUnit'] = $stockadjustmentdetail['PackedUnit'];
                    $data['QtyPerUnit'] = $stockadjustmentdetail['QtyPerUnit'];
                    $data['TotalViss'] = $stockadjustmentdetail['TotalViss'];
                    
                    $data['UnitPrice'] = $stockadjustmentdetail['UnitPrice'];
                    $data['Amount'] = $stockadjustmentdetail['Amount'];
                    $data['AdjustType'] = $stockadjustmentdetail['AdjustType'];
                    
                    // $warehouseCode = $stocktransferdetail['WarehouseNo'];
                    // $ItemCode = $stocktransferdetail['ItemCode'];
                    // $totalViss = $stocktransferdetail['TotalViss'];
                    //140   => 310 
                    try {

                        if($stockadjustmentdetail['OldAdjustType'] == "add"){
                            StockInWarehouse::where('WarehouseCode',$OldWarehouse)->where('ItemCode',$stockadjustmentdetail['OldItemCode'])->decrement('StockQty', $stockadjustmentdetail['OldTotalViss']);
                        }else if($stockadjustmentdetail['OldAdjustType'] == "minus"){
                            StockInWarehouse::where('WarehouseCode',$OldWarehouse)->where('ItemCode',$stockadjustmentdetail['OldItemCode'])->increment('StockQty', $stockadjustmentdetail['OldTotalViss']);
                        }

                        //logger($data);
                        $newStockAdjustmentDetails = StockAdjustmentDetails::create($data);


                        if($stockadjustmentdetail['AdjustType'] == "add"){
                            StockInWarehouse::where('WarehouseCode',$formData['Warehouse'])->where('ItemCode',$stockadjustmentdetail['ItemCode'])->increment('StockQty', $stockadjustmentdetail['TotalViss']);
                        }else if ($stockadjustmentdetail['AdjustType'] == "minus"){
                            StockInWarehouse::where('WarehouseCode',$formData['Warehouse'])->where('ItemCode',$stockadjustmentdetail['ItemCode'])->decrement('StockQty', $stockadjustmentdetail['TotalViss']);
                        }
                        
                        

                       

                      
                        


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

    public function destory(StockAdjustment $stockadjustment)
    {
        

        $data = [];
        $data['DeletedBy'] = auth()->user()->Username;
        $data['AdjustmentNo'] = $stockadjustment->AdjustmentNo;
        $data['DeletedDate'] = $this->datetime;
        $data['Status'] = 'D';

        $stockadjustmentdetails = StockAdjustmentDetails::where('AdjustmentNo',$stockadjustment->AdjustmentNo)->get();
        
      

        try {

            $deletestockadjustment = StockAdjustment::where('AdjustmentNo', $stockadjustment->AdjustmentNo)->update($data);

            

            if($deletestockadjustment){

                foreach ($stockadjustmentdetails as $stockadjustmentdetail) {

                    
                    if($stockadjustmentdetail['AdjustType'] == "add"){
                        StockInWarehouse::where('WarehouseCode',$stockadjustment->Warehouse)->where('ItemCode',$stockadjustmentdetail['ItemCode'])->decrement('StockQty', $stockadjustmentdetail['TotalViss']);
                    }else if ($stockadjustmentdetail['AdjustType'] == "minus"){
                        StockInWarehouse::where('WarehouseCode',$stockadjustment->Warehouse)->where('ItemCode',$stockadjustmentdetail['ItemCode'])->increment('StockQty', $stockadjustmentdetail['TotalViss']);
                    }
                    
                   
                    

              
                    
                    

                    
                    
                }
                
            }

            return redirect()->route('stockadjustment')->with('success', 'Delete stockadjustment successful');

        } catch (QueryException $e) {

            // return response()->json(['message' => $e->getMessage()]);

            return back()->with(['error' => $e->getMessage()]);
        } catch (Exception $e){

            return back()->with(['error' => $e->getMessage()]);
        }
    }
}
