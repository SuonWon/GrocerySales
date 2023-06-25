<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'ModifiedDate';

    protected $primaryKey = 'WarehouseCode';

    protected $casts = [
        'WarehouseCode' => 'string',
    ];

    protected $fillable = [
            'WarehouseCode',
            'WarehouseName',
            'Street',
            'Township',
            'City',
            'ContactNo',
            'Remark',
            'CreatedBy',
            'CreatedDate',
            'ModifiedBy',
            'ModifiedDate'
    ];
}
