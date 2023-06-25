<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory;

    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'ModifiedDate';

      protected $fillable = [

        'CustomerCode',
        'CustomerName',
        'NRCNo',
        'CompanyName',
        'Street',
        'City',
        'Region',
        'ContactNo',
        'OfficeNo',
        'Email',
        'Remark',
        'IsActive',
        'CreatedBy',
        'ModifiedBy',
        'CreatedDate',
        'ModifiedDate'
    ];

    // public static function generatePrimaryKeyId($table,$idFieldName)
    // {
    //     $lastId = DB::table($table)->orderBy($idFieldName, 'desc')->first()->$idFieldName ?? 0;
    //     $lastId = trim($lastId, "C-");

    //     $newId = 'C-' . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
    //     return $newId;
    // }


 
}
