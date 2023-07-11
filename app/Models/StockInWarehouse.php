<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockInWarehouse extends Model
{
    use HasFactory;

    //laravel auto insert create_at and update_at so disable by this property
    public $timestamps = false;

    protected $fillable = [
        'WarehouseCode',
        'ItemCode',
        'StockQty',
        'LastUpdatedDate'
    ];


}
