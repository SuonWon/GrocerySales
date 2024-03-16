<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model 
{
  use HasFactory;

  const CREATED_AT = 'CreatedDate';
  const UPDATED_AT = 'ModifiedDate';

  protected $fillable = [
    'Id',
    'Date',
    'CustomerCode',
    'CashType',
    'Amount',
    'Remark',
    'Status',
    'CreatedBy',
    'CreatedDate',
    'ModifiedDate',
    'ModifiedBy',
    'DeletedBy',
    'DeletedDate'
  ];

  protected $primaryKey = 'Id';

}