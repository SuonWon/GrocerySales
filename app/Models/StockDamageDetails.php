<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockDamageDetails extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'DamageNo',
        'LineNo',
        'ItemCode',
        'Quantity',
        'QtyPerUnit',
        'PackedUnit',
        'TotalViss',
        'UnitPrice',
        'Amount'
    ];
}
