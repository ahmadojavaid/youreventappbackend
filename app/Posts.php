<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;  
class Posts extends Model implements AuthenticatableContract 
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userId','postTitile', 'postDescription','postLikesCount','postCommentsCount','postSharesCount','postMediaType','postType',
    ];

     public function post($followersPosts,$userId,$users)
    {
        $result = self::with(['comments','postattachments','postlikes'])
                      ->orwhere('userId',$userId)
                      ->orwhereIn('userId',$followersPosts)
                      ->whereNotIn('posts.id',(array)$users)
                      ->join('users','users.id','=','posts.userId')
                      ->select('posts.*','users.name','users.profileImage')
                      ->orderBy('posts.updated_at','desc')
                      ->paginate(15);
                      // ->get();
        return $result;
    }
        public function comments()
    {
        return $this->hasMany('App\PostComments','postId')->join('users','users.id','=','post_comments.userId')->orderBy('post_comments.created_at','desc')->select('post_comments.*','users.name','users.profileImage');//->select(DB::raw('(start_time-end_time) AS total_sales'));
    }  
        public function postlikes()
    {
        return $this->hasMany('App\PostLikes','postId')->join('users','users.id','=','post_likes.userId');//->select(DB::raw('(start_time-end_time) AS total_sales'));
    }      
    //   
      public function postattachments()
    {
        return $this->hasMany('App\PostAttachements','postId');//->join('users','users.id','=','post_likes.userId');//->select(DB::raw('(start_time-end_time) AS total_sales'));
    }        
     public function pinned($postId)
    {
        $result =  self::with(['comments','postattachments'])
                      ->where('posts.id',$postId) 
                      ->join('users','users.id','=','posts.userId')
                      ->select('posts.*','users.name','users.profileImage')
                      ->get();
        return $result;
    } 
    //.........reversing the above content for comments

     public function post1($followersPosts,$userId)
    {
        $result = self::with(['comments1','postattachments1','postlikes1'])
                      ->orwhere('userId',$userId)
                      ->orwhereIn('userId',$followersPosts)
                      ->join('users','users.id','=','posts.userId')
                      ->select('posts.*','users.name','users.profileImage')
                      ->orderBy('posts.updated_at','desc')
                      ->get();
        return $result;
    }
        public function comments1()
    {
        return $this->hasMany('App\PostComments','postId')->join('users','users.id','=','post_comments.userId')->orderBy('post_comments.created_at','asc')->select('post_comments.*','users.name','users.profileImage');//->select(DB::raw('(start_time-end_time) AS total_sales'));
    }  
        public function postlikes1()
    {
        return $this->hasMany('App\PostLikes','postId')->join('users','users.id','=','post_likes.userId');//->select(DB::raw('(start_time-end_time) AS total_sales'));
    }      
    //   
      public function postattachments1()
    {
        return $this->hasMany('App\PostAttachements','postId');//->join('users','users.id','=','post_likes.userId');//->select(DB::raw('(start_time-end_time) AS total_sales'));
    }       

     public function pinned1($postId)
    {
        $result =  self::with(['comments1','postattachments1'])
                      ->where('posts.id',$postId) 
                      ->join('users','users.id','=','posts.userId')
                      ->select('posts.*','users.name','users.profileImage')
                      ->get();
        return $result;
    }

     public function singlepost($postId)
    {
        $result = self::with(['comments','postattachments','postlikes'])
                      ->where('posts.id',$postId)
                      ->join('users','users.id','=','posts.userId')
                      ->select('posts.*','users.name','users.profileImage')
                      ->orderBy('posts.updated_at','desc')
                      ->get();
        return $result;
    }

     public function AllpostForADmin()
    {
        $result = self::with(['comments','postattachments','postlikes'])
                      // ->where('posts.id',$postId)
                      ->join('users','users.id','=','posts.userId')
                      ->select('posts.*','users.name','users.profileImage')
                      ->orderBy('posts.updated_at','desc')
                      ->paginate(20);
                      // ->get();
        return $result;
    }
  
}
