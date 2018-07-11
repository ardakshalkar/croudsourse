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
class Role extends Model
{
    use SoftDeletes;

    public $table = 'roles';
    

   // protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'description' => 'required'
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
    public function users()
    {
        return $this->belongsToMany(\App\Models\Post_tag::class, 'role_user', 'role_id', 'user_id');
    }
}
