<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvoiceDetails extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'ReferenceNo';

    protected $casts = [
        'ReferenceNo' => 'string',
    ];

    protected $fillable = [ 
        'InvoiceNo',
        'ReferenceNo',
        'WarehouseNo',
        'ItemCode',
        'Quantity',
        'PackedUnit',
        'QtyPerUnit',
        'TotalViss',
        'UnitPrice',
        'Amount',
        'LineDisPer',
        'LineDisAmt',
        'LineTotalAmt',
        'IsFOC'

    ];
}
