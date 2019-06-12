<?php

namespace App;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Post;
/**
 * Class Comment
 * @package App
 * @version January 18, 2019, 3:52 am UTC
 *
 * @property string content
 * @property string comment_id
 */
class Comment extends Model
{
    use SoftDeletes;

    public $table = 'comments';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'content',
        'comment_id',
        'post_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'content' => 'string',
        'comment_id' => 'string',
        'post_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'content' => 'required'
    ];

     public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
