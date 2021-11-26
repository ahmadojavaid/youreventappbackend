<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;  
class User extends Model implements AuthenticatableContract, AuthorizableContract,JWTSubject
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "users";
    protected $fillable = ['name', 'profile_image','gender','age','mobile','email','address','token','password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    
    protected $hidden = [
        'password',
    ];

     // public function setPasswordAttribute($pass){

     //        $this->attributes['password'] = Hash::make($pass);

     //    }


   public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    } 



     public function userspost($id)
    {
        $result = self::with(['posts'])
                      ->where('id',$id)
                      ->get();
        return $result;
    } 
        public function posts()
    {
        return $this->hasMany('App\Posts','userId')->with('comments','postattachments');//->join('users','users.id','=','post_comments.userId');//->select(DB::raw('(start_time-end_time) AS total_sales'));
    }  
  
     public function chats()
    {
        return $this->hasMany(Messages::class);
    }
    public function timings(){
        return $this->hasMany(ScheduleTiming::class, 'user_id');
    }

}
