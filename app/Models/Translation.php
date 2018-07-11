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
class Translation extends Model
{
    use SoftDeletes;

    public $table = 'translations';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'post_id',
        'user_id',
        'content',
        'rating_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'post_id' => 'integer',
        'user_id' => 'integer',
        'content' => 'string',
        'rating_id' => 'integer'
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
    public function post()
    {
        return $this->belongsTo(\App\Models\Post::class, 'post_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    public function rating()
    {
        return $this->hasOne(\App\Models\Rating::class);
    }
}
