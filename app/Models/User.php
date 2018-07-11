<?php

namespace App\Models;
use App\Role as Role;
use Eloquent as Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\newCom;

/**
 * Class User
 * @package App\Models
 * @version March 12, 2018, 5:31 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection Post
 * @property \Illuminate\Database\Eloquent\Collection Translation
 * @property string name
 * @property string email
 * @property string password
 * @property boolean anonymous
 * @property string remember_token
 */
class User extends Model
{
    use Notifiable;
    use SoftDeletes;

    public $table = 'users';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'email',
        'password',
        'anonymous',
        'remember_token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'anonymous' => 'boolean',
        'remember_token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function posts()
    {
        return $this->hasMany(\App\Models\Post::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function translations()
    {
        return $this->hasMany(\App\Models\Translation::class);
    }

    public function display(){
        if ($this->anonymous){
            return "Аноним #".$this->id;
        }
        else{
            return $this->name;
        }
    }

    public function roles(){
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    function socialProviders(){
        return $this->hasMany(socialProvider::class);
    }
}
