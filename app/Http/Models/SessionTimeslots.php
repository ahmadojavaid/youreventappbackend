<?php
/**
 * Created by PhpStorm.
 * User: JBBravo
 * Date: 10-Jun-19
 * Time: 12:10 PM
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class SessionTimeslots extends Model
{
    protected $fillable = ['SESSION_ID', 'TIME_FROM', 'TIME_TO', 'MESSAGE', 'STATUS','ATTENDEE_ID','CREATED_AT','UPDATED_AT','ATTENDEE_ID'];

    protected $table = "session_timeslots";

}