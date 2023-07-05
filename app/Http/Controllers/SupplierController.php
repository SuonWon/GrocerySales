<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Database\QueryException;
use App\Models\CompanyInformation;
use Illuminate\Http\Request;
use App\Models\GenerateId;

class SupplierController extends Controller
{
    protected $datetime;

    public function __construct()
    {


        $this->datetime = Date('Y-m-d H:i:s');

    }

    public function index(){

        $suppliers = Supplier::all()->sortByDesc('CreatedDate');

       return view('setup.supplier.index',[

            'suppliers' => $suppliers

       ]);
    }

    public function create(){
        return view('setup.supplier.add');
    }

    public function store(){

        $formData = request()->validate([

          
            'SupplierName'=>['required'],
            'ContactName' => ['required'],
             
        ]);

        $formData['SupplierCode'] = GenerateId::generatePrimaryKeyId('suppliers','SupplierCode','SP-');
 
        $formData['ContactNo'] = request('ContactNo');
        $formData['Profit'] = request('Profit');
        $formData['OfficeNo'] = request('OfficeNo');
        $formData['IsActive'] = request('IsActive');
        if ($formData['IsActive'] == "on") {
            $formData['IsActive'] = 1;
        } else {
            $formData['IsActive'] = 0;
        }
        $formData['Street'] = request('Street');
        $formData['Township'] = request('Township');
        $formData['City'] = request('City');
        $formData['Remark'] = request('Remark');
        $formData['CreatedBy'] = auth()->user()->Username;
        $formData['ModifiedDate'] = null; 

        try{
            $newsupplier = Supplier::create($formData);

            return  redirect()->route('addsupplier')->with('success','supplier created successful');
        }catch(QueryException $e){
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function show(Supplier $supplier){

        if ($supplier->IsActive == 1) {
            $supplier->IsActive = 'on';
        } else {
            $supplier->IsActive = "off";
        }
        
        return view('setup.supplier.edit',[
            'supplier' => $supplier
        ]);
    }

    public function update(Supplier $supplier){

        // dd(request()->all());
            $formData = request()->validate([
                'SupplierName'=>['required'],
                'ContactName' => ['required'],    
            ]);
            $formData['Profit'] = request('Profit');
            $formData['SupplierCode'] = $supplier->SupplierCode;
            $formData['ContactNo'] = request('ContactNo');
            $formData['OfficeNo'] = request('OfficeNo');
            $formData['Street'] = request('Street');
            $formData['Township'] = request('Township');
            $formData['IsActive'] = request('IsActive');
            if ($formData['IsActive'] == "on") {
                $formData['IsActive'] = 1;
            } else {
                $formData['IsActive'] = 0;
            }
            $formData['City'] = request('City');
            $formData['Remark'] = request('Remark');
            $formData['ModifiedBy'] = auth()->user()->Username;
            $formData['ModifiedDate'] = $this->datetime;

            try{

                $updatesupplier = Supplier::where('SupplierCode',$supplier->SupplierCode)->update($formData);

                return redirect()->route('supplier')->with('success','update supplier successful');

            }catch(QueryException $e){

                return back()->with(['error' => $e->getMessage()]);

            }
    }

    public function destory(Supplier $supplier){
        try {

            $deletesupplier =  Supplier::where('SupplierCode',$supplier->SupplierCode)->delete();

            return redirect()->route('supplier')->with('success','Delete Supplier Successful');

        } catch (QueryException $e) {

            if ($e->errorInfo[1] == 1451) {

                return back()->with(['error' => 'Cannot delete this record because it is referenced by another table.']);

            } else {

                return back()->with(['error' => $e->getMessage()]);
                
            }
        }

    }

    //Supplier Report

    public function supplierreports(){

        $suppliers = Supplier::all()->sortByDesc('CreatedDate');
        $companyinfo = CompanyInformation::first();

        return view('reports.supplierreports',[

            'suppliers' => $suppliers,
            'companyinfo' => $companyinfo,

        ]);
    }
}
