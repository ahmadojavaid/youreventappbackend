<?php
/**
 * Created by PhpStorm.
 * User: JBBravo
 * Date: 12-Jun-19
 * Time: 11:43 AM
 */

namespace App\Http\Controllers\Meeting;


use App\Http\Controllers\Controller;
use App\Http\Models\TimeslotManagement;
use App\Sessions;
use App\Http\Models\SessionTimeslots;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SponsorTimeSlotController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * This function returns available slots for Sponsor
     */
    public function SponsorAvailTimeSlots(Request $request)
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

            $occupiedSlotsAttendee = TimeslotManagement::join('session_timeslots', 'session_timeslots.ID', '=', 'timeslot_management.SESSION_TIMESLOT_ID')
                ->select('SESSION_TIMESLOT_ID')
                ->where('ATTENDEE_ID', $attendeeID)
                ->where('STATUS', 'Confirmed')
                ->get();

            $occupiedSlotsSponsor = TimeslotManagement::join('session_timeslots', 'session_timeslots.ID', '=', 'timeslot_management.SESSION_TIMESLOT_ID')
                ->select('SESSION_TIMESLOT_ID')
                ->where('SPONSOR_ID', $sponsorID)
                ->where('STATUS', 'Confirmed')
                ->get();

            $availableTimeSlots = SessionTimeslots::select('ID', 'TIME_FROM', 'TIME_TO')
                ->whereNotIn("ID", $occupiedSlotsSponsor)
                ->whereNotIn("ID", $occupiedSlotsAttendee)
                ->get();
            $eventDate = Sessions::selectRaw("DATE_FORMAT(eventDate, '%M %e, %Y') as DATE")->first();

            return response()->json(['statusCode' => '1', 'statusMessage' => 'available time slots', 'Result' => $availableTimeSlots, 'eventDate' => $eventDate]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sponsorNotConfirmedTS(Request $request){

        //Validating the request
        $validator = Validator::make($request->all(),[

            'sponsor_id' => 'required|numeric',
            'attendee_id' => 'required|numeric',
        ], [

            'sponsor_id.required' => 'Sponsor ID is required',
            'attendee_id.required' => 'Attendee ID is required',
        ] );


        if ($validator->fails())
        {
            //Getting error messages and sending them in response
            $errorMsg = $validator->messages();
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Error! Parameters Missing','Result' => $errorMsg],400);
        }
        else
        {
            $sponsorID = $request->input('sponsor_id');
            $attendeeID = $request->input('attendee_id');
            $result = TimeslotManagement::join('session_timeslots', 'session_timeslots.ID','=','timeslot_management.SESSION_TIMESLOT_ID')
                ->select('timeslot_management.ID','TIME_FROM','TIME_TO','ATTENDEE_MESSAGE','SPONSOR_MESSAGE','STATUS')
                ->where('SPONSOR_ID','=',$sponsorID)
                ->where('ATTENDEE_ID','=',$attendeeID)
                ->where('GENERATED_BY',1)
                ->where('STATUS','!=','Confirmed')
                ->get();

            return response()->json(['statusCode' => '1', 'statusMessage' => 'Not Confirmed/Cancelled time slots', 'Result' => $result]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sponsorConfirmedTS(Request $request){

        $validator = Validator::make($request->all(), [

            'attendee_id' => 'required|numeric',
            'sponsor_id' => 'required|numeric'
        ], [

            'attendee_id.required' => 'Attendee ID is required',
            'sponsor_id.required' => 'Sponsor ID is required',
        ]);


        if ($validator->fails())
        {
            //Getting error messages and sending them in response
            $errorMsg = $validator->messages();
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Error! Parameters Missing','Result' => $errorMsg],400);
        }
        else
        {
            $attendeeID = $request->input('attendee_id');
            $sponsorID = $request->input('sponsor_id');
            $result = TimeslotManagement::join('session_timeslots', 'session_timeslots.ID','=','timeslot_management.SESSION_TIMESLOT_ID')
                ->select('timeslot_management.ID','TIME_FROM','TIME_TO','ATTENDEE_MESSAGE','SPONSOR_MESSAGE','STATUS')
                ->where('SPONSOR_ID','=',$sponsorID)
                ->where('ATTENDEE_ID','=',$attendeeID)
                ->where('GENERATED_BY',1)
                ->where('STATUS','Confirmed')
                ->get();

            return response()->json(['statusCode' => '1', 'statusMessage' => 'Confirmed time slots', 'Result' => $result]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sponsorRequestTS(Request $request){

        $validator = Validator::make($request->all(),[

            'timeslot_id' => 'required|numeric',
            'attendee_id' => 'required|numeric',
            'sponsor_id' => 'required|numeric',
            'message' => 'max:300',
        ], [

            'timeslot_id.required' => 'Time Slot ID is required',
            'attendee_id.required' => 'Attendee ID is required',
            'sponsor_id.required' => 'Sponsor ID is required',
            'message.max' => 'Maximum String Length Exceeded',
        ] );

        if ($validator->fails())
        {
            //Getting error messages and sending them in response
            $errorMsg = $validator->messages();
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Error! Parameters Missing','Result' => $errorMsg],400);
        }
        else
        {
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
                $timeslotRequest->GENERATED_BY = 1;
                $timeslotRequest->SPONSOR_MESSAGE = $message;
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
    public function SponsorCancelledTS(Request $request){
        //Validating the request
        $validator = Validator::make($request->all(),[

            'sponsor_id' => 'required|numeric',
        ], [

            'sponsor_id.required' => 'Sponsor ID is required',
        ] );


        if ($validator->fails())
        {
            //Getting error messages and sending them in response
            $errorMsg = $validator->messages();
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Error! Parameters Missing','Result' => $errorMsg],400);
        }
        else
        {
            $attendeeID = $request->input('sponsor_id');
            $result = TimeslotManagement::join('session_timeslots', 'session_timeslots.ID','=','timeslot_management.SESSION_TIMESLOT_ID')
                ->join('users', 'users.id', '=', 'timeslot_management.ATTENDEE_ID')
                ->select('timeslot_management.ID','name as NAME','Surname as SURNAME','profileImage as PROFILE_IMAGE','TIME_FROM','TIME_TO','ATTENDEE_MESSAGE', 'SPONSOR_MESSAGE')
                ->where('SPONSOR_ID','=',$attendeeID)
                ->where('GENERATED_BY',2)
                ->where('STATUS','=','Cancelled')
                ->get();

            return response()->json(['statusCode' => '1', 'statusMessage' => 'Cancelled time slots', 'Result' => $result]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchSponsorRequests(Request $request){
        $validator = Validator::make($request->all(),[

            'sponsor_id' => 'required|numeric',
        ], [

            'sponsor_id.required' => 'Sponsor ID is required',
        ]);

        if ($validator->fails())
        {
            //Getting error messages and sending them in response
            $errorMsg = $validator->messages();
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Error! Parameters Missing','Result' => $errorMsg],400);
        }
        else
        {
            $sponsorID = $request->input('sponsor_id');

            $result = TimeslotManagement::join('session_timeslots', 'session_timeslots.ID','=','timeslot_management.SESSION_TIMESLOT_ID')
                ->join('users', 'users.id', '=', 'timeslot_management.ATTENDEE_ID')
                ->select('timeslot_management.ID','ATTENDEE_ID', 'name as NAME','Surname as SURNAME','profileImage as PROFILE_IMAGE', 'TIME_FROM', 'TIME_TO', 'ATTENDEE_MESSAGE')
                ->where('SPONSOR_ID','=',$sponsorID)
                ->where('GENERATED_BY',2)
                ->where('STATUS','=','Not Confirmed')
                ->get();
            $eventDate = Sessions::selectRaw("DATE_FORMAT(eventDate, '%M %e, %Y') as DATE")->first();
            return response()->json(['statusCode' => '1', 'statusMessage' => 'List of Requests Received', 'Result' => $result, 'eventDate' => $eventDate]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function SponsorRequestResponse(Request $request)
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
                        "SPONSOR_MESSAGE" => $message, "STATUS" => $status, "UPDATED_AT" => Carbon::now()
                    ]);

                return response()->json(['statusCode' => '1', 'statusMessage' => 'Response Saved', 'Result' => NULL]);
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchMeetingConfirmed(Request $request){
        //Validating the request
        $validator = Validator::make($request->all(),[

            'sponsor_id' => 'required|numeric',
        ], [

            'sponsor_id.required' => 'Sponsor ID is required',
        ] );


        if ($validator->fails())
        {
            //Getting error messages and sending them in response
            $errorMsg = $validator->messages();
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Error! Parameters Missing','Result' => $errorMsg],400);
        }
        else
        {
            $sponsorID = $request->input('sponsor_id');
            $result = TimeslotManagement::join('session_timeslots', 'session_timeslots.ID','=','timeslot_management.SESSION_TIMESLOT_ID')
                ->join('users', 'users.id', '=', 'timeslot_management.ATTENDEE_ID')
                ->select('timeslot_management.ID','name as NAME','Surname as SURNAME','profileImage as PROFILE_IMAGE','TIME_FROM','TIME_TO','ATTENDEE_MESSAGE', 'SPONSOR_MESSAGE')
                ->where('SPONSOR_ID','=',$sponsorID)
                ->where('GENERATED_BY',2)
                ->where('STATUS','=','Confirmed')
                ->get();

            return response()->json(['statusCode' => '1', 'statusMessage' => 'Meeting Confirmed time slots', 'Result' => $result]);
        }
    }
}