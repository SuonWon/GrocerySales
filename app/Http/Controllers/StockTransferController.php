<?php

namespace App\Http\Controllers;

use App\Models\GenerateId;
use App\Models\Item;
use App\Models\StockInWarehouse;
use App\Models\StockTransfer;
use App\Models\StockTransferDetails;
use App\Models\UnitMeasurement;
use App\Models\Warehouse;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockTransferController extends Controller
{
    protected $datetime;
   

    public function __construct()
    {
        $this->datetime = Date('Y-m-d H:i:s');
       
    }

    //warehouses , items , units
    public function index(Request $request){

        $query = StockTransfer::orderBy('stock_transfers.TransferDate', 'desc')
                    ->select('stock_transfers.*', 'fw.WarehouseName as FromWarehouse','fw.WarehouseCode as FromWarehouseCode', 'tw.WarehouseName as ToWarehouse','tw.WarehouseCode as ToWarehouseCode')
                    ->leftJoin('warehouses as fw', 'stock_transfers.FromWarehouse', '=', 'fw.WarehouseCode')
                    ->leftJoin('warehouses as tw', 'stock_transfers.ToWarehouse', '=', 'tw.WarehouseCode')
                    ->where(function($query){
                        $query->where('stock_transfers.Status', 'O');
                    });

        $deletequery = StockTransfer::orderBy('stock_transfers.TransferDate', 'desc')
                    ->select('stock_transfers.*', 'fw.WarehouseName as FromWarehouse','fw.WarehouseCode as FromWarehouseCode', 'tw.WarehouseName as ToWarehouse','tw.WarehouseCode as ToWarehouseCode')
                    ->leftJoin('warehouses as fw', 'stock_transfers.FromWarehouse', '=', 'fw.WarehouseCode')
                    ->leftJoin('warehouses as tw', 'stock_transfers.ToWarehouse', '=', 'tw.WarehouseCode')
                    ->where(function($delquery){
                        $delquery->where('stock_transfers.Status', 'D');
                    });

        
        if ($request->input('StartDate') !== null && $request->input('EndDate') !== null) {
            $startDate = $request->input('StartDate');
            $endDate = $request->input('EndDate');

            

            if($endDate < $startDate){
                return back()->with('warning','start date must be lower than end date');
            }

            $query->whereBetween('TransferDate', [$startDate, $endDate]);

            $deletequery->whereBetween('TransferDate', [$startDate, $endDate]);

            

        } else if ($request->input('StartDate') !== null && $request->input('EndDate') == null) {

            $query->where('TransferDate', '>=', $request->input('StartDate'));

            $deletequery->where('TransferDate', '>=', $request->input('StartDate'));

            

        } else if ($request->input('StartDate') == null && $request->input('EndDate') !== null) {

            $query->where('TransferDate', '<=', $request->input('EndDate'));

            $deletequery->where('TransferDate', '<=', $request->input('EndDate'));

            

        } else {
            // If both startDate and endDate are null, retrieve records for the current month
        
            $query->where('TransferDate', '>=', Carbon::now()->subMonths(6)->startOfMonth()->toDateString())
                    ->where('TransferDate', '<=', Carbon::now()->endOfMonth()->toDateString());

            $deletequery->where('TransferDate', '>=', Carbon::now()->subMonths(6)->startOfMonth()->toDateString())
                ->where('TransferDate', '<=', Carbon::now()->endOfMonth()->toDateString());
        
        }

        $CompleteStatus = $request->input('CompleteStatus');

        if ($CompleteStatus === 'complete') {

            $query->where('Status', 'O');

        }else if($CompleteStatus == "delete"){

            $query->where('Status', 'D');

        }else if($CompleteStatus == "all"){

            $query->orwhere('Status', 'O')->orwhere('Status','D');

        }

        $TransferNo = $request->input('TransferNo');

        if($TransferNo != null){
                $query->where('PlateNo', 'LIKE', '%' . $TransferNo . '%');
        }
        
        
        
        $stocktransfers = $query->get();
        $deletestocktransfers = $deletequery->get();
  
        return view('stock.stocktransfer.index',[
            'stocktransfers' => $stocktransfers,
            'deletestocktransfers' => $deletestocktransfers
        ]);
    }

    public function create()
    {
        $items = Item::where('Discontinued','==',1)->get();
        $warehouses = Warehouse::all();
        

        $units = UnitMeasurement::where('IsActive', 1)->get();

  
        return view('stock.stocktransfer.index',[
            'items' => $items,
            'warehouses' => $warehouses,
            'units' => $units
        ]);
    }

    public function store(){

        $jsonData = json_decode(request()->getContent(), true);
        

        // Validate the JSON data
        $formData = Validator::make($jsonData, [

            'TransferDate' => ['required'],
            'FromWarehouse' => ['required'],
            'ToWarehouse' => ['required'],
            'Remark' => ['nullable'],
            'Status' => ['required'],
            
            'stocktransferdetails' => ['required']
        ])->validate();

        $TransferNo = GenerateId::generatePrimaryKeyId('stock_transfers', 'TransferNo', 'TF-', true);

        $formData['TransferNo'] = $TransferNo;

        

        $stocktransferdetails = $formData['stocktransferdetails'];

        // Add additional data to the form data
        $formData['CreatedBy'] = auth()->user()->Username;
        $formData['ModifiedDate'] = null;

        try {
            // Create a new sales invoice record
            $newStockTransfer = StockTransfer::create($formData);

            if (isset($newStockTransfer)) {



                foreach ($stocktransferdetails as $stocktransferdetail) {


                    $data = [];
                    $data['TransferNo'] = $TransferNo;
                    


                    
                    $data['LineNo'] = $stocktransferdetail['LineNo'];
                   
                    $data['ItemCode'] = $stocktransferdetail['ItemCode'];
                    $data['Quantity'] = $stocktransferdetail['Quantity'];
                    
                    $data['PackedUnit'] = $stocktransferdetail['PackedUnit'];
                    $data['QtyPerUnit'] = $stocktransferdetail['QtyPerUnit'];
                    $data['TotalViss'] = $stocktransferdetail['TotalViss'];
                    
                    $data['UnitPrice'] = $stocktransferdetail['UnitPrice'];
                    $data['Amount'] = $stocktransferdetail['Amount'];
                    
                    // $warehouseCode = $stocktransferdetail['WarehouseNo'];
                    // $ItemCode = $stocktransferdetail['ItemCode'];
                    // $totalViss = $stocktransferdetail['TotalViss'];

                    try {

                        //logger($data);
                        $newStockTransferDetails = StockTransferDetails::create($data);

                        //Decrease Item Total Viss From FromWarehouse
                        StockInWarehouse::where('WarehouseCode',$formData['FromWarehouse'])->where('ItemCode',$stocktransferdetail['ItemCode'])->decrement('StockQty', $stocktransferdetail['TotalViss']);

                        //Increase Item Total Viss To ToWarehouse
                        StockInWarehouse::where('WarehouseCode',$formData['ToWarehouse'])->where('ItemCode',$stocktransferdetail['ItemCode'])->increment('StockQty', $stocktransferdetail['TotalViss']);

                    } catch (QueryException $e) {

                        return response()->json(['message' => $e->getMessage()]);
                    }
                }

                return response()->json(['message' => "good", 'TransferNo' => $TransferNo]);
            }
        } catch (QueryException $e) {

            return response()->json(['message' => $e->getMessage()]);
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function show(StockTransfer $stocktransfer)
    {

        $stocktransferdetails = StockTransferDetails::orderBy('LineNo', 'asc')
            ->where('TransferNo', $stocktransfer->TransferNo)
            ->join('items', 'stock_transfer_details.ItemCode', '=', 'items.ItemCode')
            ->join('unit_measurements', 'stock_transfer_details.PackedUnit', '=', 'unit_measurements.UnitCode')
            ->select('stock_transfer_details.*', 'items.ItemCode', 'items.ItemName', 'unit_measurements.UnitCode', 'unit_measurements.UnitDesc')
            ->get();

        $stocktransfer->stocktransferdetails = $stocktransferdetails;

        $warehouses = Warehouse::all();
        $items = Item::where('Discontinued', '=', 1)->get()->sortBy('ItemName');
        $units = UnitMeasurement::where('IsActive', 1)->get();

      
        return view('stock.stocktransfer.edit', [
            'stocktransfer' => $stocktransfer,
            'warehouses' => $warehouses,
            'items' => $items,
            'units' => $units
        ]);
    }

    public function update(StockTransfer $stocktransfer){

        $jsonData = json_decode(request()->getContent(), true);
        
        return response()->json(['message' => $jsonData]);
        // Validate the JSON data
        $formData = Validator::make($jsonData, [

            
            'TransferDate' => ['required'],
            'FromWarehouse' => ['required'],
            'OldFromWarehouse' => ['required'],
            'OldToWarehouse' => ['required'],
            'ToWarehouse' => ['required'],
            'Remark' => ['nullable'],
            'Status' => ['required'],
            
            'stocktransferdetails' => ['required']
        ])->validate();

        $OldFromWarehouse = $formData['OldFromWarehouse'];
        $OldToWarehouse = $formData['OldToWarehouse'];

        $formData['TransferNo'] = $stocktransfer->TransferNo;
        $formData['ModifiedBy'] = auth()->user()->Username;
        $formData['ModifiedDate'] = $this->datetime;

        
        $stocktransferdetails = $formData['stocktransferdetails'];
        unset($formData['stocktransferdetails'],$formData['OldToWarehouse'],$formData['OldFromWarehouse']);

        try {
            // Create a new sales invoice record
            $updateStockTransfer = StockTransfer::where('TransferNo', $stocktransfer->TransferNo)->update($formData);

            if (isset($updateStockTransfer)) {

                
                StockTransferDetails::where('TransferNo',$stocktransfer->TransferNo)->delete();



                foreach ($stocktransferdetails as $stocktransferdetail) {


                    $data = [];
                    $data['TransferNo'] = $stocktransfer->TransferNo;
                                            
                    $data['LineNo'] = $stocktransferdetail['LineNo'];
                   
                    $data['ItemCode'] = $stocktransferdetail['ItemCode'];
                    $data['Quantity'] = $stocktransferdetail['Quantity'];
                    
                    $data['PackedUnit'] = $stocktransferdetail['PackedUnit'];
                    $data['QtyPerUnit'] = $stocktransferdetail['QtyPerUnit'];
                    $data['TotalViss'] = $stocktransferdetail['TotalViss'];
                    
                    $data['UnitPrice'] = $stocktransferdetail['UnitPrice'];
                    $data['Amount'] = $stocktransferdetail['Amount'];
                    
                    // $warehouseCode = $stocktransferdetail['WarehouseNo'];
                    // $ItemCode = $stocktransferdetail['ItemCode'];
                    // $totalViss = $stocktransferdetail['TotalViss'];

                    try {

                        //logger($data);
                        $newStockTransferDetails = StockTransferDetails::create($data);

                        //Decrease  Item Total Viss From ToWarehouse becuase of update
                        StockInWarehouse::where('WarehouseCode',$OldToWarehouse)->where('ItemCode',$stocktransferdetail['OldItemCode'])->decrement('StockQty', $stocktransferdetail['OldTotalViss']);

                        //Increase Item Total Viss To FromWarehouse because of update
                        StockInWarehouse::where('WarehouseCode',$OldFromWarehouse)->where('ItemCode',$stocktransferdetail['OldItemCode'])->increment('StockQty', $stocktransferdetail['OldTotalViss']);

                        //Decrease Item Total Viss From FromWarehouse
                        StockInWarehouse::where('WarehouseCode',$formData['FromWarehouse'])->where('ItemCode',$stocktransferdetail['ItemCode'])->decrement('StockQty', $stocktransferdetail['TotalViss']);

                        //Increase Item Total Viss To ToWarehouse
                        StockInWarehouse::where('WarehouseCode',$formData['ToWarehouse'])->where('ItemCode',$stocktransferdetail['ItemCode'])->increment('StockQty', $stocktransferdetail['TotalViss']);

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

    public function destory(StockTransfer $stocktransfer)
    {


        $data = [];
        $data['DeletedBy'] = auth()->user()->Username;
        $data['TransferNo'] = $stocktransfer->TransferNo;
        $data['DeletedDate'] = $this->datetime;
        $data['Status'] = 'D';

        $stocktransferdetails = StockTransferDetails::where('TransferNo',$stocktransfer->TransferNo)->get();

 

        try {

            $deletestocktransfer = StockTransfer::where('TransferNo', $stocktransfer->TransferNo)->update($data);

            

            if($deletestocktransfer){

                foreach ($stocktransferdetails as $stocktransferdetail) {

                    //Increase Item Total Viss To FromWarehouse because of delete stock transfer
                    StockInWarehouse::where('WarehouseCode',$stocktransfer->FromWarehouse)->where('ItemCode',$stocktransferdetail['ItemCode'])->increment('StockQty', $stocktransferdetail['TotalViss']);

                    //Decrease Item Total Viss From ToWarehouse because of delete stock transfer
                    StockInWarehouse::where('WarehouseCode',$stocktransfer->ToWarehouse)->where('ItemCode',$stocktransferdetail['ItemCode'])->decrement('StockQty', $stocktransferdetail['TotalViss']);
                    
                    

                    
                    
                }
                
            }

            return redirect()->route('stocktransfer')->with('success', 'Delete stocktransfer successful');

        } catch (QueryException $e) {

            // return response()->json(['message' => $e->getMessage()]);

            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function restore(StockTransfer $stocktransfer)
    {


        $data = [];
        $data['DeletedBy'] = null;
        $data['TransferNo'] = $stocktransfer->TransferNo;
        $data['DeletedDate'] = null;
        $data['Status'] = 'O';

        $stocktransferdetails = StockTransferDetails::where('TransferNo',$stocktransfer->TransferNo)->get();

        try {

            $deletesaleinvoice = StockTransfer::where('TransferNo', $stocktransfer->TransferNo)->update($data);

        

            if($deletesaleinvoice){

                foreach ($stocktransferdetails as $stocktransferdetail) {

                    //Decrease Item Total Viss From FromWarehouse because of restore stock transfer
                    StockInWarehouse::where('WarehouseCode',$stocktransfer->FromWarehouse)->where('ItemCode',$stocktransferdetail['ItemCode'])->decrement('StockQty', $stocktransferdetail['TotalViss']);

                    //Increase Item Total Viss To ToWarehouse because of restore stock transfer
                    StockInWarehouse::where('WarehouseCode',$stocktransfer->ToWarehouse)->where('ItemCode',$stocktransferdetail['ItemCode'])->increment('StockQty', $stocktransferdetail['TotalViss']);

                    
                    
                }
                
            }

            return redirect()->route('stocktransfer')->with('success', 'Restore stocktransfer successful');
            
        } catch (QueryException $e) {

            // return response()->json(['message' => $e->getMessage()]);

            return back()->with(['error' => $e->getMessage()]);
        }
    }



}
