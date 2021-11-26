<?php

namespace App;
use App\SessionSpeakers;
use App\SpeakerDocuments;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;  
class SpeakerDocuments extends Model implements AuthenticatableContract 
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'speakerId','DocattachementURl','documentName','sessionId', 
    ];
    //   public function documents()
    // {
    //     return $this->hasMany('App\SpeakerDocuments','speakerId');//->join('users','users.id','=','property_reviews.userId');//->select(DB::raw('(start_time-end_time) AS total_sales'));
    // } 
     public function documents()
    {
        return $this->belongsTo('App\SpeakerDocuments','speakerId');//->join('users','users.id','=','property_reviews.userId');//->select(DB::raw('(start_time-end_time) AS total_sales'));
    } 
 }
