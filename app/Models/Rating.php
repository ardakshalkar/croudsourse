<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    //use SoftDeletes;

    public $table = 'rating';
    

    //protected $dates = ['deleted_at'];


    public $fillable = [
        'translation_id',
        'user_ids',
        'count'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'translation_id' => 'integer',
        'user_ids' => 'string',
        'count' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function translation()
    {
        return $this->belongsTo(\App\Models\Post::class, 'translation_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
}
