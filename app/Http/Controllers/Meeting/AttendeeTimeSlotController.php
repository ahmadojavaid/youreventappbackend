<?php
/**
 * Created by PhpStorm.
 * User: JBBravo
 * Date: 10-Jun-19
 * Time: 12:06 PM
 */

namespace App\Http\Controllers\Meeting;


use App\Http\Controllers\Controller;
use App\Http\Models\TimeslotManagement;
use App\Sessions;
use App\Http\Models\SessionTimeslots;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class AttendeeTimeSlotController extends Controller
{
    public function getTimeSlots(Request $request)
    {

        /*$interval = 1800; // Interval in seconds
        $sessionID = $request->input('session_id');
        $attendeeID = $request->input('attendee_id');

        $result = Sessions::select('id','timeFrom','timeTo')->where('id','=',$sessionID)->first();

        $time_first = date('h:i', strtotime($result->timeFrom));
        $time_second = date('h:i', strtotime($result->timeTo));*/
        //$substr = substr($time_first, -2);

        //generating timesets for the given start and end time
        //storing timesets in DB
        /*if((substr($time_first, -2) == 'AM' && substr($time_second, -2) == 'AM') ||
            (substr($time_first, -2) == 'PM' && substr($time_second, -2) == 'PM')){

            for ($i = $time_first; $i < $time_second; $i += $interval)
            {
                SessionTimeslots::insert([
                    "SESSION_ID" => $result->id, "TIME_FROM" => date('H:i', $i), "TIME_TO" => date('H:i', $i+$interval)
                ]);
            }
        }
        else {

        }*/
        /*for ($i = $time_first; date('H:i ', $i) < date('H:i ', $time_second); $i += $interval)
        {
            SessionTimeslots::insert([
                "SESSION_ID" => $result->id, "TIME_FROM" => date('H:i ', $i), "TIME_TO" => date('H:i ', $i+$interval)
            ]);
        }*/


        $array = array();
        for($i = strtotime('14:00:00'); $i <= strtotime('17:00:00'); $i += 1800) {
            $array [] = date('h:i A', $i);
        }

        for($i = 1; $i < count($array); $i++){
            if(!empty($array[$i+1])){
                SessionTimeslots::insert([
                    "SESSION_ID" => 1, "TIME_FROM" => $array[$i], "TIME_TO" => $array[$i+1]
                ]);
            }
        }

        /*$currentTime = "11:00";
        $endTime = "6:00";
        $from = Carbon::createFromFormat('H:s', $currentTime);
        $to = Carbon::createFromFormat('H:s', $endTime);
        $startingTime = $currentTime;
        $endingTime = $endTime;
        $total = $to->diffInHours($from);
        $timefrom = array();
        $timeto = array();
        for ($i = 0; $i <= $total; $i++) {
            $currentTime = date("H:i A", strtotime($currentTime));
            array_push($timefrom, $currentTime);
            $currentTime = date("H:i", strtotime($currentTime . " +60 MINUTE"));
        }
        $currentTime = strtotime($startingTime . "+30 MINUTE");
        $currentTime = date('H:i A', $currentTime);
        for ($i = 0; $i < $total - 1; $i++) {
            array_push($timeto, $currentTime);
            $currentTime = date("H:i A", strtotime($currentTime . " +60 MINUTE"));
            array_push($timeto, $currentTime);
        }*/
        /*$attendeeSlots = AttendeeTimeslots::select('SESSION_TIMESLOT_ID')->where('ATTENDEE_ID',$attendeeID)->get();
        $availableTimeSlots = SessionTimeslots::where("SESSION_ID",$result->id)
            ->whereNotIn("ID",$attendeeSlots)
            ->get();*/
        /*$NotConfirmedTimeSlots = SessionTimeslots::join('allotted_timeslots','allotted_timeslots.SESSION_TIMESLOT_ID','=','session_timeslots.ID')
            ->where("SESSION_ID",$result->id)->get();
        $CancelledTimeSlots = SessionTimeslots::join("allotted_timeslots")->where("SESSION_ID",$result->id)->get();*/
        return response()->json(['statusCode' => '1', 'statusMessage' => 'available event timeslots', 'FirstTime' => $array]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * This function returns available slots for Attendee
     */
    public function AvailTimeSlots(Request $request)
    {

        //Validating the request
        $validator = Validator::make($request->all(), [

            'attendee_id' => 'required|numeric',
            'sponsor_id' => 'required|numeric'
        ], [

            'attendee_id.required' => 'Attendee ID is required',
            'sponsor_id.required' => 'Sponsor ID is required',
        ]);


        if ($validator->fails()) {
            //Getting error messages and sending them in response
            $errorMsg = $validator->messages();
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Error! Parameters Missing', 'Result' => $errorMsg], 422);
        } else {
            $attendeeID = $request->input('attendee_id');
            $sponsorID = $request->input('sponsor_id');

            $occupiedSlotsSponsor = TimeslotManagement::join('session_timeslots', 'session_timeslots.ID', '=', 'timeslot_management.SESSION_TIMESLOT_ID')
                ->select('SESSION_TIMESLOT_ID')
                ->where('SPONSOR_ID', $sponsorID)
                ->where('STATUS', 'Confirmed')
                ->get();

            $occupiedSlotsAttendee = TimeslotManagement::join('session_timeslots', 'session_timeslots.ID', '=', 'timeslot_management.SESSION_TIMESLOT_ID')
                ->select('SESSION_TIMESLOT_ID')
                ->where('ATTENDEE_ID', $attendeeID)
                ->where('STATUS', 'Confirmed')
                ->get();

            $availableTimeSlots = SessionTimeslots::selectRaw("session_timeslots.ID,TIME_FROM,TIME_TO")
                ->whereNotIn("session_timeslots.ID", $occupiedSlotsSponsor)
                ->whereNotIn("session_timeslots.ID", $occupiedSlotsAttendee)
                ->get();

            $eventDate = Sessions::selectRaw("DATE_FORMAT(eventDate, '%M %e, %Y') as DATE")->first();

            return response()->json(['statusCode' => '1', 'statusMessage' => 'Available time slots', 'Result' => $availableTimeSlots, 'eventDate' => $eventDate]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * This function returns Not confirmed attendees
     */
    public function attendeeNotConfirmedTS(Request $request)
    {

        //Validating the request
        $validator = Validator::make($request->all(), [

            'attendee_id' => 'required|numeric',
            'sponsor_id' => 'required|numeric',
        ], [

            'attendee_id.required' => 'Attendee ID is required',
            'sponsor_id.required' => 'Sponsor ID is required',
        ]);


        if ($validator->fails()) {
            //Getting error messages and sending them in response
            $errorMsg = $validator->messages();
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Error! Parameters Missing', 'Result' => $errorMsg], 400);
        } else {
            $attendeeID = $request->input('attendee_id');
            $sponsorID = $request->input('sponsor_id');
            $result = TimeslotManagement::join('session_timeslots', 'session_timeslots.ID', '=', 'timeslot_management.SESSION_TIMESLOT_ID')
                ->select('timeslot_management.ID', 'SESSION_ID', 'TIME_FROM', 'TIME_TO', 'ATTENDEE_MESSAGE', 'SPONSOR_MESSAGE', 'STATUS')
                ->where('ATTENDEE_ID', '=', $attendeeID)
                ->where('SPONSOR_ID', '=', $sponsorID)
                ->where('GENERATED_BY', 2)
                ->where('STATUS', '!=', 'Confirmed')
                ->get();

            return response()->json(['statusCode' => '1', 'statusMessage' => 'Not Confirmed/Cancelled time slots', 'Result' => $result]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function attendeeConfirmedTS(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'attendee_id' => 'required|numeric',
            'sponsor_id' => 'required|numeric'
        ], [

            'attendee_id.required' => 'Attendee ID is required',
            'sponsor_id.required' => 'Sponsor ID is required',
        ]);


        if ($validator->fails()) {
            //Getting error messages and sending them in response
            $errorMsg = $validator->messages();
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Error! Parameters Missing', 'Result' => $errorMsg], 400);
        } else {
            $attendeeID = $request->input('attendee_id');
            $sponsorID = $request->input('sponsor_id');
            $result = TimeslotManagement::join('session_timeslots', 'session_timeslots.ID', '=', 'timeslot_management.SESSION_TIMESLOT_ID')
                ->select('timeslot_management.ID','TIME_FROM', 'TIME_TO', 'ATTENDEE_MESSAGE', 'SPONSOR_MESSAGE', 'STATUS')
                ->where('ATTENDEE_ID', '=', $attendeeID)
                ->where('SPONSOR_ID','=',$sponsorID)
                ->where('STATUS', 'Confirmed')
                ->where('GENERATED_BY',2)
                ->get();

            return response()->json(['statusCode' => '1', 'statusMessage' => 'Confirmed time slots', 'Result' => $result]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function attendeeRequestTS(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'timeslot_id' => 'required|numeric',
            'attendee_id' => 'required|numeric',
            'sponsor_id' => 'required|numeric',
            'message' => 'max:300',
        ], [

            'timeslot_id.required' => 'Time Slot ID is required',
            'attendee_id.required' => 'Attendee ID is required',
            'sponsor_id.required' => 'Sponsor ID is required',
            'message.max' => 'Maximum String Length Exceeded',
        ]);

        if ($validator->fails()) {
            //Getting error messages and sending them in response
            $errorMsg = $validator->messages();
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Error! Parameters Missing', 'Result' => $errorMsg], 400);
        } else {
            $timeSlotID = $request->input('timeslot_id');
            $attendeeID = $request->input('attendee_id');
            $sponsorID = $request->input('sponsor_id');
            $message = $request->input('message');

            //Data validation
            $validation = TimeslotManagement::where('ATTENDEE_ID','=',$attendeeID)
                ->where('SPONSOR_ID','=',$sponsorID)
                ->where('SESSION_TIMESLOT_ID','=',$timeSlotID)
                ->where('STATUS','Not Confirmed')
                ->get();

            if(count($validation)>0){
                return response()->json(['statusCode' => '0', 'statusMessage' => 'Error! Request is already registered for this Time Slot','Result' => NULL],409);
            }
            else{
                $timeslotRequest = new TimeslotManagement();

                $timeslotRequest->SESSION_TIMESLOT_ID = $timeSlotID;
                $timeslotRequest->ATTENDEE_ID = $attendeeID;
                $timeslotRequest->SPONSOR_ID = $sponsorID;
                $timeslotRequest->GENERATED_BY = 2;
                $timeslotRequest->ATTENDEE_MESSAGE = $message;
                $timeslotRequest->STATUS = 'Not Confirmed';
                $timeslotRequest->save();

                return response()->json(['statusCode' => '1', 'statusMessage' => 'Time Slot Request Registered', 'Result' => NULL]);
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function attendeeCancelledTS(Request $request)
    {
        //Validating the request
        $validator = Validator::make($request->all(), [
            'attendee_id' => 'required|numeric',
        ], [
            'attendee_id.required' => 'Attendee ID is required',
        ]);


        if ($validator->fails()) {
            //Getting error messages and sending them in response
            $errorMsg = $validator->messages();
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Error! Parameters Missing', 'Result' => $errorMsg], 400);
        } else {
            $attendeeID = $request->input('attendee_id');
            $result = TimeslotManagement::join('session_timeslots', 'session_timeslots.ID', '=', 'timeslot_management.SESSION_TIMESLOT_ID')
                ->join('users', 'users.id', '=', 'timeslot_management.SPONSOR_ID')
                ->select('timeslot_management.ID','name as NAME','Surname as SURNAME','profileImage as PROFILE_IMAGE', 'TIME_FROM', 'TIME_TO','ATTENDEE_MESSAGE', 'SPONSOR_MESSAGE')
                ->where('ATTENDEE_ID', '=', $attendeeID)
                ->where('GENERATED_BY', 1)
                ->where('STATUS', '=', 'Cancelled')
                ->get();

            return response()->json(['statusCode' => '1', 'statusMessage' => 'Cancelled time slots', 'Result' => $result]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchAttendeeRequests(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'attendee_id' => 'required|numeric',
        ], [

            'attendee_id.required' => 'Attendee ID is required',
        ]);

        if ($validator->fails()) {
            //Getting error messages and sending them in response
            $errorMsg = $validator->messages();
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Error! Parameters Missing', 'Result' => $errorMsg], 400);
        } else {
            $attendeeID = $request->input('attendee_id');

            $result = TimeslotManagement::join('session_timeslots', 'session_timeslots.ID', '=', 'timeslot_management.SESSION_TIMESLOT_ID')
                ->join('users', 'users.id', '=', 'timeslot_management.SPONSOR_ID')
                ->select('timeslot_management.ID','SPONSOR_ID', 'name as NAME','Surname as SURNAME','profileImage as PROFILE_IMAGE', 'TIME_FROM', 'TIME_TO', 'SPONSOR_MESSAGE')
                ->where('ATTENDEE_ID', '=', $attendeeID)
                ->where('GENERATED_BY', 1)
                ->where('STATUS', '=', 'Not Confirmed')
                ->get();

            $eventDate = Sessions::selectRaw("DATE_FORMAT(eventDate, '%M %e, %Y') as DATE")->first();
            return response()->json(['statusCode' => '1', 'statusMessage' => 'List of Requests Received', 'Result' => $result,
                'eventDate' => $eventDate]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function AttendeeRequestResponse(Request $request)
    {

        //Validating the request
        $validator = Validator::make($request->all(), [

            'timeslot_manage_id' => 'required|numeric',
            'status' => 'in:Confirmed,Cancelled',
            'sponsor_id' => 'required|numeric',
            'attendee_id' => 'required|numeric',
        ], [

            'timeslot_manage_id.required' => 'Time Slot Management ID is required',
            'status.in' => 'Only Confirmed or Cancelled Status is Allowed',
            'sponsor_id.required' => 'Sponsor ID is required',
            'attendee_id.required' => 'Attendee ID is required'
        ]);


        if ($validator->fails()) {
            //Getting error messages and sending them in response
            $errorMsg = $validator->messages();

            return response()->json(['statusCode' => '0', 'statusMessage' => 'Error! Parameters Missing or Wrong', 'Result' => $errorMsg], 400);
        }
        else {

            $timeslotID = $request->input('timeslot_manage_id');
            $message = $request->input('message');
            $status = $request->input('status');
            $sponsorID = $request->input('sponsor_id');
            $attendeeID = $request->input('attendee_id');

            //validation for duplicate

            $getSessionTimeslotID = TimeslotManagement::where('ID', '=', $timeslotID)->pluck('SESSION_TIMESLOT_ID')->first();

            $validateSponsor = TimeslotManagement::where('SESSION_TIMESLOT_ID', '=', $getSessionTimeslotID)
                ->where('STATUS', '=', 'Confirmed')
                ->where('SPONSOR_ID', '=', $sponsorID)
                ->get();

            $validateAttendee = TimeslotManagement::where('SESSION_TIMESLOT_ID', '=', $getSessionTimeslotID)
                ->where('STATUS', '=', 'Confirmed')
                ->where('ATTENDEE_ID', '=', $attendeeID)
                ->get();

            if(count($validateSponsor) != 0 || count($validateAttendee) != 0){
                return response()->json(['statusCode' => '0', 'statusMessage' => 'Error! Time Slot is already occupied', 'Result' => null], 422);
            }
            else {
                TimeslotManagement::where('ID', '=', $timeslotID)
                    ->update([
                        "ATTENDEE_MESSAGE" => $message, "STATUS" => $status, "UPDATED_AT" => Carbon::now()
                    ]);

                return response()->json(['statusCode' => '1', 'statusMessage' => 'Response Saved', 'Result' => NULL]);
            }
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * This function fetch request from attendees in meeting
     */
    public function fetchMeetingConfirmed(Request $request){
        //Validating the request
        $validator = Validator::make($request->all(), [
            'attendee_id' => 'required|numeric',
        ], [
            'attendee_id.required' => 'Attendee ID is required',
        ]);


        if ($validator->fails()) {
            //Getting error messages and sending them in response
            $errorMsg = $validator->messages();
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Error! Parameters Missing', 'Result' => $errorMsg], 400);
        } else {
            $attendeeID = $request->input('attendee_id');
            $result = TimeslotManagement::join('session_timeslots', 'session_timeslots.ID', '=', 'timeslot_management.SESSION_TIMESLOT_ID')
                ->join('users', 'users.id', '=', 'timeslot_management.SPONSOR_ID')
                ->select('timeslot_management.ID','name as NAME','Surname as SURNAME','profileImage as PROFILE_IMAGE', 'TIME_FROM', 'TIME_TO','ATTENDEE_MESSAGE', 'SPONSOR_MESSAGE')
                ->where('ATTENDEE_ID', '=', $attendeeID)
                ->where('GENERATED_BY', 1)
                ->where('STATUS', '=', 'Confirmed')
                ->get();

            return response()->json(['statusCode' => '1', 'statusMessage' => 'Meeting Confirmed time slots', 'Result' => $result]);
        }
    }

    public function AvailTimeSlots2(Request $request)
    {

        //Validating the request
        $validator = Validator::make($request->all(), [

            'attendee_id' => 'required|numeric',
            'sponsor_id' => 'required|numeric'
        ], [

            'attendee_id.required' => 'Attendee ID is required',
            'sponsor_id.required' => 'Sponsor ID is required',
        ]);


        if ($validator->fails()) {
            //Getting error messages and sending them in response
            $errorMsg = $validator->messages();
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Error! Parameters Missing', 'Result' => $errorMsg], 400);
        } else {
            $attendeeID = $request->input('attendee_id');
            $sponsorID = $request->input('sponsor_id');

            $occupiedSlotsSponsor = TimeslotManagement::join('session_timeslots', 'session_timeslots.ID', '=', 'timeslot_management.SESSION_TIMESLOT_ID')
                ->select('SESSION_TIMESLOT_ID')
                ->where('SPONSOR_ID', $sponsorID)
                ->where('STATUS', 'Confirmed')
                ->get();

            $occupiedSlotsAttendee = TimeslotManagement::join('session_timeslots', 'session_timeslots.ID', '=', 'timeslot_management.SESSION_TIMESLOT_ID')
                ->select('SESSION_TIMESLOT_ID')
                ->where('ATTENDEE_ID', $attendeeID)
                ->where('STATUS', 'Confirmed')
                ->get();

            $availableTimeSlots = SessionTimeslots::join('sessions', 'sessions.id','=','session_timeslots.SESSION_ID')
                ->selectRaw("ID,TIME_FROM,TIME_TO,DATE_FORMAT(eventDate, '%M %e, %Y') as EVENT_DATE")
                ->whereNotIn("ID", $occupiedSlotsSponsor)
                ->whereNotIn("ID", $occupiedSlotsAttendee)
                ->get();

            return response()->json(['statusCode' => '1', 'statusMessage' => 'Available time slots', 'Result' => $availableTimeSlots]);
        }
    }


}