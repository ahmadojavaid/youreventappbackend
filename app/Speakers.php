<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;  
class Speakers extends Model implements AuthenticatableContract 
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'speakerName','speakerOccupation','speakerCompanyName','speakerDetails','speakerAddedBy','sponsorshipLevel','sponsorwebLink','speakerSurname',
    ];

    public function speaker($id)
    {
        $result = self::with(['sessions'])
            ->join('session_speakers','session_speakers.speakerId','=','speakers.id')
            ->join('sessions','sessions.id','=','session_speakers.sessionId')
        			 ->where('speakers.id',$id)
            //
               // ->orwhereDate('sessions.date', '>=', Carbon::now())
                     ->get();
 
        return $result;
    } 
        public function sessions()
    {
        return $this->hasMany('App\SessionSpeakers','speakerId')->join('sessions','sessions.id','=','session_speakers.sessionId');//->with('documents');//->join('users','users.id','=','property_reviews.userId');//->select(DB::raw('(start_time-end_time) AS total_sales'));
    }  

}
