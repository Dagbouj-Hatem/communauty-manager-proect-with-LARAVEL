<?php

namespace App\Repositories;

use App\AuthenticationLog;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AuthenticationLogRepository
 * @package App\Repositories
 * @version January 12, 2019, 4:48 am UTC
 *
 * @method AuthenticationLog findWithoutFail($id, $columns = ['*'])
 * @method AuthenticationLog find($id, $columns = ['*'])
 * @method AuthenticationLog first($columns = ['*'])
*/
class AuthenticationLogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ip_address',
        'user_agent',
        'login_at',
        'logout_at',
        'authenticatable_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AuthenticationLog::class;
    }
}
