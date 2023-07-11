<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\CompanyInformation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\GenerateId;
use App\Models\Item;
use App\Models\StockInWarehouse;

class WarehouseController extends Controller
{
    protected $datetime;

    public function __construct()
    {


        $this->datetime = Date('Y-m-d H:i:s');

    }

    public function index(){
        $warehouses = Warehouse::all()->sortByDesc('CreatedDate');

       return view('setup.warehouse.index',[
            'warehouses' => $warehouses
       ]);
    }

    public function create(){
        return view('setup.warehouse.add');
    }

    public function store(){
        $formData = request()->validate([
            
            'WarehouseName'=>['required'],
             
        ]);

        $warehouseCode = GenerateId::generatePrimaryKeyId('warehouses', 'WarehouseCode', 'WH-');
        $formData['WarehouseCode'] = $warehouseCode;

        $formData['Street'] = request('Street');
        $formData['Township'] = request('Township');
        $formData['City'] = request('City');
        $formData['ContactNo'] = request('ContactNo');
        $formData['Remark'] = request('Remark');
        $formData['CreatedBy'] = auth()->user()->Username;
        $formData['ModifiedDate'] = null; 

        try{

            $newwarehouse = Warehouse::create($formData);

            if($newwarehouse){
                $ItemCodes = Item::select('ItemCode')->whereDiscontinued(1)->get();

                foreach ($ItemCodes as $ItemCode) {
                    $stockdata = [];

                    $stockdata['WarehouseCode'] = $warehouseCode;
                    $stockdata['ItemCode'] = $ItemCode->ItemCode;
                    $stockdata['StockQty'] = 0;
                    $stockdata['LastUpdatedDate'] = $this->datetime;

                    try {
                        StockInWarehouse::create($stockdata);

                    } catch (QueryException $e) {
                        return back()->with(['error' => $e->getMessage()]);
                    }
                }
            }

            return  redirect()->route('addwarehouse')->with('success','warehouse created successful');

        }catch(QueryException $e){

            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function show(Warehouse $warehouse){

           if($warehouse->Remark != null){
                    $warehouse->Remark = str_replace(' ','',$warehouse->Remark);
           }
            return view('setup.warehouse.edit',[
                'warehouse' => $warehouse
            ]);
    }

    public function update(Warehouse $warehouse){
            $formData = request()->validate([
            
                'WarehouseName'=>['required'],
                
            ]);
            $formData['WarehouseCode'] = $warehouse->WarehouseCode;
            $formData['Street'] = request('Street');
            $formData['Township'] = request('Township');
            $formData['City'] = request('City');
            $formData['ContactNo'] = request('ContactNo');
            $formData['Remark'] = request('Remark');
            $formData['ModifiedBy'] = auth()->user()->Username;
            $formData['ModifiedDate'] = $this->datetime;

            try{
                
                $updatewarehouse = Warehouse::where('WarehouseCode',$warehouse->WarehouseCode)->update($formData);

                return redirect()->route('warehouse')->with('success','update warehouse successful');

            } catch(QueryException $e){

                return back()->with(['error' => $e->getMessage()]);
            }
    }

    public function destory(Warehouse $warehouse){

        try {

            $deletewarehouse =  Warehouse::where('WarehouseCode',$warehouse->WarehouseCode)->delete();

            return redirect()->route('warehouse')->with('success','Delete Warehouse Successful');

        } catch (QueryException $e) {

            if ($e->errorInfo[1] == 1451) {

                return back()->with(['error' => 'Cannot delete this record because it is referenced by another table.']);

            } else {

                return back()->with(['error' => $e->getMessage()]);
                
            }
        }

    }

     //Warehouse Report
    public function warehousereports(){
        $warehouses = Warehouse::all()->sortByDesc('CreatedDate');
        $companyinfo = CompanyInformation::first();

        return view('reports.warehousereports',[
                'warehouses' => $warehouses,
                'companyinfo' => $companyinfo,
        ]);
    }
}
