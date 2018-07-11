<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // use SoftDeletes;

    public $table = 'tags';
    

   // protected $dates = ['deleted_at'];


    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    // public function post()
    // {
    //     return $this->belongsTo(\App\Models\Post::class, 'user_id', 'id');
    // }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function posts()
    {
        return $this->belongsToMany(\App\Models\Post_tag::class, 'post_tag', 'tag_id', 'post_id');
    }
}
