<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockDamage extends Model
{
    use HasFactory;
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'ModifiedDate';
    const DELETED_AT = 'DeletedDate';

    public $timestamps = false;

    protected $primaryKey = 'DamageNo';

    protected $casts = [
        'DamageNo' => 'string',
    ];

    protected $fillable = [
        'DamageNo',
        'DamageDate',
        'WarehouseNo',
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
