<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Person;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private $id;
    private $user_name;
    private $email;
    private $password;

    protected $guarded = ['id'];
    protected $hidden = [
        "inforce","created_at","updated_at",'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password)
    {
        if ( !empty($password) ) {
            $this->attributes['password'] = bcrypt($password);
        }
    }
    public function user_type(){
        return $this->belongsTo('App\Models\UserType','user_type_id');
    }

    public function user_to_person(){
        return $this->hasMany('App\Models\UserToPerson','user_id');
    }

    // public function person_old()
    // {
    //     return $this->belongsToMany(Person::class,UserToPerson::class,'user_id','person_id')->wherePivot('active', '=', 1);
    // }
    public function person()
    {
        return $this->belongsTo(Person::class,'person_id');
    }

    public function generalWorkers(){

    }
}
