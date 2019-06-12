<?php

namespace App;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Post;
/**
 * Class Page
 * @package App
 * @version January 12, 2019, 8:48 am UTC
 *
 * @property string url
 * @property string name
 * @property string id_fb_page
 * @property string picture
 * @property string access_token
 */
class Page extends Model
{
    use SoftDeletes;

    public $table = 'pages';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'url',
        'name',
        'about',
        'id_fb_page',
        'picture',
        'cover_photo',
        'access_token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'url' => 'string',
        'name' => 'string',
        'about' => 'string',
        'id_fb_page' => 'string',
        'picture' => 'string',
        'cover_photo' => 'string',
        'access_token' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [  
        'about' => 'required',  
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
