<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    use HasFactory;

    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'ModifiedDate';
    const DELETED_AT = 'DeletedDate';

    public $timestamps = false;

    protected $primaryKey = 'AdjustmentNo';

    protected $casts = [
        'AdjustmentNo' => 'string',
    ];

    protected $fillable = [
        'AdjustmentNo',
        'AdjustmentDate',
        'Warehouse',
        'Remark',
        'Status',
        'CreatedBy',
        'ModifiedBy',
        'DeletedBy',
        'CreatedDate',
        'ModifiedDate',
        'DeletedDate'
    ];
}
