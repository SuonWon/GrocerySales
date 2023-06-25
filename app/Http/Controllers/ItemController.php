<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\UnitMeasurement;
use App\Models\CompanyInformation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\GenerateId;
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
        ->selectRaw('items.ItemCategoryCode,items.ItemName,items.ItemCode,items.BaseUnit,items.UnitPrice,items.DefSalesUnit,items.DefPurUnit,items.LastPurPrice,items.Discontinued,items.Remark,items.CreatedBy,items.CreatedDate,items.ModifiedDate,items.ModifiedBy')
        ->selectRaw('item_categories.ItemCategoryCode, item_categories.ItemCategoryName')
        ->selectRaw('unit_measurements.UnitCode, unit_measurements.UnitDesc')
        ->get();

        return view('setup.item.index',[
            'items' => $items       
        ]);
    }

    public function create(){
        $units = UnitMeasurement::all();
        $categories = ItemCategory::all();
        return view('setup.item.add',[
            'units' => $units,
            'categories' => $categories
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

        $formData['ItemCode'] = GenerateId::generatePrimaryKeyId('items','ItemCode','SI-'); 

        $formData['Discontinued'] = request('Discontinued');
        if ($formData['Discontinued'] == "on") {
            $formData['Discontinued'] = 1;
        } else {
            $formData['Discontinued'] = 0;
        }
        $formData['DefSalesUnit'] = request('DefSalesUnit');
        $formData['DefPurUnit'] = request('DefPurUnit');
        $formData['Remark'] = request('Remark');
        $formData['ModifiedDate'] = null;
        $formData['CreatedBy'] = auth()->user()->Username;
      
        //dd($formData);
        try{

            $newitem = Item::create($formData);

            return redirect('/item/add')->with('success','Item Create Successfully');

        }catch(QueryException $e){

            return back()->with(['error' => $e->getMessage()]);
            
        }

    }

    public function show(Item $item){

        if ($item->Discontinued == 1) {
            $item->Discontinued = 'on';
        } else {
            $item->Discontinued = "off";
        }

        $units = UnitMeasurement::all();
        $categories = ItemCategory::all();

        return view('setup.item.edit',[
            'item' => $item,
            'units' => $units,
            'categories' => $categories
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
