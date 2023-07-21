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
                    ->select('items.ItemCode', 'items.ItemName', 'stock_in_warehouses.StockQty','stock_in_warehouses.WarehouseCode')
                    ->orderBy('items.ItemCode')
                    ->get();

                    $stockLevels = [];

                    foreach ($stockitems as $item) {

                        if ($item->StockQty <= 10) {

                            $stockLevels[$item->ItemCode] = 'Low';

                        } else {

                            $stockLevels[$item->ItemCode] = 'High';
                            
                        }
                    }

                  
                    // dd($stockLevels);
        
        $warehouses = Warehouse::all();

        return view('setup.item.index',[
            'items' => $items,
            'warehouses' => $warehouses,
            'stockLevels' => $stockLevels
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

        $formData = request()->validate([
           
            'ItemName'=>['required'],
            'ItemCategoryCode' => ['required'],
            'BaseUnit' => ['required'],
            'UnitPrice' => ['required'],
            'LastPurPrice' => ['required'],
        ]);

        $ItemCode = GenerateId::generatePrimaryKeyId('items','ItemCode','SI-'); 
        $formData['ItemCode'] = $ItemCode;

        $formData['Discontinued'] = request('Discontinued');
        if ($formData['Discontinued'] == "on") {
            $formData['Discontinued'] = 1;
        } else {
            $formData['Discontinued'] = 0;
        }
        $formData['WeightByPrice'] = request('WeightByPrice');
        $formData['DefSalesUnit'] = request('DefSalesUnit');
        $formData['DefPurUnit'] = request('DefPurUnit');
        $formData['Remark'] = request('Remark');
        $formData['ModifiedDate'] = null;
        $formData['CreatedBy'] = auth()->user()->Username;

        
      
      
        try{

            $newitem = Item::create($formData);

            if($newitem){
                $WarehouseCodes = Warehouse::select('WarehouseCode')->get();

                foreach ($WarehouseCodes as $WarehouseCode) {
                    $stockdata = [];

                    $stockdata['WarehouseCode'] = $WarehouseCode->WarehouseCode;
                    $stockdata['ItemCode'] = $ItemCode;
                    $stockdata['StockQty'] = 0;
                    $stockdata['LastUpdatedDate'] = $this->datetime;

                    try {
                        StockInWarehouse::create($stockdata);

                    } catch (QueryException $e) {
                        return back()->with(['error' => $e->getMessage()]);
                    }
                
                }
            }

            return redirect('/item/add')->with('success','Item Create Successfully');

        }catch(QueryException $e){

            return back()->with(['error' => $e->getMessage()]);
            
        }

    }

    public function show(Item $item){

        $stockitemsqty = Item::join('stock_in_warehouses', 'items.ItemCode', '=', 'stock_in_warehouses.ItemCode')
                    ->select('items.ItemCode', 'items.ItemName', 'stock_in_warehouses.StockQty','stock_in_warehouses.WarehouseCode')
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
        $formData = request()->validate([
          
            'ItemCode' => ['required'],
            'ItemName'=>['required'],
            'ItemCategoryCode' => ['required'],
            'BaseUnit' => ['required'],
            'UnitPrice' => ['required'],
            'LastPurPrice' => ['required'],
        ]);

        $formData['Discontinued'] = request('Discontinued');
        if ($formData['Discontinued'] == "on") {
            $formData['Discontinued'] = 1;
        } else {
            $formData['Discontinued'] = 0;
        }
        $formData['WeightByPrice'] = request('WeightByPrice');
        $formData['DefSalesUnit'] = request('DefSalesUnit');
        $formData['DefPurUnit'] = request('DefPurUnit');
        $formData['Remark'] = request('Remark');
        $formData['ModifiedDate'] = $this->datetime;
        $formData['Modifiedby'] = auth()->user()->Username;
        
        try{

            $newunit = Item::where('ItemCode',$item->ItemCode)->update($formData);

            return redirect('/item/index')->with('success','Update Item Successfully');

        } catch(QueryException $e){

            return back()->with(['error' => $e->getMessage()]);

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
