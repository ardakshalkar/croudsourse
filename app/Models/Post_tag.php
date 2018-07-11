<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Translation
 * @package App\Models
 * @version March 7, 2018, 6:41 am UTC
 *
 * @property \App\Models\Post post
 * @property \App\Models\User user
 * @property integer post_id
 * @property integer user_id
 * @property string content
 */
class Post_tag extends Model
{
    use SoftDeletes;

    public $table = 'post_tag';
    

    //protected $dates = ['deleted_at'];


    public $fillable = [
        'post_id',
        'tag_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'post_id' => 'integer',
        'tag_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function post()
    {
        return $this->belongsTo(\App\Models\Post::class, 'post_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function tag()
    {
        return $this->belongsTo(\App\Models\Tag::class, 'tag_id', 'id');
    }
}
