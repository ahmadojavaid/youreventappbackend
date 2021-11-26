<?php

namespace App\Http\Controllers;

use App\Http\Middleware\PreflightResponse;
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
use App\Sponsors;
use Illuminate\Support\Facades\Mail;
use DB;

class sponsorsController extends Controller
{

    //   public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    public function getSponsor($id)
    {
        $Messages = Sponsors::join('users','users.id','=','sponsors.user_id')
            ->select('sponsors.*','users.email')
            ->where('user_id',$id)
            ->first();

        return response()->json(['statusCode' => '1', 'statusMessage' => 'showing Sponsors', 'Result' => $Messages]);
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

    public function sponsorImport(Request $request)
    {
        if ($request->has('file')) {

            $extension = $request->file('file')->getClientOriginalExtension();

            $photo = time() . '-' . $request->file('file')->getClientOriginalName();

            $destination = 'api/public/uploads/';

            $path = $request->file('file')->move($destination, $photo);
            $customerArr = $this->csvToArray($path);

            $getLogo = DB::table('colorschemes')
                ->pluck('appLogo')
                ->first();

            $getLogo = "http://yea.jobesk.com/backend/public/" . $getLogo;

            $date = [];

            // new User will be following all the previous users

            for ($i = 0; $i < count($customerArr); $i++) {
                // return Hash::make($customerArr[$i]['password']);
                $userID = User::insertGetId([
                    "name" => $customerArr[$i]['sponsorName'],
                    "email" => $customerArr[$i]['email'],
                    "password" => Hash::make($customerArr[$i]['password']),
                    "role" => 1,
                    "created_at" => Carbon::now()
                ]);
                $data[] = [
                    'user_id' => $userID,
                    'sponsorName' => $customerArr[$i]['sponsorName'],
                    'sponsorDescription' => $customerArr[$i]['sponsorDescription'],
                    'sponsorTitle' => $customerArr[$i]['sponsorTitle'],
                    'sponsorshipLevel' => $customerArr[$i]['sponsorshipLevel'],
                    'sponsorwebLink' => $customerArr[$i]['sponsorwebLink'],
                    'instaLink' => $customerArr[$i]['instaLink'],
                    'fbLink' => $customerArr[$i]['fbLink'],
                    'linkedInLink' => $customerArr[$i]['linkedInLink'],
                    'twitterLink' => $customerArr[$i]['twitterLink'],
                    'created_at' => Carbon::now()
                ];

                Mail::send('email.sponsor-email', ["data1" => $customerArr, "logo" => $getLogo], function ($message) use ($customerArr, $i) {

                    $message->from('info@yea.com', 'EventApp');

                    $bodystring = " Hello : " . $customerArr[$i]['sponsorName'] . " \n Your Email is : " . $customerArr[$i]['email'] . " \n Your Password is  : " . $customerArr[$i]['password'];

                    $message->to($customerArr[$i]['email'], 'Mail Confirmation')->subject('Welcome');
                    $message->setBody($bodystring);
                });

                DB::table('sponsors')->insert($data[$i]);

            }

            return response()->json(['statusCode' => '1', 'statusMessage' => 'File uploaded', 'Result' => NULL]);

        }
        else{
            return response()->json(['statusCode' => '0', 'statusMessage' => 'File Not Found', 'Result' => NULL]);
        }

    }

    public function show()
    {
        // $Messages=Sponsors::sortBy('sponsorName', 'ASC');

        $sponsors = DB::table('sponsors')
            ->orderByRaw("FIELD(sponsorshipLevel , 'Main Sponsor', 'Stream Sponsor', 'Panel Sponsor', 'Workshop sponsor',
            'Dinner sponsor','Drinks sponsor', 'Innovation Stage', 'Exhibitor', 'Supporter', 'Media partner') ASC")
            ->get();

        return response()->json(['statusCode' => '1', 'statusMessage' => 'showing all Sponsors', 'Result' => $sponsors]);
    }

    public function store(Request $request)
    {
        // return $request;
        // $Activities = Sponsors::create($request->all());
        $Activities = new Sponsors();

        $userID = User::insertGetId([
            "name" => $request->input('sponsorName'),
            "email" => $request->input('sponsorEmail'),
            "password" => Hash::make($request->input('sponsorPassword')),
            "role" => 1,
            "created_at" => Carbon::now()
        ]);

        $name = $request->input('sponsorName');
        $email = $request->input('sponsorEmail');
        $password = $request->input('sponsorPassword');

        if ($request->has('sponsorImage')) {

            $unique = bin2hex(openssl_random_pseudo_bytes(10));

            $format = '.png';

            $entityBody = $request['sponsorImage'];// file_get_contents('php://input');



            $Activities = Sponsors::create($request->except(['sponsorImage']));

            Sponsors::where('id',$Activities->id)
                ->update([
                    "user_id" => $userID
                ]);
            $imageName = $Activities->id . $unique . $format;
            // return $entityBody;
            $directory = "/images/Sponsors/";

            $path = base_path() . "/public" . $directory;

            $data = base64_decode($entityBody);

            file_put_contents($path . $imageName, $data);

            $response = $directory . $imageName;

            $Activities->sponsorImage = $response;

            $Activities->save();


            Mail::send([],[], function ($message) use ($name, $email,$password) {

                $message->from('info@yea.com', 'EventApp');

                $bodystring = "\n\n Hello : " . $name . " \n Your Email is : " . $email . " \n Your Password is  : " . $password;

                $message->to($email, 'Mail Confirmation')->subject('Welcome');
                $message->setBody($bodystring);
            });
        } else {
            $Activities = $Activities->create($request->except(['sponsorImage']));

            Sponsors::where('id',$Activities->id)
                ->update([
                    "user_id" => $userID
                ]);

            Mail::send([],[], function ($message) use ($name, $email,$password) {

                $message->from('info@yea.com', 'EventApp');

                $bodystring = "\n\n Hello : " . $name . " \n Your Email is : " . $email . " \n Your Password is  : " . $password;

                $message->to($email, 'Mail Confirmation')->subject('Welcome');
                $message->setBody($bodystring);
            });
            return response()->json(['statusCode' => '1', 'statusMessage' => 'Speakers Data is Created', 'Result' => $Activities]);
        }

        return response()->json(['statusCode' => '1', 'statusMessage' => 'Sponsors Created', 'Result' => $Activities]);
    }

    public function getSchedules()
    {
        return ScheduleTiming::where('status', 2)->select('from', 'to')->get();
    }

    public function setAvailabilityStatus(Request $request)
    {
        try {
            $data = ScheduleTiming::where('from', $request->from)
                ->where('to', $request->to)
                ->where('user_id', $request->user_id)
                ->where('hiring_id', $request->hiring_id)
                ->update(
                    [
                        'status' => 1,
                        'message' => $request->message
                    ]);
            if ($data == 1) {
                return response()->json(['Message' => 'status Updated successfully', 'statusCode' => 1]);
            }
        } catch (\Exception $exception) {
            return response()->json(['Message' => 'Error Occured', 'statusCode' => 0]);
        }
    }

    public function getConfirmedAttendee(Request $request)
    {
        try {
            $data = ScheduleTiming::where('user_id', $request->user_id)->where('status', 1)->get();
            return response()->json(['Message' => 'Data', 'result' => $data, 'statusCode' => 1]);
        } catch (\Exception $exception) {
            return response()->json(['Message' => 'Error Occured', 'statusCode' => 0]);
        }
    }

    public function getUnConfirmedAttendee(Request $request)
    {
        try {
            $data = ScheduleTiming::where('user_id', $request->user_id)->where('status', 0)->get();
            return response()->json(['Message' => 'Data', 'result' => $data, 'statusCode' => 1]);
        } catch (\Exception $exception) {
            return response()->json(['Message' => 'Error Occured', 'statusCode' => 0]);
        }
    }

    public function update($id, Request $request)
    {
       /* $interval = 1800; // Interval in seconds
        $timeSlots = array();
        $date_first = "07:00";
        $date_second = "11:30";

        $time_first = strtotime($date_first);
        $time_second = strtotime($date_second);

        for ($i = $time_first; $i < $time_second; $i += $interval)
        {
            echo date('H:i', $i) . "<br />";
        }

        exit();

        //testing
        $currentTime = "01:00";
        $endTime = "03:00";
        $from = Carbon::createFromFormat('H:s', $currentTime);
        $to = Carbon::createFromFormat('H:s', $endTime);
        $startingTime = $currentTime;
        $endingTime = $endTime;
        $total = $to->diffInHours($from);
        $timefrom = array();
        $timeto = array();
        for ($i = 0; $i <= $total; $i++) {
            $currentTime = date("H:i", strtotime($currentTime));
            array_push($timefrom, $currentTime);
            $currentTime = date("H:i", strtotime($currentTime . " +60 MINUTE"));
        }
        $currentTime = strtotime($startingTime . "+30 MINUTE");
        $currentTime = date('H:i', $currentTime);
        for ($i = 0; $i < $total - 1; $i++) {
            array_push($timeto, $currentTime);
            $currentTime = date("H:i", strtotime($currentTime . " +60 MINUTE"));
            array_push($timeto, $currentTime);
        }
        $users = User::all();
        foreach ($users as $user) {
            foreach ($timefrom as $index => $value) {
                $model = new ScheduleTiming();
                $model->session_id = 1;
                $model->user_id = $user->id;
                $model->from = $value;
                $model->to = isset($timeto[$index]) ? $timeto[$index] : null;
                $model->status = 0;
                $model->save();
            }
        }
        exit();*/

//endtesting
        $Activities = Sponsors::where('user_id','=',$id)->first();

        if (!$Activities) {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Record Not Found', 'Result' => NULL]);
        }

        if ($request->has('sponsorImage')) {
            /*$Activities->update($request->except(['sponsorImage']));*/

            $unique = bin2hex(openssl_random_pseudo_bytes(10));

            $format = '.png';

            $entityBody = $request['sponsorImage'];// file_get_contents('php://input');

            $imageName = $Activities->id . $unique . $format;

            $directory = "/images/Sponsors/";

            $path = base_path() . "/public" . $directory;

            $data = base64_decode($entityBody);

            file_put_contents($path . $imageName, $data);

            $response = $directory . $imageName;

            $Activities->sponsorImage = $response;
            $Activities->sponsorName = $request->get('sponsorName');
            $Activities->sponsorDescription = $request->get('sponsorDescription');
            $Activities->sponsorTitle = $request->get('sponsorTitle');
            $Activities->sponsorshipLevel = $request->get('sponsorshipLevel');
            $Activities->sponsorwebLink = $request->get('sponsorwebLink');
            $Activities->instaLink = $request->get('instaLink');
            $Activities->fbLink = $request->get('fbLink');
            $Activities->linkedInLink = $request->get('linkedInLink');
            $Activities->twitterLink = $request->get('twitterLink');
            $Activities->save();

            return response()->json(['statusCode' => '1', 'statusMessage' => 'Sponsors Data is Updated', 'Result' => $Activities]);

        } else {
            /*DB::table('users')->where('id', $id)->update($request->except(['sponsorImage','sponsorName','sponsorTitle','sponsorshipLevel',
                'fbLink','instaLink','linkedInLink','sponsorDescription','']));*/
            /*$Activities->update($request->except(['sponsorImage']));*/
            $Activities->sponsorName = $request->get('sponsorName');
            $Activities->sponsorDescription = $request->get('sponsorDescription');
            $Activities->sponsorTitle = $request->get('sponsorTitle');
            $Activities->sponsorshipLevel = $request->get('sponsorshipLevel');
            $Activities->sponsorwebLink = $request->get('sponsorwebLink');
            $Activities->instaLink = $request->get('instaLink');
            $Activities->fbLink = $request->get('fbLink');
            $Activities->linkedInLink = $request->get('linkedInLink');
            $Activities->twitterLink = $request->get('twitterLink');
            $Activities->save();

            return response()->json(['statusCode' => '1', 'statusMessage' => 'Sponsors Data is Updated', 'Result' => $Activities]);
        }

    }

    public function destroy($id, Request $request)
    {

        $Category = Sponsors::where('user_id','=',$id)->first();

        if (!$Category) {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Record Not Found', 'Result' => NULL]);
        }
        $Category->delete();

        return response()->json(['statusCode' => '1', 'statusMessage' => 'Sponsors deleted', 'Result' => NULL]);
    }


    public function searchsponsor(Request $request)
    {
        $sponsorName = $request->input('sponsorName');

        $sponsorName = \DB::table('sponsors')
            ->Where('sponsorName', 'LIKE', '%' . $sponsorName . '%')
            ->orderByRaw("FIELD(sponsorshipLevel , 'Main Sponsor', 'Stream Sponsor', 'Panel Sponsor', 'Workshop sponsor',
            'Dinner sponsor','Drinks sponsor', 'Innovation Stage', 'Exhibitor', 'Supporter', 'Media partner') ASC")
            ->get();

        return response()->json(['statusCode' => '1', 'statusMessage' => 'showing searched sponsor', 'Result' => $sponsorName]);

    }


}