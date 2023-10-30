<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    use HasFactory;
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'ModifiedDate';
    const DELETED_AT = 'DeletedDate';

    public $timestamps = false;


    protected $primaryKey = 'TransferNo';

    protected $casts = [
        'TransferNo' => 'string',
    ];

    protected $fillable = [
        'TransferNo',
        'TransferDate',
        'FromWarehouse',
        'ToWarehouse',
        'Remark',
        'Status',
        'CreatedBy',
        'ModifiedBy',
        'DeletedBy',
        'CreatedDate',
        'ModifiedDate',
        'DeletedDate'
    ];

    
}
