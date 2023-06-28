<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemArrival;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceDetail;
use App\Models\Supplier;
use App\Models\UnitMeasurement;
use App\Models\Warehouse;
use App\Models\CompanyInformation;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\GenerateId;

class PurchaseInvoiceController extends Controller
{
    protected $datetime;
    protected $currentMonth;

    public function __construct()
    {
        $this->datetime = Date('Y-m-d H:i:s');
        $this->currentMonth = date('Y-m');
    }

    public function index(Request $request)
    {

        $query = PurchaseInvoice::orderBy('purchase_invoices.PurchaseDate', 'desc')
            ->join('suppliers', 'purchase_invoices.SupplierCode', '=', 'suppliers.SupplierCode')
            ->select('purchase_invoices.*', 'suppliers.SupplierCode', 'suppliers.SupplierName')
            ->where(function ($query) {
                $query->where('purchase_invoices.Status', 'O');
                    
            });

        $deletequery = PurchaseInvoice::orderBy('purchase_invoices.PurchaseDate', 'desc')
        ->join('suppliers', 'purchase_invoices.SupplierCode', '=', 'suppliers.SupplierCode')
        ->select('purchase_invoices.*', 'suppliers.SupplierCode', 'suppliers.SupplierName')
        ->where(function($delquery){
            $delquery->where('purchase_invoices.Status', "=", "D");
                            
        });

       

        // Add the "paidornot" condition
        $paidOrNot = $request->input('PaymentStatus');
        if ($paidOrNot === 'paid') {
            $query->where('purchase_invoices.IsPaid', 1);
        } elseif ($paidOrNot === 'nopaid') {
            $query->where('purchase_invoices.IsPaid', 0);
        }


        if ($request->input('startDate') !== null && $request->input('endDate') !== null) {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            if($endDate < $startDate){
                return back()->with('warning','start date must be lower than end date');
            }

            $query->whereBetween('purchase_invoices.PurchaseDate', [$startDate, $endDate]);

            $deletequery->whereBetween('purchase_invoices.PurchaseDate', [$startDate, $endDate]);

        } else if ($request->input('startDate') !== null && $request->input('endDate') == null) {

            $query->where('purchase_invoices.PurchaseDate', '>=', $request->input('startDate'));

            $deletequery->where('purchase_invoices.PurchaseDate', '>=', $request->input('startDate'));

        } else if ($request->input('startDate') == null && $request->input('endDate') !== null) {

            $query->where('purchase_invoices.PurchaseDate', '<=', $request->input('endDate'));

            $deletequery->where('purchase_invoices.PurchaseDate', '<=', $request->input('endDate'));

        } else {
            // If both startDate and endDate are null, retrieve records for the current month
       
            $query->where('purchase_invoices.PurchaseDate', '>=', $this->currentMonth . '-01')
                  ->where('purchase_invoices.PurchaseDate', '<=', $this->currentMonth . '-31');

            $deletequery->where('purchase_invoices.PurchaseDate', '>=', $this->currentMonth . '-01')
            ->where('purchase_invoices.PurchaseDate', '<=', $this->currentMonth . '-31');
        }
        

        $purchaseinvoices = $query->get();

            
          
        
           
            $deletepurchaseinvoices = $deletequery->get();

   

        return view('purchase.purchaseinvoice.index', [
            'purchaseinvoices' => $purchaseinvoices,
            'deletepurchaseinvoices' => $deletepurchaseinvoices
        ]);
    }

    public function create()
    {
        $suppliers = Supplier::where('IsActive', '=', 1)->get();
        $arrivals = ItemArrival::where('Status', 'N')->get();
        $warehouses = Warehouse::all();
        $items = Item::all();
        $units = UnitMeasurement::all();
        $currentDate = Carbon::now()->format('Y-m-d');

        return view('purchase.purchaseinvoice.add', [
            'suppliers' => $suppliers,
            'arrivals' => $arrivals,
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

            'PurchaseDate' => ['required'],
            'ArrivalCode' => ['required'],
            'SupplierCode' => ['required'],
            'SubTotal' => ['nullable'],
            'LaborCharges' => ['nullable'],
            'DeliveryCharges' => ['nullable'],
            'WeightCharges' => ['nullable'],
            'ServiceCharges' => ['nullable'],
            'TotalCharges' => ['required'],
            'GrandTotal' => ['required'],
            'IsPaid' => ['required'],
            'PaidDate' => ['nullable'],
            'Remark' => ['nullable'],
            'purchaseInvoiceDetails' => ['nullable']
        ])->validate();



        $formData['InvoiceNo'] = GenerateId::generatePrimaryKeyId('purchase_invoices', 'InvoiceNo', 'PV-', true, false);
        $InvoiceNo = $formData['InvoiceNo'];
        $ArrivalCode = $formData['ArrivalCode'];


        $purchaseInvoiceDetails = $formData['purchaseInvoiceDetails'];
        // Add additional data to the form data
        $formData['CreatedBy'] = auth()->user()->Username;
        $formData['ModifiedDate'] = null;

        try {
            // Create a new sales invoice record
            $newPurchaseInvoice = PurchaseInvoice::create($formData);

            ItemArrival::where('ArrivalCode', $ArrivalCode)->update(['Status' => "O"]);

            if (isset($newPurchaseInvoice)) {

                foreach ($purchaseInvoiceDetails as $purchaseInvoiceDetail) {


                    $data = [];
                    $data['InvoiceNo'] = $InvoiceNo;
                    $guid = Str::uuid()->toString();
                    $ItemCode = $purchaseInvoiceDetail['ItemCode'];
                    $unitPrice = $purchaseInvoiceDetail['UnitPrice'];

                    $data['ReferenceNo'] = $guid;
                    $data['WarehouseNo'] = $purchaseInvoiceDetail['WarehouseNo'];
                    $data['ItemCode'] = $purchaseInvoiceDetail['ItemCode'];


                    $data['Quantity'] = $purchaseInvoiceDetail['Quantity'];
                    $data['PackedUnit'] = $purchaseInvoiceDetail['PackedUnit'];
                    $data['TotalViss'] = $purchaseInvoiceDetail['TotalViss'];
                    $data['UnitPrice'] = $purchaseInvoiceDetail['UnitPrice'];
                    $data['Amount'] = $purchaseInvoiceDetail['Amount'];
                    $data['LineDisPer'] = $purchaseInvoiceDetail['LineDisPer'];
                    $data['LineDisAmt'] = $purchaseInvoiceDetail['LineDisAmt'];
                    $data['LineTotalAmt'] = $purchaseInvoiceDetail['LineTotalAmt'];
                    $data['IsFOC'] = $purchaseInvoiceDetail['IsFOC'];

                    try {

                        $newPurchasesInvoicedetails = PurchaseInvoiceDetail::create($data);
                        Item::where('ItemCode', $ItemCode)->update(['LastPurPrice' => $unitPrice]);
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




    public function show(PurchaseInvoice $purchaseinvoice)
    {

        $purchaseinvoicedetails = PurchaseInvoiceDetail::where('InvoiceNo', $purchaseinvoice->InvoiceNo)
            ->join('warehouses', 'purchase_invoice_details.WarehouseNo', '=', 'warehouses.WarehouseCode')
            ->join('items', 'purchase_invoice_details.ItemCode', '=', 'items.ItemCode')
            ->join('unit_measurements', 'purchase_invoice_details.PackedUnit', '=', 'unit_measurements.UnitCode')
            ->select('purchase_invoice_details.*', 'warehouses.WarehouseCode', 'warehouses.WarehouseName', 'items.ItemCode', 'items.ItemName', 'unit_measurements.UnitCode', 'unit_measurements.UnitDesc')
            ->get();

        $purchaseinvoice->purchaseinvoicedetails = $purchaseinvoicedetails;

        $suppliers = Supplier::where('IsActive', '=', 1)->get();
        $arrivals = ItemArrival::where('Status', 'N')->orwhere('ArrivalCode', $purchaseinvoice->ArrivalCode)->get();
        $warehouses = Warehouse::all();
        $items = Item::all();
        $units = UnitMeasurement::all();


        return view('purchase.purchaseinvoice.edit', [
            'purchaseinvoice' => $purchaseinvoice,
            'suppliers' => $suppliers,
            'arrivals' => $arrivals,
            'items' => $items,
            'warehouses' => $warehouses,
            'units' => $units
        ]);
    }

    public function update(PurchaseInvoice $purchaseinvoice)
    {

        // Retrieve the JSON data from the request body
        $jsonData = json_decode(request()->getContent(), true);

        $formData = Validator::make($jsonData, [

            'PurchaseDate' => ['required'],
            'ArrivalCode' => ['required'],
            'SupplierCode' => ['required'],
            'SubTotal' => ['required'],
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
            'purchaseInvoiceDetails' => ['required']
        ])->validate();

        $oldArrivalCode = $purchaseinvoice->ArrivalCode;
        $newArrivalCode = $formData['ArrivalCode'];

        $formData['InvoiceNo'] = $purchaseinvoice->InvoiceNo;
        $formData['ModifiedBy'] = auth()->user()->Username;
        $formData['ModifiedDate'] = $this->datetime;
        $purchaseInvoiceDetails = $formData['purchaseInvoiceDetails'];

        unset($formData['purchaseInvoiceDetails']);
        try {

            $updatesaleinvoice = PurchaseInvoice::where('InvoiceNo', $purchaseinvoice->InvoiceNo)->update($formData);

            if ($oldArrivalCode != $newArrivalCode) {
                ItemArrival::where('ArrivalCode', $newArrivalCode)->update(['Status' => "O"]);
                ItemArrival::where('ArrivalCode', $oldArrivalCode)->update(['Status' => "N"]);
            }


            if (isset($updatesaleinvoice)) {
                PurchaseInvoiceDetail::where('InvoiceNo', $purchaseinvoice->InvoiceNo)->delete();

                foreach ($purchaseInvoiceDetails as $purchaseInvoiceDetail) {


                    $data = [];
                    $data['InvoiceNo'] = $purchaseinvoice->InvoiceNo;
                    $guid = Str::uuid()->toString();


                    $data['ReferenceNo'] = $guid;
                    $data['WarehouseNo'] = $purchaseInvoiceDetail['WarehouseNo'];
                    $data['ItemCode'] = $purchaseInvoiceDetail['ItemCode'];
                    $data['Quantity'] = $purchaseInvoiceDetail['Quantity'];
                    $data['PackedUnit'] = $purchaseInvoiceDetail['PackedUnit'];
                    $data['TotalViss'] = $purchaseInvoiceDetail['TotalViss'];
                    $data['UnitPrice'] = $purchaseInvoiceDetail['UnitPrice'];
                    $data['Amount'] = $purchaseInvoiceDetail['Amount'];
                    $data['LineDisPer'] = $purchaseInvoiceDetail['LineDisPer'];
                    $data['LineDisAmt'] = $purchaseInvoiceDetail['LineDisAmt'];
                    $data['LineTotalAmt'] = $purchaseInvoiceDetail['LineTotalAmt'];
                    $data['IsFOC'] = $purchaseInvoiceDetail['IsFOC'];

                    try {

                        $newPurchaseInvoicedetails = PurchaseInvoiceDetail::create($data);
                        // return response()->json(['message' => "good"]);

                    } catch (QueryException $e) {

                        return response()->json(['message' => $e->getMessage()]);
                    }
                }

                return response()->json(['message' => "good"]);
            }

            // return response()->json(['message' => 'good']);
            // return redirect()->route('saleinvoices')->with('success','update sale invoices successful');
        } catch (QueryException $e) {

            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function destory(PurchaseInvoice $purchaseinvoice)
    {


        $data = [];
        $data['DeletedBy'] = auth()->user()->Username;
        $data['InvoiceNo'] = $purchaseinvoice->InvoiceNo;
        $data['DeletedDate'] = $this->datetime;
        $data['Status'] = 'D';

        try {

            $deletesaleinvoice = PurchaseInvoice::where('InvoiceNo', $purchaseinvoice->InvoiceNo)->update($data);

            return redirect()->route('purchaseinvoices')->with('success', 'Delete purchase invoices successful');
        } catch (QueryException $e) {

            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function viewDetails(PurchaseInvoice $purchaseinvoice)
    {

        $purchaseinvoicedetails = PurchaseInvoiceDetail::where('InvoiceNo', $purchaseinvoice->InvoiceNo)
            ->join('warehouses', 'purchase_invoice_details.WarehouseNo', '=', 'warehouses.WarehouseCode')
            ->join('items', 'purchase_invoice_details.ItemCode', '=', 'items.ItemCode')
            ->join('unit_measurements', 'purchase_invoice_details.PackedUnit', '=', 'unit_measurements.UnitCode')
            ->select('purchase_invoice_details.*', 'warehouses.WarehouseCode', 'warehouses.WarehouseName', 'items.ItemCode', 'items.ItemName', 'unit_measurements.UnitCode', 'unit_measurements.UnitDesc')
            ->get();

        $purchaseinvoice->purchaseinvoicedetails = $purchaseinvoicedetails;

        $suppliers = Supplier::all();
        $arrivals = ItemArrival::all();
        $warehouses = Warehouse::all();
        $items = Item::all();
        $units = UnitMeasurement::all();


        return view('purchase.purchaseinvoice.details', [
            'purchaseinvoice' => $purchaseinvoice,
            'suppliers' => $suppliers,
            'arrivals' => $arrivals,
            'items' => $items,
            'warehouses' => $warehouses,
            'units' => $units
        ]);
    }

    public function printPreview(PurchaseInvoice $purchaseinvoice)
    {

        $purchaseinvoicedetails = PurchaseInvoiceDetail::where('InvoiceNo', $purchaseinvoice->InvoiceNo)
            ->join('warehouses', 'purchase_invoice_details.WarehouseNo', '=', 'warehouses.WarehouseCode')
            ->join('items', 'purchase_invoice_details.ItemCode', '=', 'items.ItemCode')
            ->join('unit_measurements', 'purchase_invoice_details.PackedUnit', '=', 'unit_measurements.UnitCode')
            ->select('purchase_invoice_details.*', 'warehouses.WarehouseCode', 'warehouses.WarehouseName', 'items.ItemCode', 'items.ItemName', 'unit_measurements.UnitCode', 'unit_measurements.UnitDesc')
            ->get();

        $purchaseinvoice->purchaseinvoicedetails = $purchaseinvoicedetails;

        $suppliers = Supplier::all();
        $arrivals = ItemArrival::all();
        $warehouses = Warehouse::all();
        $items = Item::all();
        $units = UnitMeasurement::all();
        $companyinfo = CompanyInformation::first();


        return view('purchase.purchaseinvoice.printPuVoucher', [
            'purchaseinvoice' => $purchaseinvoice,
            'suppliers' => $suppliers,
            'arrivals' => $arrivals,
            'items' => $items,
            'warehouses' => $warehouses,
            'units' => $units,
            'companyinfo' => $companyinfo,
        ]);
    }

    public function detailsPreview(PurchaseInvoice $purchaseinvoice)
    {

        $purchaseinvoicedetails = PurchaseInvoiceDetail::where('InvoiceNo', $purchaseinvoice->InvoiceNo)
            ->join('warehouses', 'purchase_invoice_details.WarehouseNo', '=', 'warehouses.WarehouseCode')
            ->join('items', 'purchase_invoice_details.ItemCode', '=', 'items.ItemCode')
            ->join('unit_measurements', 'purchase_invoice_details.PackedUnit', '=', 'unit_measurements.UnitCode')
            ->select('purchase_invoice_details.*', 'warehouses.WarehouseCode', 'warehouses.WarehouseName', 'items.ItemCode', 'items.ItemName', 'unit_measurements.UnitCode', 'unit_measurements.UnitDesc')
            ->get();

        $purchaseinvoice->purchaseinvoicedetails = $purchaseinvoicedetails;

        $suppliers = Supplier::all();
        $arrivals = ItemArrival::all();
        $warehouses = Warehouse::all();
        $items = Item::all();
        $units = UnitMeasurement::all();
        $companyinfo = CompanyInformation::first();


        return view('purchase.purchaseinvoice.puDetailsPreview', [
            'purchaseinvoice' => $purchaseinvoice,
            'suppliers' => $suppliers,
            'arrivals' => $arrivals,
            'items' => $items,
            'warehouses' => $warehouses,
            'units' => $units,
            'companyinfo' => $companyinfo,
        ]);
    }

    //Purchase Report 
    public function purchaseinvoicesreports(Request $request)
    {

        $query = PurchaseInvoice::orderBy('purchase_invoices.PurchaseDate', 'desc')
            ->join('suppliers', 'purchase_invoices.SupplierCode', '=', 'suppliers.SupplierCode')
            ->join('item_arrivals', 'purchase_invoices.ArrivalCode', '=', 'item_arrivals.ArrivalCode')
            ->select('purchase_invoices.*', 'suppliers.SupplierCode', 'suppliers.SupplierName', 'item_arrivals.ArrivalCode', 'item_arrivals.PlateNo')
            ->where(function ($query) {
                $query->where('purchase_invoices.Status', 'O');
                 
            });

            $deletepurchaseinvoicesquery = PurchaseInvoice::orderBy('purchase_invoices.PurchaseDate', 'desc')
        ->join('suppliers', 'purchase_invoices.SupplierCode', '=', 'suppliers.SupplierCode')
        ->select('purchase_invoices.*', 'suppliers.SupplierCode', 'suppliers.SupplierName')
        ->where(function($delpurchasequery){
            $delpurchasequery->where('purchase_invoices.Status', "=", "D");
                            
        });

        // Add the "paidornot" condition
        $paidOrNot = $request->input('PaymentStatus');
        if ($paidOrNot === 'paid') {
            $query->where('purchase_invoices.IsPaid', 1);
        } elseif ($paidOrNot === 'nopaid') {
            $query->where('purchase_invoices.IsPaid', 0);
        }

        if ($request->input('startDate') !== null && $request->input('endDate') !== null) {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            if($endDate < $startDate){
                return back()->with('warning','start date must be lower than end date');
            }


            $query->whereBetween('purchase_invoices.PurchaseDate', [$startDate, $endDate]);
            $deletepurchaseinvoicesquery->whereBetween('purchase_invoices.PurchaseDate', [$startDate, $endDate]);
        } else if ($request->input('startDate') !== null && $request->input('endDate') == null) {
            $query->where('purchase_invoices.PurchaseDate', '>=', $request->input('startDate'));
            $deletepurchaseinvoicesquery->where('purchase_invoices.PurchaseDate', '>=', $request->input('startDate'));
        } else if ($request->input('startDate') == null && $request->input('endDate') !== null) {
            $query->where('purchase_invoices.PurchaseDate', '<=', $request->input('endDate'));
            $deletepurchaseinvoicesquery->where('purchase_invoices.PurchaseDate', '<=', $request->input('endDate'));
        }else{
            $query->where('purchase_invoices.PurchaseDate', '>=', $this->currentMonth . '-01')
                  ->where('purchase_invoices.PurchaseDate', '<=', $this->currentMonth . '-31');

            $deletepurchaseinvoicesquery->where('purchase_invoices.PurchaseDate', '>=', $this->currentMonth . '-01')
            ->where('purchase_invoices.PurchaseDate', '<=', $this->currentMonth . '-31');
        }

        $purchaseinvoices = $query->get();
        $deletepurchaseinvoices = $deletepurchaseinvoicesquery->get();
        

        $companyinfo = CompanyInformation::first();


        return view('reports.purchasereports', [
            'purchaseinvoices' => $purchaseinvoices,
            'deletepurchaseinvoices' => $deletepurchaseinvoices,
            'companyinfo' => $companyinfo,
        ]);
    }
}
