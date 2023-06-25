<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemRole extends Model
{
    use HasFactory;

    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'ModifiedDate';

    protected $fillable = [
        'RoleId',
        'RoleDesc',
        'RolePermissions',
        'Remark',
        'CreatedBy',
        'ModifiedBy',
        'CreatedDate',
        'ModifiedDate'
    ];

    public function users(){
        return $this->hasMany(User::class);
    }
}
