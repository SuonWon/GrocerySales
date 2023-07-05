<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\GenerateId;
use App\Models\CompanyInformation;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;


class CustomerController extends Controller
{

    protected $datetime;

    public function __construct()
    {
        $this->datetime = Date('Y-m-d H:i:s');
    }

    // show customers page 
    public function index()
    {
        $customers = Customer::all()->sortByDesc('CreatedDate');

        return view('setup.customer.index', [
            'customers' => $customers
        ]);
    }

    // show create form page for customer
    public function create()
    {
        return view('setup.customer.add');
    }

    //when form submit store data in database
    public function store()
    {

        $formData = request()->validate([
       
            'CustomerName' => ['required'],
            // 'Email' => ['email', Rule::unique('customers', 'email')],
        ]);

        $formData['CustomerCode'] = GenerateId::generatePrimaryKeyId('customers','CustomerCode','CS-');

        $formData['NRCNo'] = request('NRCNo');
        $formData['CompanyName'] = request('CompanyName');
        $formData['Street'] = request('Street');
        $formData['City'] = request('City');
        $formData['Region'] = request('Region');
        $formData['ContactNo'] = request('ContactNo');
        $formData['OfficeNo'] = request('OfficeNo');
        $formData['FaxNo'] = request('FaxNo');
        $formData['Email'] = request('Email');
        $formData['IsActive'] = request('IsActive');
        if ($formData['IsActive'] == "on") {
            $formData['IsActive'] = 1;
        } else {
            $formData['IsActive'] = 0;
        }
        $formData['Remark'] = request('Remark');
        $formData['CreatedBy'] = auth()->user()->Username;
        $formData['ModifiedDate'] = null;

        try{

            $newcustomer = Customer::create($formData);

            return redirect('/customer/add')->with('success','Customer Create Successfully');

        }catch(QueryException $e){

            return back()->with(['error' => $e->getMessage()]);

        }
    }

    //show edit form page 
    public function showedit(Customer $id)
    {

        if ($id->IsActive == 1) {
            $id->IsActive = 'on';
        } else {
            $id->IsActive = "off";
        }

        return view('setup.customer.edit', [
            'customer' => $id
        ]);
    }

    //update data for customer 
    public function updatecustomer(Customer $id)
    {

        $formData =  request()->validate([

            'CustomerName' => ['required'],

            'Email' => 'required|email|unique:customers,email,' . $id->CustomerCode . ',CustomerCode'
            
        ]);

        $formData['CustomerCode'] = $id->CustomerCode;
        $formData['NRCNo'] = request('NRCNo');
        $formData['CompanyName'] = request('CompanyName');
        $formData['Street'] = request('Street');
        $formData['City'] = request('City');
        $formData['Region'] = request('Region');
        $formData['ContactNo'] = request('ContactNo');
        $formData['OfficeNo'] = request('OfficeNo');
        $formData['FaxNo'] = request('FaxNo');
        $formData['Email'] = request('Email');
        $formData['IsActive'] = request('IsActive');
        if ($formData['IsActive'] == "on") {
            $formData['IsActive'] = 1;
        } else {
            $formData['IsActive'] = 0;
        }
        $formData['Remark'] = request('Remark');
        $formData['ModifiedBy'] = auth()->user()->Username;
        $formData['ModifiedDate'] = $this->datetime;

        try{
                
            $updatecustomer = Customer::where('CustomerCode',$id->CustomerCode)->update($formData);

            return redirect('/customer/index')->with('success','Customer Update Successfully');

        } catch(QueryException $e) {

            return back()->with(['error' => $e->getMessage()]);

        }
    }



    //delete customer
    public function destory(Customer $id)
    {

        //အမှန်ဆို ဒီလိုရေးလို့ရရမှာ သူက id ကိုပဲ သွားရှာနေလို့ Customer Code ကို မရှာဘူး အဲ့တာပြောင်းတဲ့ဟာလေး ပြောင်းလို့ရလား
        // ရှာကြည့်လိုက်ဥိးမယ်။
        // $deletecustomer = $id->delete(); 


        try {

            Customer::where('CustomerCode',$id->CustomerCode)->delete();

            return redirect('/customer/index')->with('success','Customer Delete Successfully');

        } catch(QueryException $e) {

            if ($e->errorInfo[1] == 1451) {

                return back()->with(['error' => 'Cannot delete this record because it is referenced by another table.']);

            } else {

                return back()->with(['error' => $e->getMessage()]);

            }
        }
    }

    //Customer Report
    public function customerreports()
    {
        $customers = Customer::all()->sortByDesc('CreatedDate');
        $companyinfo = CompanyInformation::first();

        return view('reports.customerreports', [
            'customers' => $customers,
            'companyinfo' => $companyinfo,
        ]);
        
    }
}
