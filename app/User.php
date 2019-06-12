<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Yadahan\AuthenticationLog\AuthenticationLogable;  
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{

    use Notifiable, AuthenticationLogable,HasRoles;

     public $table = 'users';
    

   // protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'role',
        'photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'mobile' => 'string',
        'role' => 'integer',
        'photo' => 'string'
    ];
    
}
