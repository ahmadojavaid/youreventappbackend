<?php


namespace App;

use Illuminate\Database\Eloquent\Model;


class SessionNote extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = true;
    public function session(){
        return $this->belongsTo(Sessions::class);
    }

}