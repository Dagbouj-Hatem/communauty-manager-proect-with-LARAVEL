<?php

namespace App;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Page;
use App\Comment;
/**
 * Class Post
 * @package App
 * @version January 18, 2019, 3:41 am UTC
 *
 * @property string content
 * @property string post_id
 */
class Post extends Model
{
    use SoftDeletes;

    public $table = 'posts';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'content',
        'post_id',
        'image_url',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'content' => 'string',
        'post_id' => 'string',
        'image_url' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'content' => 'required'
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
