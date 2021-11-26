<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\CustomData\Utilclass;
use Illuminate\Support\Facades\Hash;
use App\Activities;
use App\Blog;
use App\Speakers;
use App\SpeakerSessions;
use App\Sessionsdocuments;
use App\SpeakerDocuments;
use Illuminate\Support\Facades\Mail;
use DB;

class speakerController extends Controller
{

    //   public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }


    public function getSpeaker($id)
    {
        // $Messages=Speakers::find($id);

        /*$Speakerss = DB::table('speakers')
            ->join('session_speakers','session_speakers.speakerId','=','speakers.id')
            ->join('sessions','session_speakers.sessionId','=','sessions.id')
            ->where('speakers.id','=',$id)
            ->get();*/
        $data = array();
        $superData = array();
        $Speakers = new Speakers();

        $Speakerss = $Speakers->speaker($id);

        foreach($Speakerss as $item){
            $data[] = collect([
                    "id" => $item->sessionId, "speakerId" => $item->speakerId,
                    "eventDate" => $item->eventDate,"sessionName" => $item->sessionName,
                    "sessionVenue" => $item->sessionVenue,"date" => $item->date,
                    "timeFrom" => $item->timeFrom,"timeTo" => $item->timeTo,
                    "sessionDescription" => $item->sessionDescription,"text_wall" => $item->text_wall,
            ]);
        }

        foreach($Speakerss as $item){
            $superData[] = collect([
                "id" => $item->id, "speakerName" => $item->speakerName,
                "speakerSurname" => $item->speakerSurname, "speakerOccupation" => $item->speakerOccupation,
                "speakerCompanyName" => $item->speakerCompanyName, "speakerDetails" => $item->speakerDetails,
                "speakerProfileImage" => $item->speakerProfileImage,"sessionId" => $item->sessionId,
                "speakerId" => $item->speakerId,"sessions" => $data
            ]);
            break;
        }


        return response()->json(['statusCode' => '1', 'statusMessage' => 'showing Speaker', 'Result' => $superData]);
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
        $Activities = new Speakers();

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
        } else {
            $Activities->create($request->except(['speakerProfileImage']));

            return response()->json(['statusCode' => '1', 'statusMessage' => 'Speakers Data is Created', 'Result' => $Activities]);
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


//......................................................


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


    public function storespeakerSessiondoc(Request $request)
    {
        return $request;

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
            // DB::table('sessionsdocuments')->where('id', $id)->update(array('DocattachementURl' => $response));
            $Activities->save();
            return response()->json(['statusCode' => '1', 'statusMessage' => 'Speakers Data is Updated', 'Result' => $Activities]);
        } else {
            $Activities->update($request->except(['speakerProfileImage']));

            return response()->json(['statusCode' => '1', 'statusMessage' => 'Speakers Data is Updated', 'Result' => $Activities]);
        }
        $Activities = SpeakerDocuments::create($request->all());

        return response()->json(['statusCode' => '1', 'statusMessage' => 'Speakers session doc Created', 'Result' => $Activities]);
    }

    public function destroyspeakerSessiondoc($id, Request $request)
    {
        $Category = SpeakerDocuments::find($id);

        if (!$Category) {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Record Not Found', 'Result' => NULL]);
        }
        $Category->delete();
        return response()->json(['statusCode' => '1', 'statusMessage' => 'Speakers session doc deleted', 'Result' => NULL]);
    }

    public function searchSpeaker(Request $request)
    {

        $speakerName = $request->input('speakerName');

        $speakerName = \DB::table('speakers')
            ->Where('speakerName', 'LIKE', '%' . $speakerName . '%')
            ->get();

        return response()->json(['statusCode' => '1', 'statusMessage' => 'showing searched speaker', 'Result' => $speakerName]);

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

    public function importSpeakerCSV(Request $request)
    {
        if ($request->has('speakercsv')) {

            $extension = $request->file('speakercsv')->getClientOriginalExtension();

            $photo = time() . '-' . $request->file('speakercsv')->getClientOriginalName();

            $destination = 'api/public/uploads/';

            $path = $request->file('speakercsv')->move($destination, $photo);


            $customerArr = $this->csvToArray($path);
            // return $customerArr;
            $date = [];
            for ($i = 0; $i < count($customerArr); $i++) {
                $data[] = [
                    'speakerName' => $customerArr[$i]['speakerName'],
                    'speakerOccupation' => $customerArr[$i]['speakerOccupation'],
                    'speakerCompanyName' => $customerArr[$i]['speakerCompanyName'],
                    'speakerDetails' => $customerArr[$i]['speakerDetails'],
                ];
            }

            DB::table('speakers')->insert($data);

            return response()->json(['statusCode' => '1', 'statusMessage' => 'File uploaded', 'Result' => NULL]);

        }

    }
}