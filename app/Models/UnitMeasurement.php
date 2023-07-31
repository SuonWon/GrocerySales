<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitMeasurement extends Model
{
    use HasFactory;
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'ModifiedDate';

    protected $primaryKey = 'UnitCode';

    protected $casts = [
        'UnitCode' => 'string',
    ];

    protected $fillable = [
        'UnitCode',
        'UnitDesc',
        'IsActive',
        'Remark',
        'CreatedBy',
        'CreatedDate',
        'ModifiedDate',
        'ModifiedBy'
    ];

    public function items(){
        return $this->hasMany(Item::class,'BaseUnit');
    }
}
