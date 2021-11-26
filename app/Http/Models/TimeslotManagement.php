<?php
/**
 * Created by PhpStorm.
 * User: JBBravo
 * Date: 12-Jun-19
 * Time: 9:52 AM
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class TimeslotManagement extends Model
{
    protected $fillable = ['SESSION_TIMESLOT_ID', 'SPONSOR_ID', 'ATTENDEE_ID', 'SPONSOR_MESSAGE', 'ATTENDEE_MESSAGE', 'STATUS', 'GENERATED_BY', 'CREATED_BY','UPDATED_BY'];

    protected $table = "timeslot_management";
}