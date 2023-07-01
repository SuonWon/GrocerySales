<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'ModifiedDate';

    protected $fillable = [
        'ItemCode',
        'ItemName',
        'ItemCategoryCode',
        'BaseUnit',
        'WeightByPrice',
        'UnitPrice',
        'DefSalesUnit',
        'DefPurUnit',
        'LastPurPrice',
        'Discontinued',
        'Remark',
        'CreatedBy',
        'CreatedDate',
        'ModifiedDate',
        'ModifiedBy'
    ];

    protected $primaryKey = 'ItemCode';

    // protected $primaryKey = 'ItemCategoryCode';

    protected $casts = [
        'ItemCode' => 'string',
    ];

    public function itemcategory(){
        return $this->belongsTo(ItemCategory::class,'ItemCategoryCode','ItemCategoryCode');
    }

    public function itemunit(){
        return $this->belongsTo(UnitMeasurement::class,'BaseUnit');
    }
 
}
