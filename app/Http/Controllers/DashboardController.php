<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Item;
use App\Models\ItemArrival;
use App\Models\PurchaseInvoice;
use Illuminate\Http\Request;
use App\Models\SaleInvoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class DashboardController extends Controller
{

    protected $datetime;
    protected $currentMonth;

    public function __construct()
    {


        $this->datetime = Date('Y-m-d H:i:s');
        $this->currentMonth = date('Y-m');

    }

    public function index()
    {

        // Sale
        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfMonth()->toDateString();

        $saleInvoices = Saleinvoice::whereBetween('SalesDate', [$startDate, $endDate])->whereStatus('O')->get();


        $totalsaleinvoice = $saleInvoices->count();
        $totalsaleamount = $saleInvoices->sum('GrandTotal');

        $salecredit = SaleInvoice::whereBetween('SalesDate', [$startDate, $endDate])->whereStatus('O')->where('IsPaid', 0)->get();
        $salecreditamount = $salecredit->sum('GrandTotal');
        $salecreditinvoice = $salecredit->count();

        $recentsaleinvoice = SaleInvoice::orderBy('SalesDate', 'desc')->join('customers', 'sale_invoices.CustomerCode', '=', 'customers.CustomerCode')
            ->select('sale_invoices.*', 'customers.CustomerCode', 'customers.CustomerName')
            ->limit(10)->where('sale_invoices.Status', 'O')->get();

        // Purchase
        $purchaseinvoices = PurchaseInvoice::whereBetween('PurchaseDate', [$startDate, $endDate])->whereStatus('O')->get();



        $totalpurchaseinvoice = $purchaseinvoices->count();
        $totalpurchaseamount = $purchaseinvoices->sum('GrandTotal');
        $purchasecredit = PurchaseInvoice::whereBetween('PurchaseDate', [$startDate, $endDate])
                                    ->whereStatus('O')
                                    ->where('IsPaid', 0)
                                    ->get();
        $purchasecreditinvoice = $purchasecredit->count();
        $purchasecreditamount = $purchasecredit->sum('GrandTotal');
        
        $recentpurchaseinvoice = PurchaseInvoice::orderBy('PurchaseDate', 'desc')->join('suppliers', 'purchase_invoices.SupplierCode', '=', 'suppliers.SupplierCode')
            ->select('purchase_invoices.*', 'suppliers.SupplierCode', 'suppliers.SupplierName')
            ->limit(10)->where('purchase_invoices.Status', 'O')->get();

        // Last 10 Products (Items)
        $items = Item::join('purchase_invoice_details', 'purchase_invoice_details.ItemCode', '=', 'items.ItemCode')
            ->join('purchase_invoices', 'purchase_invoices.InvoiceNo', '=', 'purchase_invoice_details.InvoiceNo')
            ->join('unit_measurements', 'unit_measurements.UnitCode', '=', 'purchase_invoice_details.PackedUnit')
            ->orderBy('purchase_invoices.PurchaseDate', 'desc')
            ->orderBy('purchase_invoices.InvoiceNo', 'desc')
            ->limit(10)->where('purchase_invoices.Status', 'O')->get();

        // Top Ten Customers
        $topTenCustomers = Customer::join('sale_invoices', 'customers.CustomerCode', '=', 'sale_invoices.CustomerCode')
            ->select('customers.CustomerCode', 'customers.CustomerName', 'customers.NRCNo', 'customers.Street', 'customers.City', 'customers.Region', DB::raw('SUM(sale_invoices.GrandTotal) as amount'), DB::raw("CONCAT(customers.Street, ', ', customers.City, ', ', customers.Region) as address"))
            ->groupBy('customers.CustomerCode', 'customers.CustomerName', 'customers.NRCNo', 'customers.Street', 'customers.City', 'customers.Region')
            ->orderBy('amount', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.index', [
            'totalsaleinvoice' => $totalsaleinvoice,
            'totalsaleamount' => $totalsaleamount,
            'totalsalecreditinvoice' => $salecreditinvoice,
            'totalsalecreditamount' => $salecreditamount,
            'recentsaleinvoice' => $recentsaleinvoice,

            'totalpurchaseinvoice' => $totalpurchaseinvoice,
            'totalpurchaseamount' => $totalpurchaseamount,
            'totalpurchasecreditinvoice' => $purchasecreditinvoice,
            'totalpurchasecreditamount' => $purchasecreditamount,
            'recentpurchaseinvoice' => $recentpurchaseinvoice,

            'toptencustomers' => $topTenCustomers,
            'items' => $items
        ]);

    }
}
