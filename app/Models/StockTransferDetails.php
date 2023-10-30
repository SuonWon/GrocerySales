<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransferDetails extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'TransferNo',
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
