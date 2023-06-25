<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    

    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'ModifiedDate';

    protected $primaryKey = 'Username';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
         'Username',
         'Fullname',
         'Password',
         'SystemRole',
         'IsActive',
         'Remark',
         'remember_token',
         'CreatedBy',
         'ModifiedBy',
         'CreatedDate',
         'ModifiedDate'
    ];

    public function username()
{
    return 'Username';
}

public function getAuthPassword()
{
    return $this->Password;
}

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'Password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function systemrole(){
        return $this->belongsTo(SystemRole::class,'SystemRole','RoleId');
    }

   
}
