<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'ModifiedDate';

    protected $primaryKey = 'SupplierCode';

    protected $casts = [
        'SupplierCode' => 'string',
    ];

    protected $fillable = [
        'SupplierCode',
        'SupplierName',
        'ContactName',
        'ContactNo',
        'OfficeNo',
        'Street',
        'Township',
        'City',
        'IsActive',
        'Remark',
        'CreatedBy',
        'CreatedDate',
        'ModifiedBy',
        'ModifiedDate'
    ];
}
