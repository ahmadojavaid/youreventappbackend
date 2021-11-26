<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class ScheduleTiming extends Model
{
    protected $fillable = ['session_id', 'from', 'status', 'to'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}



