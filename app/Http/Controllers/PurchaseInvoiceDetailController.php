<?php

namespace App\Http\Controllers;

use App\Models\PurchaseInvoiceDetail;
use Illuminate\Http\Request;

class PurchaseInvoiceDetailController extends Controller
{
    protected $datetime;

    public function __construct()
    {


        $this->datetime = Date('Y-m-d H:i:s');
       
    }

    public function index(){

        $purchaseinvoicedetails  =  PurchaseInvoiceDetail::orderBy('purchase_invoice_details.InvoiceNo','desc')
        ->join('warehouses','purchase_invoice_details.WarehouseNo','=','warehouses.WarehouseCode')
        ->join('items','purchase_invoice_details.ItemCode','=','items.ItemCode')
        ->join('unit_measurements','purchase_invoice_details.PackedUnit','=','unit_measurements.UnitCode')
        ->select('purchase_invoice_details.*', 'warehouses.WarehouseCode','warehouses.WarehouseName','items.ItemCode','items.ItemName','unit_measurements.UnitCode','unit_measurements.UnitDesc')
        ->get();
       

        return view('purchaseinvoicedetails.index',[
            'purchaseinvoicedetails' => $purchaseinvoicedetails
        ]);
    }
}
