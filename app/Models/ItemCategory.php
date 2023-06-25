<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;

    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'ModifiedDate';

    protected $fillable = [
        'ItemCategoryCode',
        'ItemCategoryName',
        'Remark',
        'CreatedBy',
        'CreatedDate',
        'ModifiedDate',
        'ModifiedBy'
    ];

    protected $primaryKey = 'ItemCategoryCode';

    protected $casts = [
        'ItemCategoryCode' => 'string',
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'ItemCategoryCode', 'ItemCategoryCode');
    }
}
