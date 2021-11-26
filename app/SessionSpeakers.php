<?php

namespace App;
use App\SessionSpeakers;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;  
class SessionSpeakers extends Model implements AuthenticatableContract 
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sessionId','speakerId', 
    ];

    //   public function SessionSpeakers()
    // {
    //     return $this->belongsTo('App\Sessions','speakerId','id');
    // }

 }
