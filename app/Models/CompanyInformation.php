<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInformation extends Model
{
    use HasFactory;

    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'ModifiedDate';
    
    protected $primaryKey = 'CompanyCode';

    protected $casts = [
        'CompanyCode' => 'string',
    ];

    protected $fillable = [
        'CompanyCode',
        'CompanyName',
        'CompanyLogo',
        'Street',
        'City',
        'OfficeNo',
        'HotLineNo',
        'CreatedBy',
        'CreatedDate',
        'ModifiedBy',
        'ModifiedDate'
    ];
}
