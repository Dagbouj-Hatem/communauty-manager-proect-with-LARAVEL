<?php

namespace App\Repositories;

use App\Page;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PageRepository
 * @package App\Repositories
 * @version January 12, 2019, 8:48 am UTC
 *
 * @method Page findWithoutFail($id, $columns = ['*'])
 * @method Page find($id, $columns = ['*'])
 * @method Page first($columns = ['*'])
*/
class PageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'url',
        'name',
        'id_fb_page',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Page::class;
    }
}
