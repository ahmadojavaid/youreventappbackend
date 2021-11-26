<?php

namespace App\Http\Controllers;

use App\Http\Models\SessionTimeslots;
use App\ScheduleTiming;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\CustomData\Utilclass;
use Illuminate\Support\Facades\Hash;
use App\Activities;
use App\Blog;
use App\Speakers;
use App\Sessions;
use App\SpeakerSessions;
use App\SpeakerDocuments;
use Illuminate\Support\Facades\Mail;
use DB;

class agendaController extends Controller
{

    //   public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }


    public function getSession()
    {
        $Sessions = new Sessions();

        $Sessionsz = $Sessions->Sessions();

        return response()->json(['statusCode' => '1', 'statusMessage' => 'showing Sessions', 'Result' => $Sessionsz]);

    }

    public function getSingleSession($id)
    {
        // $Messages=Speakers::find($id);

        $Sessions = new Sessions();

        $Speakerss = $Sessions->singleSessions($id);

        return response()->json(['statusCode' => '1', 'statusMessage' => 'showing single session', 'Result' => $Speakerss]);
    }

    public function show()
    {
        $Messages = Speakers::all();

        return response()->json(['statusCode' => '1', 'statusMessage' => 'showing all Speakers', 'Result' => $Messages]);
    }

    public function store(Request $request)
    {
        // return $request;
        // $Activities = Speakers::create($request->all());

        if ($request->has('speakerProfileImage')) {

            $unique = bin2hex(openssl_random_pseudo_bytes(10));

            $format = '.png';

            $entityBody = $request['speakerProfileImage'];// file_get_contents('php://input');

            $Activities = Speakers::create($request->except(['speakerProfileImage']));

            $imageName = $Activities->id . $unique . $format;
            // return $entityBody;
            $directory = "/images/speakerImages/";

            $path = base_path() . "/public" . $directory;

            $data = base64_decode($entityBody);

            file_put_contents($path . $imageName, $data);

            $response = $directory . $imageName;

            $Activities->speakerProfileImage = $response;

            $Activities->save();
        }

        return response()->json(['statusCode' => '1', 'statusMessage' => 'Speakers Created', 'Result' => $Activities]);
    }


    public function update($id, Request $request)
    {
        $Activities = Speakers::find($id);

        if (!$Activities) {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Record Not Found', 'Result' => NULL]);
        }

        if ($request->has('speakerProfileImage')) {
            $Activities->update($request->except(['speakerProfileImage']));

            $unique = bin2hex(openssl_random_pseudo_bytes(10));

            $format = '.png';

            $entityBody = $request['speakerProfileImage'];// file_get_contents('php://input');

            $imageName = $Activities->id . $unique . $format;

            $directory = "/images/speakerImages/";

            $path = base_path() . "/public" . $directory;

            $data = base64_decode($entityBody);

            file_put_contents($path . $imageName, $data);

            $response = $directory . $imageName;

            $Activities->speakerProfileImage = $response;

            DB::table('speakers')->where('id', $id)->update(array('speakerProfileImage' => $response));

            return response()->json(['statusCode' => '1', 'statusMessage' => 'Speakers Data is Updated', 'Result' => $Activities]);

        } else {
            $Activities->update($request->except(['speakerProfileImage']));

            return response()->json(['statusCode' => '1', 'statusMessage' => 'Speakers Data is Updated', 'Result' => $Activities]);
        }

    }

    public function destroy($id, Request $request)
    {
        $Category = Speakers::find($id);

        if (!$Category) {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Record Not Found', 'Result' => NULL]);
        }
        $Category->delete();
        return response()->json(['statusCode' => '1', 'statusMessage' => 'Speakers deleted', 'Result' => NULL]);
    }


    // ...............................................Add Session Functionality


    public function addSession(Request $request)
    {

        $Sessions = new Sessions();
        $userId = Input::get("userId");
        $can_notify = Input::get("can_notify");


        // return json_encode($request['files'][0]['documentName']);//['eventDate'];
        // $Activities = Sessions::create($request->except(['speakerProfileImage']));
        // return $request->data;

        if (!empty($request->data['text_wall'])) {
            $temp = array("eventDate" => $request->data['eventDate'], "sessionName" => $request->data['sessionName'], "sessionVenue" => $request->data['sessionVenue'], "date" => $request->data['date'], "timeFrom" => $request->data['timeFrom'], "timeTo" => $request->data['timeTo'], "sessionDescription" => $request->data['sessionDescription'], "text_wall" => $request->data['text_wall']);
            $sessionId = DB::table('sessions')->insertGetId($temp);
        }
        else {
            $temp = array("eventDate" => $request->data['eventDate'], "sessionName" => $request->data['sessionName'], "sessionVenue" => $request->data['sessionVenue'], "date" => $request->data['date'], "timeFrom" => $request->data['timeFrom'], "timeTo" => $request->data['timeTo'], "sessionDescription" => $request->data['sessionDescription']);
            $sessionId = DB::table('sessions')->insertGetId($temp);
        }

        $temp = array("eventDate" => $request->data['eventDate'], "sessionName" => $request->data['sessionName'], "sessionVenue" => $request->data['sessionVenue'], "date" => $request->data['date'], "timeFrom" => $request->data['timeFrom'], "timeTo" => $request->data['timeTo'], "sessionDescription" => $request->data['sessionDescription']);

        //Creating Session Timeslots

        $currentTime = $request->data['timeFrom'];
        $endTime = $request->data['timeTo'];

        $array = array();
        for($i = strtotime($currentTime); $i <= strtotime($endTime); $i += 1800) {
            $array [] = date('h:i A', $i);
        }

        for($i = 1; $i < count($array); $i++){
            if(!empty($array[$i+1])){
                SessionTimeslots::insert([
                    "SESSION_ID" => $sessionId, "TIME_FROM" => $array[$i], "TIME_TO" => $array[$i+1]
                ]);
            }
        }

        $temp = array("userId" => $userId, "postId" => $sessionId, "notificationTitle" => 'Agenda Update', "notificationType" => '1', "notificationData" => 'Announcements/notifications from the organisers, Please check the latest Agenda Update');

        $lists = DB::table('notifications')->insertGetId($temp);

        for ($i = 0; $i < count($request->sponsor); $i++) {

            $temp = array("sponsorId" => $request->sponsor[$i], "sessionId" => $sessionId);

            $lists = DB::table('session_sponsors')->insertGetId($temp);

        }

        for ($i = 0; $i < count($request->speaker); $i++) {

            $temp = array("speakerId" => $request->speaker[$i], "sessionId" => $sessionId);

            $lists = DB::table('session_speakers')->insertGetId($temp);
        }

        // return json_encode(count($request['files']));
        for ($i = 0; $i < count($request['files']); $i++) {

            // return $request['files'][0]['documentName'];
            // if (!(empty($request['files'][$i]['DocattachementURl']))) {

            $Activities = new SpeakerDocuments();

            $Activities = SpeakerDocuments::create($request->except(['DocattachementURl', 'sessionId']));

            $unique = bin2hex(openssl_random_pseudo_bytes(10));
            $format = '.pdf';
            $entityBody = $request['files'][$i]['DocattachementURl'];
            $imageName = $unique . $format;
            $directory = "/images/sessionDocuments/";
            $path = base_path() . "/public" . $directory;
            $data = base64_decode($entityBody);
            file_put_contents($path . $imageName, $data);
            $response = $directory . $imageName;
            $Activities->DocattachementURl = $response;
            $Activities->sessionId = $sessionId;
            $Activities->documentName = $request['files'][$i]['documentName'];
            $Activities->save();
            // }

        }
        //if Admin wants to notify the users

        if ($request->can_notify == '1') {

            // get the ids of all the users

            $userId = DB::table('users')
                // ->where('userId',$userId)
                ->where('users.role', '=', 2)
                ->pluck('id');

            for ($i = 0; $i < count($userId); $i++) {

                $checkDeviceType = DB::table('users')
                    ->where('id', $userId[$i])
                    ->where('users.role', '=', 2)
                    ->pluck('deviceType')->first();

                $util = new Utilclass();
                $title = 'YEA';

                $body = 'Agenda Update';
                $userID = $userId[$i];

                if ($checkDeviceType == 1) {
                    // return 'ios';
                    $util->sendPushNotification($userID, $title, $body);
                }

                if ($checkDeviceType == 2) {
                    // return 'android';
                    $util->sendPushNotificationAdnroid($userID, $title, $body);
                }
            }

        }
        return response()->json(['statusCode' => '1', 'statusMessage' => 'Sessions Created', 'Result' => NULL]);
    }

    public function editSession($id, Request $request)
    {
        // $Sessions = new Sessions();
        $userId = Input::get("userId");
        $Sessions = Sessions::find($id);
        $can_notify = Input::get("can_notify");

        // $temp = array("eventDate" =>$request->data['eventDate'],"sessionName" =>$request->data['sessionName'], "sessionVenue" =>$request->data['sessionVenue'], "date" =>$request->data['date'], "timeFrom" =>$request->data['timeFrom'], "timeTo" =>$request->data['timeTo']  , "sessionDescription" =>$request->data['sessionDescription'] );

        if (!empty($request->data['text_wall'])) {

            if ($request->data['eventDate'] != NULL) {
                $Sessions->eventDate = $request->data['eventDate'];
            }
            if ($request->data['sessionName'] != NULL) {
                $Sessions->sessionName = $request->data['sessionName'];
            }
            if ($request->data['sessionVenue'] != NULL) {
                $Sessions->sessionVenue = $request->data['sessionVenue'];
            }
            if ($request->data['date'] != NULL) {
                $Sessions->date = $request->data['date'];
            }
            if ($request->data['timeFrom'] != NULL) {
                $Sessions->timeFrom = $request->data['timeFrom'];
            }
            if ($request->data['timeTo'] != NULL) {
                $Sessions->timeTo = $request->data['timeTo'];
            }
            if ($request->data['sessionDescription'] != NULL) {
                $Sessions->sessionDescription = $request->data['sessionDescription'];
            }
            if ($request->data['text_wall'] != NULL) {
                $Sessions->text_wall = $request->data['text_wall'];
            }
        } else {

            if ($request->data['eventDate'] != NULL) {
                $Sessions->eventDate = $request->data['eventDate'];
            }
            if ($request->data['sessionName'] != NULL) {
                $Sessions->sessionName = $request->data['sessionName'];
            }
            if ($request->data['sessionVenue'] != NULL) {
                $Sessions->sessionVenue = $request->data['sessionVenue'];
            }
            if ($request->data['date'] != NULL) {
                $Sessions->date = $request->data['date'];
            }
            if ($request->data['timeFrom'] != NULL) {
                $Sessions->timeFrom = $request->data['timeFrom'];
            }
            if ($request->data['timeTo'] != NULL) {
                $Sessions->timeTo = $request->data['timeTo'];
            }
            if ($request->data['sessionDescription'] != NULL) {
                $Sessions->sessionDescription = $request->data['sessionDescription'];
            }

        }

        $Sessions->save();

        DB::table('session_sponsors')->where('sessionId', $id)->delete();
        DB::table('session_speakers')->where('sessionId', $id)->delete();
        // $abc = $Sessions->update($request->all());

        $temp = array("userId" => $userId, "notificationTitle" => 'Agenda Update', "notificationType" => '1', "notificationData" => 'Announcements/notifications from the organisers, Please check the latest Agenda Update');

        $lists = DB::table('notifications')->insertGetId($temp);

        for ($i = 0; $i < count($request->sponsor); $i++) {

            $temp = array("sponsorId" => $request->sponsor[$i], "sessionId" => $Sessions->id);

            $lists = DB::table('session_sponsors')->insertGetId($temp);

        }

        for ($i = 0; $i < count($request->speaker); $i++) {

            $temp = array("speakerId" => $request->speaker[$i], "sessionId" => $Sessions->id);

            $lists = DB::table('session_speakers')->insertGetId($temp);
        }

        //....if Admin wants to notify the users

        if ($request->can_notify == '1') {

            // get the ids of all the users

            $userId = DB::table('users')
                // ->where('userId',$userId)
                ->where('users.role', '=', 2)
                ->pluck('id');
            // return $userId;

            for ($i = 0; $i < count($userId); $i++) {

                $checkDeviceType = DB::table('users')
                    ->where('id', $userId[$i])
                    ->where('users.role', '=', 2)
                    ->pluck('deviceType')->first();

                $util = new Utilclass();
                $title = 'YEA';

                $body = 'Agenda Update';
                $userID = $userId[$i];

                if ($checkDeviceType == 1) {
                    // return 'ios';
                    $util->sendPushNotification($userID, $title, $body);
                }

                if ($checkDeviceType == 2) {
                    // return 'android';

                    $util->sendPushNotificationAdnroid($userID, $title, $body);
                }

                // $util->sendPushNotification($userID,$title,$body);
                // $util->sendPushNotificationAdnroid($userID,$title,$body);


            }
        }

        return response()->json(['statusCode' => '1', 'statusMessage' => 'Sessions Edited', 'Result' => $Sessions]);
    }

    public function destroysessionData($id, Request $request)
    {
        $Category = Sessions::find($id);

        if (!$Category) {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Record Not Found', 'Result' => NULL]);
        }
        $Category->delete();

        DB::table('session_sponsors')->where('sessionId', $id)->delete();
        DB::table('session_speakers')->where('sessionId', $id)->delete();
        DB::table('speaker_documents')->where('sessionId', $id)->delete();

        return response()->json(['statusCode' => '1', 'statusMessage' => 'Speakers session deleted', 'Result' => NULL]);
    }


    // ...............................................Add speakers Session Functionality


    public function storespeakerSession(Request $request)
    {

        $Activities = SpeakerSessions::create($request->all());

        return response()->json(['statusCode' => '1', 'statusMessage' => 'Speakers session Created', 'Result' => $Activities]);
    }

    public function updatespeakerSession($id, Request $request)
    {
        $Activities = SpeakerSessions::find($id);

        if (!$Activities) {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Record Not Found', 'Result' => NULL]);
        }

        $Activities->update($request->all());
        return response()->json(['statusCode' => '1', 'statusMessage' => 'Speakers session Data is Updated', 'Result' => $Activities]);

    }

    public function destroyspeakerSession($id, Request $request)
    {
        $Category = SpeakerSessions::find($id);

        if (!$Category) {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Record Not Found', 'Result' => NULL]);
        }
        $Category->delete();
        return response()->json(['statusCode' => '1', 'statusMessage' => 'Speakers session deleted', 'Result' => NULL]);
    }


    // ...............................................Add speakers Session documents Functionality


    public function addSessionDoc(Request $request)
    {

        $Activities = new SpeakerDocuments();

        if ($request->has('DocattachementURl')) {

            $Activities = SpeakerDocuments::create($request->except(['DocattachementURl']));
            // return $Activities;
            $unique = bin2hex(openssl_random_pseudo_bytes(10));

            $format = '.pdf';

            $entityBody = $request['DocattachementURl'];// file_get_contents('php://input');

            $imageName = $unique . $format;

            $directory = "/images/sessionDocuments/";

            $path = base_path() . "/public" . $directory;

            $data = base64_decode($entityBody);

            file_put_contents($path . $imageName, $data);

            $response = $directory . $imageName;

            $Activities->DocattachementURl = $response;
            $Activities->save();
            return response()->json(['statusCode' => '1', 'statusMessage' => 'session Documents Data is Created', 'Result' => $Activities]);

        } else {
            $Activities->create($request->except(['DocattachementURl']));

            return response()->json(['statusCode' => '1', 'statusMessage' => 'session Documents Data is Created', 'Result' => $Activities]);
        }
    }

    public function destroyspeakerSessiondoc($id, Request $request)
    {
        $Category = Sessionsdocuments::find($id);

        if (!$Category) {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Record Not Found', 'Result' => NULL]);
        }

        $Category->delete();

        return response()->json(['statusCode' => '1', 'statusMessage' => 'Speakers session doc deleted', 'Result' => NULL]);
    }


    public function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

    public function importSessionCSV(Request $request)
    {
        if ($request->has('sessioncsv')) {

            $extension = $request->file('sessioncsv')->getClientOriginalExtension();

            $photo = time() . '-' . $request->file('sessioncsv')->getClientOriginalName();

            $destination = 'api/public/uploads/';

            $path = $request->file('sessioncsv')->move($destination, $photo);


            $customerArr = $this->csvToArray($path);
            // return $customerArr;
            $date = [];
            for ($i = 0; $i < count($customerArr); $i++) {
                $data[] = [
                    'eventDate' => $customerArr[$i]['eventDate'],
                    'sessionName' => $customerArr[$i]['sessionName'],
                    'sessionVenue' => $customerArr[$i]['sessionVenue'],
                    'date' => $customerArr[$i]['date'],
                    'timeFrom' => $customerArr[$i]['timeFrom'],
                    'timeTo' => $customerArr[$i]['timeTo'],
                    'sessionDescription' => $customerArr[$i]['sessionDescription'],
                ];
            }

            DB::table('sessions')->insert($data);

            return response()->json(['statusCode' => '1', 'statusMessage' => 'File uploaded', 'Result' => NULL]);

        }

    }

    public function notifyUsers(Request $request)
    {

        $notificationTitle = Input::get("notificationTitle");
        $userId = Input::get("userId");
        $notificationData = Input::get("notificationData");
        $body = Input::get("body");

        // get the ids of all the users

        $temp = array("notificationTitle" => $notificationTitle, "notificationType" => '5', "notificationData" => $body, "notificationBody" => $notificationData);

        $lists = DB::table('notifications')->insertGetId($temp);

        $userId = DB::table('users')
            // ->where('userId',$userId)
            ->where('users.role', '=', 2)
            ->pluck('id');

        for ($i = 0; $i < count($userId); $i++) {

            $checkDeviceType = DB::table('users')
                ->where('id', $userId[$i])
                ->where('users.role', '=', 2)
                ->pluck('deviceType')->first();

            $util = new Utilclass();
            $title = 'YEA';
            $body = $body;
            $userID = $userId[$i];

            if ($checkDeviceType == 1) {

                $util->sendPushNotification($userID, $title, $body);
            }

            if ($checkDeviceType == 2) {

                $util->sendPushNotificationAdnroid($userID, $title, $body);
            }

            // $util->sendPushNotification($userID,$title,$body);
            // $util->sendPushNotificationAdnroid($userID,$title,$body);


        }

        return response()->json(['statusCode' => '1', 'statusMessage' => 'Notification Sent To All Users', 'Result' => NULL]);


    }

}