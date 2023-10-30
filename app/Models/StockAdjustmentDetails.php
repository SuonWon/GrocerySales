<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAdjustmentDetails extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'AdjustmentNo',
        'LineNo',
        'ItemCode',
        'Quantity',
        'QtyPerUnit',
        'PackedUnit',
        'TotalViss',
        'UnitPrice',
        'Amount',
        'AdjustType'
    ];
}
