<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Post
 * @package App\Models
 * @version March 5, 2018, 10:47 am UTC
 *
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection Translation
 * @property string content
 * @property integer user_id
 */
class Post extends Model
{
    use SoftDeletes;

    public $table = 'posts';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'content',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'content' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'content' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function translations()
    {
        return $this->hasMany(\App\Models\Translation::class);
    }

    public function tags()
    {
        return $this->belongsToMany(\App\Models\Post_tag::class, 'post_tag', 'post_id', 'tag_id');
    } 
    
}
