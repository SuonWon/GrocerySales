<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvoice extends Model
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
        'SalesDate',
        'CustomerCode',
        'PlateNo',
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
