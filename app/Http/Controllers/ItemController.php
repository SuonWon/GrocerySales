<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\UnitMeasurement;
use App\Models\CompanyInformation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\GenerateId;
use App\Models\StockInWarehouse;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\FuncCall;

class ItemController extends Controller
{
    protected $datetime;

    public function __construct()
    {
        $this->datetime = Date('Y-m-d H:i:s');
        // dd($this->datetime);
    }

    public function index(){
        
        $items = Item::orderBy('items.CreatedDate','desc')
        ->join('item_categories', 'items.ItemCategoryCode', '=', 'item_categories.ItemCategoryCode')
        ->join('unit_measurements','items.BaseUnit','=','unit_measurements.UnitCode')
        ->selectRaw('items.ItemCategoryCode,items.ItemName,items.ItemCode,items.BaseUnit,items.UnitPrice,items.WeightByPrice,items.DefSalesUnit,items.DefPurUnit,items.LastPurPrice,items.Discontinued,items.Remark,items.CreatedBy,items.CreatedDate,items.ModifiedDate,items.ModifiedBy')
        ->selectRaw('item_categories.ItemCategoryCode, item_categories.ItemCategoryName')
        ->selectRaw('unit_measurements.UnitCode, unit_measurements.UnitDesc')
        ->get();

        $stockitems = Item::join('stock_in_warehouses', 'items.ItemCode', '=', 'stock_in_warehouses.ItemCode')
            ->select('items.ItemCode', 'items.ItemName', 'stock_in_warehouses.StockQty', 'stock_in_warehouses.WarehouseCode')
            ->selectRaw('CASE WHEN stock_in_warehouses.StockQty < 10 THEN "low" ELSE "high" END as StockAlert')
            ->orderBy('items.ItemCode')
            ->get();

        // $stockitems = Item::join('stock_in_warehouses', 'items.ItemCode', '=', 'stock_in_warehouses.ItemCode')
        //     ->select('items.ItemCode', 'items.ItemName', 'stock_in_warehouses.StockQty','stock_in_warehouses.WarehouseCode')
        //     ->orderBy('items.ItemCode')
        //     ->get();

        // $stockLevels = [];

        // foreach ($stockitems as $item) {

        //     if ($item->StockQty <= 10) {

        //         $stockLevels[] = $item->ItemCode ;
                

        //     } else {

        //         $stockLevels[$item->ItemCode] = 'High';
                
        //     }
            
        // }

                  
                    // dd($stockLevels);
        
        $warehouses = Warehouse::all();

        return view('setup.item.index',[
            'items' => $items,
            'warehouses' => $warehouses,
            'stockitems' => $stockitems
        ]);
    }

    public function create(){

        $units = UnitMeasurement::all();

        $categories = ItemCategory::all();

        $warehouses = Warehouse::all();
        
        return view('setup.item.add',[
            'units' => $units,
            'categories' => $categories,
            'warehouses' => $warehouses,
        ]);
    }

    public function store(){

        $jsonData = json_decode(request()->getContent(), true);

        // return response()->json(['message' => $jsonData]);
        $formData = Validator::make($jsonData, [

            'ItemName'=>['required'],
            'ItemCategoryCode' => ['required'],
            'BaseUnit' => ['required'],
            'UnitPrice' => ['required'],
            'LastPurPrice' => ['required'],
            'WeightByPrice' => ['nullable'],
            'DefSalesUnit' => ['nullable'],
            'DefPurUnit' => ['nullable'],
            'Remark' => ['nullable'],
            'Discontinued' => ['nullable'],
            'StockInWarehouses' => ['required']


        ])->validate();

        

        $ItemCode = GenerateId::generatePrimaryKeyId('items','ItemCode','SI-'); 
        $formData['ItemCode'] = $ItemCode;

    
        if ($formData['Discontinued'] == "on") {
            $formData['Discontinued'] = 1;
        } else {
            $formData['Discontinued'] = 0;
        }
 
        $formData['ModifiedDate'] = null;
        $formData['CreatedBy'] = auth()->user()->Username;

        
        $stockinwarehouses = $formData['StockInWarehouses'];
        
        try{

            $newitem = Item::create($formData);
         
            if($newitem){
               

                foreach ($stockinwarehouses as $stockinwarehouse) {
                    $stockdata = [];
                   
                    $stockdata['WarehouseCode'] = $stockinwarehouse['WarehouseCode'];
                    $stockdata['ItemCode'] = $ItemCode;
                    $stockdata['StockQty'] = $stockinwarehouse['StockQty'];
                    if($stockinwarehouse['StockQty'] <= 0){

                        $stockdata['Status'] = 'N';
                        
                    }else if($stockinwarehouse['StockQty'] > 0){

                        $stockdata['Status'] = 'O';
                       
                    }
                    
                    $stockdata['LastUpdatedDate'] = $this->datetime;
                   
                    try {

                        StockInWarehouse::create($stockdata);

                    } catch (QueryException $e) {

                        return response()->json(['message' => $e->getMessage()]);
                    }
                
                }
            }

            // return redirect('/item/add')->with('success','Item Create Successfully');
            return response()->json(['message' => "good"]);

        }catch(QueryException $e){

            // return back()->with(['error' => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()]);
            
        }

    }

    public function show(Item $item){

        $stockitemsqty = Item::join('stock_in_warehouses', 'items.ItemCode', '=', 'stock_in_warehouses.ItemCode')
                    ->select('items.ItemCode', 'items.ItemName', 'stock_in_warehouses.StockQty','stock_in_warehouses.WarehouseCode','stock_in_warehouses.Status')
                    ->orderBy('items.ItemCode')
                    ->where('items.ItemCode',$item->ItemCode)
                    ->get();

        if ($item->Discontinued == 1) {
            $item->Discontinued = 'on';
        } else {
            $item->Discontinued = "off";
        }

        $units = UnitMeasurement::all();
        $categories = ItemCategory::all();
        $warehouses = Warehouse::all();

        return view('setup.item.edit',[
            'item' => $item,
            'units' => $units,
            'categories' => $categories,
            'stockitemsqty' => $stockitemsqty,
            'warehouses' => $warehouses,
        ]);
    }

    public function update(Item $item){

        $jsonData = json_decode(request()->getContent(), true);

        $formData = Validator::make($jsonData, [
            
            'ItemName'=>['required'],
            'ItemCategoryCode' => ['required'],
            'BaseUnit' => ['required'],
            'UnitPrice' => ['required'],
            'LastPurPrice' => ['required'],
            'WeightByPrice' => ['nullable'],
            'DefSalesUnit' => ['nullable'],
            'DefPurUnit' => ['nullable'],
            'Remark' => ['nullable'],
            'Discontinued' => ['nullable'],
            'StockInWarehouses' => ['required']


        ])->validate();

        $stockinwarehouses = $formData['StockInWarehouses'];
        unset($formData['StockInWarehouses']);
        $ItemCode = $item->ItemCode;

        if ($formData['Discontinued'] == "on") {
            $formData['Discontinued'] = 1;
        } else {
            $formData['Discontinued'] = 0;
        }

        $formData['ModifiedDate'] = $this->datetime;
        $formData['Modifiedby'] = auth()->user()->Username;

        
        try{

            $newunit = Item::where('ItemCode',$item->ItemCode)->update($formData);

            if($newunit == 1){

                foreach ($stockinwarehouses as $stockinwarehouse) {

                    $stockdata = [];
                   
                    $stockdata['WarehouseCode'] = $stockinwarehouse['WarehouseCode'];
                    $stockdata['ItemCode'] = $item->ItemCode;
                    $stockdata['StockQty'] = $stockinwarehouse['StockQty'];

                    if($stockinwarehouse['StockQty'] <= 0){

                        $stockdata['Status'] = 'N';

                    }else if($stockinwarehouse['StockQty'] > 0){

                        $stockdata['Status'] = 'O';

                    }
                    
                    
                    $stockdata['LastUpdatedDate'] = $this->datetime;
                   
                    try {

                        $updateitem = StockInWarehouse::where('ItemCode',$item->ItemCode)->where('WarehouseCode',$stockinwarehouse['WarehouseCode'])->update($stockdata);

                        

                    } catch (QueryException $e) {

                        return response()->json(['message' => $e->getMessage()]);
                    }

                
                }
            } else {

                return response()->json(['message' => $newunit]);
                
            }

            return response()->json(['message' => "good"]);

        } catch(QueryException $e){

            
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    // Delete Item

    public function destory(Item $item){

        try{

            Item::where('ItemCode',$item->ItemCode)->delete();

            return redirect('/item/index')->with('success','Delete Item Successfully');

       } catch(QueryException $e) {

        if ($e->errorInfo[1] == 1451) {

            return back()->with(['error' => 'Cannot delete this record because it is referenced by another table.']);

        } else {

            return back()->with(['error' => $e->getMessage()]);

        }
        
       }

    }

    //Item Report
    public function itemreports(){
        
        $items = Item::orderBy('items.CreatedDate','desc')
        ->join('item_categories', 'items.ItemCategoryCode', '=', 'item_categories.ItemCategoryCode')
        ->join('unit_measurements','items.BaseUnit','=','unit_measurements.UnitCode')
        ->selectRaw('items.ItemCategoryCode,items.ItemName,items.ItemCode,items.BaseUnit,items.UnitPrice,items.DefSalesUnit,items.DefPurUnit,items.LastPurPrice,items.Discontinued,items.Remark,items.CreatedBy,items.CreatedDate,items.ModifiedDate,items.ModifiedBy')
        ->selectRaw('item_categories.ItemCategoryCode, item_categories.ItemCategoryName')
        ->selectRaw('unit_measurements.UnitCode, unit_measurements.UnitDesc')
        ->get();
        $companyinfo = CompanyInformation::first();

        return view('reports.itemreports',[
            'items' => $items,
            'companyinfo' => $companyinfo,       
        ]);
    }
}
