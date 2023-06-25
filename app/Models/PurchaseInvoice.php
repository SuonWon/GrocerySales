<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    use HasFactory;

    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'ModifiedDate';

    protected $primaryKey = 'InvoiceNo';

    protected $casts = [
        'InvoiceNo' => 'string',
    ];

    protected $fillable = [
        'InvoiceNo',
        'PurchaseDate',
        'SupplierCode',
        'ArrivalCode',
        'SubTotal',
        'LaborCharges',
        'DeliveryCharges',
        'WeightCharges',
        'ServiceCharges',
        'TotalCharges',
        'GrandTotal',
        'Remark',
        'IsPaid',
        'PaidDate',
        'Status',
        'CreatedBy',
        'CreatedDate',
        'ModifiedBy',
        'ModifiedDate',
        'DeletedBy',
        'DeletedDate'
    ];
}
