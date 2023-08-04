<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoiceDetail extends Model
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
        'LineNo',
        'WarehouseNo',
        'ItemCode',
        'Quantity',
        'NewQuantity',
        'PackedUnit',
        'QtyPerUnit',
        'ExtraViss',
        'TotalViss',
        'UnitPrice',
        'Amount',
        'LineDisPer',
        'LineDisAmt',
        'LineTotalAmt',
        'IsFOC'
    ];
}
