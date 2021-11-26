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
class Sessions extends Model implements AuthenticatableContract 
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sessionDescription','sessionName','sessionVenue','date','timeFrom','timeTo','eventDate','text_wall',
    ];
 
     public function Sessions()
    {
        $result = self::with(['SessionSponsors','SessionSpeakers','documents'])
                      // ->orwhere('userId',$userId)
                      // ->orwhereIn('userId',$followersPosts)
                      //->join('users','users.id','=','posts.userId')
                      // ->select('posts.*','users.name','users.profileImage')
                      ->orderBy('timeFrom','asc')
                      ->orderBy('created_at','desc')
                      ->get();
        return $result;
    } 

   public function SessionSponsors()
    {
        return $this->hasMany('App\SessionSponsors','sessionId')->join('sponsors','sponsors.id','=','session_sponsors.sponsorId');//->select(DB::raw('(start_time-end_time) AS total_sales'));
    }  

     public function SessionSpeakers()
    {
        return $this->hasMany('App\SessionSpeakers','sessionId')->join('speakers','speakers.id','=','session_speakers.speakerId');//->select(DB::raw('(start_time-end_time) AS total_sales'));
    }   

       public function documents()
    {
        return $this->hasMany('App\SpeakerDocuments','sessionId');//->join('users','users.id','=','property_reviews.userId');//->select(DB::raw('(start_time-end_time) AS total_sales'));
    }  
         public function singleSessions($id)
    {
        $result = self::with(['SessionSponsors','SessionSpeakers','documents'])
                      ->where('id',$id)
                      // ->orwhereIn('userId',$followersPosts)
                       //->join('users','users.id','=','posts.userId')
                      // ->select('posts.*','users.name','users.profileImage')
                      ->orderBy('created_at','desc')
                      ->get();
        return $result;
    }

    public function note(){
         return $this->hasOne(SessionNote::class, 'session_id');
    }


 }
