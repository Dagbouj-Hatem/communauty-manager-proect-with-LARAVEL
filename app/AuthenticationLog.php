<?php

namespace App;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AuthenticationLog
 * @package App
 * @version January 12, 2019, 4:48 am UTC
 *
 * @property string ip_address
 * @property string user_agent
 * @property timestamp login_at
 * @property timestamp logout_at
 * @property morphs authenticatable
 */
class AuthenticationLog extends Model
{
    use SoftDeletes;

    public $table = 'authentication_log';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'ip_address',
        'user_agent',
        'login_at',
        'logout_at',
        'authenticatable'
    ];


    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['authenticatable_id', 'authenticatable_type'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'login_at' => 'datetime',
        'logout_at' => 'datetime',
    ];
    /**
     * Get the authenticatable entity that the authentication log belongs to.
     */
    public function authenticatable()
    {
        return $this->morphTo();
    }

    
}
