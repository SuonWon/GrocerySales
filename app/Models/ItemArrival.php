<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemArrival extends Model
{
    use HasFactory;

    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'ModifiedDate';

    protected $primaryKey = 'ArrivalCode';

    protected $casts = [
        'ArrivalCode' => 'string',
    ];

    protected $fillable = [
        'ArrivalCode',
        'ArrivalDate',
        'PlateNo',
        'ChargesPerBag',
        'TotalBags',
        'OtherCharges',
        'TotalCharges',
        'CreatedBy',
        'CreatedDate',
        'ModifiedBy',
        'ModifiedDate'
    ];
}
