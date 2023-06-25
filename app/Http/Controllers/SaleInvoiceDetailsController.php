<?php

namespace App\Http\Controllers;

use App\Models\SaleInvoiceDetails;
use Illuminate\Http\Request;

class SaleInvoiceDetailsController extends Controller
{
    protected $datetime;

    public function __construct()
    {


        $this->datetime = Date('Y-m-d H:i:s');
       
    }

    public function index(){
        $saleinvoicesdetails  =  SaleInvoiceDetails::orderBy('sale_invoice_details.InvoiceNo','desc')
        ->join('warehouses','sale_invoice_details.WarehouseNo','=','warehouses.WarehouseCode')
        ->join('items','sale_invoice_details.ItemCode','=','items.ItemCode')
        ->join('unit_measurements','sale_invoice_details.PackedUnit','=','unit_measurements.UnitCode')
        ->select('sale_invoice_details.*', 'warehouses.WarehouseCode','warehouses.WarehouseName','items.ItemCode','items.ItemName','unit_measurements.UnitCode','unit_measurements.UnitDesc')
        ->get();

        return view('salesdetails.index',[
            'saleinvoicesdetails' => $saleinvoicesdetails
        ]);
    }
}
