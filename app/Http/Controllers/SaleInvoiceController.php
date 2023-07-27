<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\SaleInvoice;
use App\Models\SaleInvoiceDetails;
use App\Models\Warehouse;
use App\Models\Item;
use App\Models\UnitMeasurement;
use App\Models\CompanyInformation;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\GenerateId;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class SaleInvoiceController extends Controller
{
    protected $datetime;
    protected $currentMonth;

    public function __construct()
    {

        $this->currentMonth = date('Y-m');
        $this->datetime = Date('Y-m-d H:i:s');
    }

    public function index(Request $request)
    {
        $query = SaleInvoice::orderBy('sale_invoices.SalesDate', 'desc')
            ->join('customers', 'sale_invoices.CustomerCode', '=', 'customers.CustomerCode')
            ->select('sale_invoices.*', 'customers.CustomerCode', 'customers.CustomerName')
            ->where(function ($query) {
                $query->where('sale_invoices.Status', 'O');
                    
            });

            $deletequery = SaleInvoice::orderBy('sale_invoices.SalesDate', 'desc')
            ->join('customers', 'sale_invoices.CustomerCode', '=', 'customers.CustomerCode')
            ->select('sale_invoices.*', 'customers.CustomerCode', 'customers.CustomerName')
            ->where(function($delquery){
                $delquery->where('sale_invoices.Status', '=', "D");
                                
            });

        // Add the "paidornot" condition
        $paidOrNot = $request->input('PaymentStatus');
        if ($paidOrNot === 'paid') {
            $query->where('sale_invoices.IsPaid', 1);
        } elseif ($paidOrNot === 'nopaid') {
            $query->where('sale_invoices.IsPaid', 0);
        }

        if ($request->input('saleStartDate') !== null && $request->input('saleEndDate') !== null) {
            $startDate = $request->input('saleStartDate');
            $endDate = $request->input('saleEndDate');

            if($endDate < $startDate){
                return back()->with('warning','start date must be lower than end date');
            }

            //sale query
            $query->whereBetween('sale_invoices.SalesDate', [$startDate, $endDate]);

            $deletequery->whereBetween('sale_invoices.SalesDate', [$startDate, $endDate]);
        } else if ($request->input('saleStartDate') !== null && $request->input('saleEndDate') == null) {
            $query->where('sale_invoices.SalesDate', '>=', $request->input('saleStartDate'));
            $deletequery->where('sale_invoices.SalesDate', '>=', $request->input('saleStartDate'));
        } else if ($request->input('saleStartDate') == null && $request->input('saleEndDate') !== null) {
            $query->where('sale_invoices.SalesDate', '<=', $request->input('saleEndDate'));
            $deletequery->where('sale_invoices.SalesDate', '<=', $request->input('saleEndDate'));
        }else{
            
            $query->where('sale_invoices.SalesDate', '>=', $this->currentMonth . '-01')
                  ->where('sale_invoices.SalesDate', '<=', $this->currentMonth . '-31');
            $deletequery->where('sale_invoices.SalesDate', '>=', $this->currentMonth . '-01')
            ->where('sale_invoices.SalesDate', '<=', $this->currentMonth . '-31');
        }

        

       
        $deletesalesinvoices = $deletequery->get();
        $salesinvoices = $query->get();

        return view('sales.index', [
            'salesinvoices' => $salesinvoices,
            'deletesalesinvoices' => $deletesalesinvoices
        ]);
    }



    public function create()
    {
        $customers = Customer::where('IsActive', '=', 1)->get();
        $warehouses = Warehouse::all();
        $items = Item::where('Discontinued', '=', 1)->get();
        $units = UnitMeasurement::where('IsActive', 1)->get();
        $currentDate = Carbon::now()->format('Y-m-d');

        return view('sales.add', [
            'customers' => $customers,
            'warehouses' => $warehouses,
            'items' => $items,
            'units' => $units,
            'currentDate' => $currentDate,
        ]);
    }



    public function store()
    {

        // Retrieve the JSON data from the request body
        $jsonData = json_decode(request()->getContent(), true);



        // Validate the JSON data
        $formData = Validator::make($jsonData, [

            'SalesDate' => ['required'],
            'CustomerCode' => ['required'],
            'SubTotal' => ['required'],
            'ShippingCharges' => ['nullable'],
            'LaborCharges' => ['nullable'],
            'DeliveryCharges' => ['nullable'],
            'WeightCharges' => ['nullable'],
            'ServiceCharges' => ['nullable'],
            'TotalCharges' => ['required'],
            'GrandTotal' => ['required'],
            'IsPaid' => ['required'],
            'PaidDate' => ['nullable'],
            'PlateNo' => ['nullable'],
            'Remark' => ['nullable'],
            'saleinvoicedetails' => ['required']
        ])->validate();

        if ($formData['IsPaid'] == 0) {
            unset($formData['PaidDate']);
        }

        // return response()->json(['message' => $formData]);

        $InvoiceNo = GenerateId::generatePrimaryKeyId('sale_invoices', 'InvoiceNo', 'SV-', true);

        $formData['InvoiceNo'] = $InvoiceNo;

        $saleinvoicedetails = $formData['saleinvoicedetails'];

        // Add additional data to the form data
        $formData['CreatedBy'] = auth()->user()->Username;
        $formData['ModifiedDate'] = null;

        try {
            // Create a new sales invoice record
            $newSalesInvoice = SaleInvoice::create($formData);

            if (isset($newSalesInvoice)) {



                foreach ($saleinvoicedetails as $saleDetails) {


                    $data = [];
                    $data['InvoiceNo'] = $InvoiceNo;
                    $guid = Str::uuid()->toString();


                    $data['ReferenceNo'] = $guid;
                    $data['WarehouseNo'] = $saleDetails['WarehouseNo'];
                    $data['ItemCode'] = $saleDetails['ItemCode'];
                    $data['Quantity'] = $saleDetails['Quantity'];
                    $data['PackedUnit'] = $saleDetails['PackedUnit'];
                    $data['QtyPerUnit'] = $saleDetails['QtyPerUnit'];
                    $data['TotalViss'] = $saleDetails['TotalViss'];
                    $data['UnitPrice'] = $saleDetails['UnitPrice'];
                    $data['Amount'] = $saleDetails['Amount'];
                    $data['LineDisPer'] = $saleDetails['LineDisPer'];
                    $data['LineDisAmt'] = $saleDetails['LineDisAmt'];
                    $data['LineTotalAmt'] = $saleDetails['LineTotalAmt'];
                    $data['IsFOC'] = $saleDetails['IsFOC'];

                    try {

                        //logger($data);
                        $newSalesInvoicedetails = SaleInvoiceDetails::create($data);
                    } catch (QueryException $e) {

                        return response()->json(['message' => $e->getMessage()]);
                    }
                }

                return response()->json(['message' => "good", 'InvoiceNo' => $InvoiceNo]);
            }
        } catch (QueryException $e) {

            return response()->json(['message' => $e->getMessage()]);
        }
    }





    public function show(SaleInvoice $saleinvoice)
    {

        $saleinvoicedetails = SaleInvoiceDetails::where('InvoiceNo', $saleinvoice->InvoiceNo)
            ->join('warehouses', 'sale_invoice_details.WarehouseNo', '=', 'warehouses.WarehouseCode')
            ->join('items', 'sale_invoice_details.ItemCode', '=', 'items.ItemCode')
            ->join('unit_measurements', 'sale_invoice_details.PackedUnit', '=', 'unit_measurements.UnitCode')
            ->select('sale_invoice_details.*', 'warehouses.WarehouseCode', 'warehouses.WarehouseName', 'items.ItemCode', 'items.ItemName', 'items.WeightByPrice', 'unit_measurements.UnitCode', 'unit_measurements.UnitDesc')
            ->get();

        $saleinvoice->saleinvoicedetails = $saleinvoicedetails;


        $customers = Customer::where('IsActive', '=', 1)->get();
        $warehouses = Warehouse::all();
        $items = Item::where('Discontinued', '=', 1)->get();
        $units = UnitMeasurement::where('IsActive', 1)->get();


        return view('sales.edit', [
            'saleinvoice' => $saleinvoice,
            'customers' => $customers,
            'warehouses' => $warehouses,
            'items' => $items,
            'units' => $units
        ]);
    }

    public function update(SaleInvoice $saleinvoice)
    {

        // Retrieve the JSON data from the request body
        $jsonData = json_decode(request()->getContent(), true);

        $formData = Validator::make($jsonData, [

            'SalesDate' => ['required'],
            'CustomerCode' => ['required'],
            'SubTotal' => ['required'],
            'ShippingCharges' => ['nullable'],
            'LaborCharges' => ['nullable'],
            'DeliveryCharges' => ['nullable'],
            'WeightCharges' => ['nullable'],
            'ServiceCharges' => ['nullable'],
            'TotalCharges' => ['required'],
            'GrandTotal' => ['required'],
            'IsPaid' => ['required'],
            'PaidDate' => ['nullable'],
            'PlateNo' => ['nullable'],
            'Remark' => ['nullable'],
            'saleinvoicedetails' => ['required']
        ])->validate();


        $formData['InvoiceNo'] = $saleinvoice->InvoiceNo;
        $formData['ModifiedBy'] = auth()->user()->Username;
        $formData['ModifiedDate'] = $this->datetime;
        $saleinvoicedetails = $formData['saleinvoicedetails'];
        unset($formData['saleinvoicedetails']);
        try {

            $updatesaleinvoice = SaleInvoice::where('InvoiceNo', $saleinvoice->InvoiceNo)->update($formData);

            if (isset($updatesaleinvoice)) {
                SaleInvoiceDetails::where('InvoiceNo', $saleinvoice->InvoiceNo)->delete();

                foreach ($saleinvoicedetails as $saleinvoicedetail) {


                    $data = [];
                    $data['InvoiceNo'] = $saleinvoice->InvoiceNo;
                    $guid = Str::uuid()->toString();


                    $data['ReferenceNo'] = $guid;
                    $data['WarehouseNo'] = $saleinvoicedetail['WarehouseNo'];
                    $data['ItemCode'] = $saleinvoicedetail['ItemCode'];
                    $data['Quantity'] = $saleinvoicedetail['Quantity'];
                    $data['PackedUnit'] = $saleinvoicedetail['PackedUnit'];
                    $data['QtyPerUnit'] = $saleinvoicedetail['QtyPerUnit'];
                    $data['TotalViss'] = $saleinvoicedetail['TotalViss'];
                    $data['UnitPrice'] = $saleinvoicedetail['UnitPrice'];
                    $data['Amount'] = $saleinvoicedetail['Amount'];
                    $data['LineDisPer'] = $saleinvoicedetail['LineDisPer'];
                    $data['LineDisAmt'] = $saleinvoicedetail['LineDisAmt'];
                    $data['LineTotalAmt'] = $saleinvoicedetail['LineTotalAmt'];
                    $data['IsFOC'] = $saleinvoicedetail['IsFOC'];

                    try {
                        $newSalesInvoicedetails = SaleInvoiceDetails::create($data);
                    } catch (QueryException $e) {

                        return response()->json(['message' => $e->getMessage()]);
                    }
                }
            }

            return response()->json(['message' => 'good']);

            // return redirect()->route('saleinvoices')->with('success','update sale invoices successful');
        } catch (QueryException $e) {

            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function destory(SaleInvoice $saleinvoice)
    {


        $data = [];
        $data['DeletedBy'] = auth()->user()->Username;
        $data['InvoiceNo'] = $saleinvoice->InvoiceNo;
        $data['DeletedDate'] = $this->datetime;
        $data['Status'] = 'D';

        try {

            $deletesaleinvoice = SaleInvoice::where('InvoiceNo', $saleinvoice->InvoiceNo)->update($data);

            return redirect()->route('saleinvoices')->with('success', 'Delete sale invoices successful');
        } catch (QueryException $e) {

            return response()->json(['message' => $e->getMessage()]);

            //return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function restore(SaleInvoice $saleinvoice)
    {


        $data = [];
        $data['DeletedBy'] = null;
        $data['InvoiceNo'] = $saleinvoice->InvoiceNo;
        $data['DeletedDate'] = null;
        $data['Status'] = 'O';

        try {

            $deletesaleinvoice = SaleInvoice::where('InvoiceNo', $saleinvoice->InvoiceNo)->update($data);

            return redirect()->route('saleinvoices')->with('success', 'Restore sale invoices successful');
            
        } catch (QueryException $e) {

            return response()->json(['message' => $e->getMessage()]);

        }
    }

    public function viewDetails(SaleInvoice $saleinvoice)
    {

        $saleinvoicedetails = SaleInvoiceDetails::where('InvoiceNo', $saleinvoice->InvoiceNo)
            ->join('warehouses', 'sale_invoice_details.WarehouseNo', '=', 'warehouses.WarehouseCode')
            ->join('items', 'sale_invoice_details.ItemCode', '=', 'items.ItemCode')
            ->join('unit_measurements', 'sale_invoice_details.PackedUnit', '=', 'unit_measurements.UnitCode')
            ->select('sale_invoice_details.*', 'warehouses.WarehouseCode', 'warehouses.WarehouseName', 'items.ItemCode', 'items.ItemName', 'unit_measurements.UnitCode', 'unit_measurements.UnitDesc')
            ->get();

        $saleinvoice->saleinvoicedetails = $saleinvoicedetails;


        $customers = Customer::all();
        $warehouses = Warehouse::all();
        $items = Item::all();
        $units = UnitMeasurement::where('IsActive', 1)->get();

        return view('sales.details', [
            'saleinvoice' => $saleinvoice,
            'customers' => $customers,
            'warehouses' => $warehouses,
            'items' => $items,
            'units' => $units
        ]);
    }

    public function printPreview(SaleInvoice $saleinvoice)
    {

        $saleinvoicedetails = SaleInvoiceDetails::where('InvoiceNo', $saleinvoice->InvoiceNo)
            ->join('warehouses', 'sale_invoice_details.WarehouseNo', '=', 'warehouses.WarehouseCode')
            ->join('items', 'sale_invoice_details.ItemCode', '=', 'items.ItemCode')
            ->join('unit_measurements', 'sale_invoice_details.PackedUnit', '=', 'unit_measurements.UnitCode')
            ->select('sale_invoice_details.*', 'warehouses.WarehouseCode', 'warehouses.WarehouseName', 'items.ItemCode', 'items.ItemName', 'unit_measurements.UnitCode', 'unit_measurements.UnitDesc')
            ->get();

        $saleinvoice->saleinvoicedetails = $saleinvoicedetails;
        $totalBags = SaleInvoiceDetails::where('InvoiceNo', $saleinvoice->InvoiceNo)->sum('Quantity');
        $customers = Customer::all();
        $warehouses = Warehouse::all();
        $items = Item::all();
        $units = UnitMeasurement::where('IsActive', 1)->get();
        $companyinfo = CompanyInformation::first();


        return view('sales.printVoucher', [
            'saleinvoice' => $saleinvoice,
            'customers' => $customers,
            'warehouses' => $warehouses,
            'items' => $items,
            'units' => $units,
            'companyinfo' => $companyinfo,
            'totalBags' => $totalBags,
        ]);
    }

    public function printLetter(SaleInvoice $saleinvoice)
    {

        $saleinvoicedetails = SaleInvoiceDetails::where('InvoiceNo', $saleinvoice->InvoiceNo)
            ->join('warehouses', 'sale_invoice_details.WarehouseNo', '=', 'warehouses.WarehouseCode')
            ->join('items', 'sale_invoice_details.ItemCode', '=', 'items.ItemCode')
            ->join('unit_measurements', 'sale_invoice_details.PackedUnit', '=', 'unit_measurements.UnitCode')
            ->select('sale_invoice_details.*', 'warehouses.WarehouseCode', 'warehouses.WarehouseName', 'items.ItemCode', 'items.ItemName', 'unit_measurements.UnitCode', 'unit_measurements.UnitDesc')
            ->get();

        $saleinvoice->saleinvoicedetails = $saleinvoicedetails;
        $totalBags = SaleInvoiceDetails::where('InvoiceNo', $saleinvoice->InvoiceNo)->sum('Quantity');
        $customers = Customer::all();
        $warehouses = Warehouse::all();
        $items = Item::all();
        $units = UnitMeasurement::where('IsActive', 1)->get();
        $companyinfo = CompanyInformation::first();


        return view('sales.printLetter', [
            'saleinvoice' => $saleinvoice,
            'customers' => $customers,
            'warehouses' => $warehouses,
            'items' => $items,
            'units' => $units,
            'companyinfo' => $companyinfo,
            'totalBags' => $totalBags,
        ]);
    }

    public function detailsPreview(SaleInvoice $saleinvoice)
    {

        $saleinvoicedetails = SaleInvoiceDetails::where('InvoiceNo', $saleinvoice->InvoiceNo)
            ->join('warehouses', 'sale_invoice_details.WarehouseNo', '=', 'warehouses.WarehouseCode')
            ->join('items', 'sale_invoice_details.ItemCode', '=', 'items.ItemCode')
            ->join('unit_measurements', 'sale_invoice_details.PackedUnit', '=', 'unit_measurements.UnitCode')
            ->select('sale_invoice_details.*', 'warehouses.WarehouseCode', 'warehouses.WarehouseName', 'items.ItemCode', 'items.ItemName', 'unit_measurements.UnitCode', 'unit_measurements.UnitDesc')
            ->get();

        $saleinvoice->saleinvoicedetails = $saleinvoicedetails;


        $customers = Customer::all();
        $warehouses = Warehouse::all();
        $items = Item::all();
        $units = UnitMeasurement::where('IsActive', 1)->get();
        $companyinfo = CompanyInformation::first();


        return view('sales.detailsPreview', [
            'saleinvoice' => $saleinvoice,
            'customers' => $customers,
            'warehouses' => $warehouses,
            'items' => $items,
            'units' => $units,
            'companyinfo' => $companyinfo,
        ]);
    }

    //Sales Report 

    public function salesinvoicesreports(Request $request)
    {

        $query = SaleInvoice::orderBy('sale_invoices.SalesDate', 'desc')
            ->join('customers', 'sale_invoices.CustomerCode', '=', 'customers.CustomerCode')
            ->select('sale_invoices.*', 'customers.CustomerCode', 'customers.CustomerName')
            ->where(function ($query) {
                $query->where('sale_invoices.Status', 'O');
                    
            });

        $deletesalesinvoicesquery = SaleInvoice::orderBy('sale_invoices.SalesDate', 'desc')
        ->join('customers', 'sale_invoices.CustomerCode', '=', 'customers.CustomerCode')
        ->select('sale_invoices.*', 'customers.CustomerCode', 'customers.CustomerName')
        ->where(function($delsalesquery){
            $delsalesquery->where('sale_invoices.Status', '=', "D");
                           
        });



        // Add the "paidornot" condition
        $paidOrNot = $request->input('PaymentStatus');
        if ($paidOrNot === 'paid') {
            $query->where('sale_invoices.IsPaid', 1);
        } elseif ($paidOrNot === 'nopaid') {
            $query->where('sale_invoices.IsPaid', 0);
        }

           

        if ($request->input('saleStartDate') !== null && $request->input('saleEndDate') !== null) {
            $startDate = $request->input('saleStartDate');
            $endDate = $request->input('saleEndDate');

            if($endDate < $startDate){
                return back()->with('warning','start date must be lower than end date');
            }

            $query->whereBetween('sale_invoices.SalesDate', [$startDate, $endDate]);
            $deletesalesinvoicesquery->whereBetween('sale_invoices.SalesDate', [$startDate, $endDate]);
        } else if ($request->input('saleStartDate') !== null && $request->input('saleEndDate') == null) {
            $query->where('sale_invoices.SalesDate', '>=', $request->input('saleStartDate'));
            $deletesalesinvoicesquery->where('sale_invoices.SalesDate', '>=', $request->input('saleStartDate'));
        } else if ($request->input('saleStartDate') == null && $request->input('saleEndDate') !== null) {
            $query->where('sale_invoices.SalesDate', '<=', $request->input('saleEndDate'));
            $deletesalesinvoicesquery->where('sale_invoices.SalesDate', '<=', $request->input('saleEndDate'));
        }else{
            $query->where('sale_invoices.SalesDate', '>=', Carbon::now()->startOfMonth()->toDateString())
                  ->where('sale_invoices.SalesDate', '<=', Carbon::now()->endOfMonth()->toDateString());
            $deletesalesinvoicesquery->where('sale_invoices.SalesDate', '>=', Carbon::now()->startOfMonth()->toDateString())
            ->where('sale_invoices.SalesDate', '<=', Carbon::now()->endOfMonth()->toDateString());
        }

    

        $companyinfo = CompanyInformation::first();

        $salesinvoices = $query->get();
        $deletesalesinvoices = $deletesalesinvoicesquery->get();
        
        return view('reports.salesreports', [
            'salesinvoices' => $salesinvoices,
            'deletesalesinvoices' => $deletesalesinvoices,
            'companyinfo' => $companyinfo,
        ]);
    }
}
