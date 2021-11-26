<?php


namespace App\Http\Controllers;


use App\SessionNote;
use App\Sessions;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;


class SignUpController extends Controller
{
    public function signUpStart(Request $request){
       
        $array =[];
        $newuser = new User();
        $newuser->email=$request->Email;
            // echo"pre";
            // print_r($newuser->toArray());
            // die;
        if (empty($newuser->email)) 
        {
         array_push($array, "Email Required");
        }
        if (User::where('email', Input::get('email'))->exists()) 
        {  
            return response()->json(['statusCode'=>'400','statusMessage'=>'Email Already Exists','Result'=>NULL]);              
        }
        else {
            $newuser = new User();
            $newuser->name = $request->Name;
            $newuser->name = $request->Profile_Image;
            $newuser->name = $request->Gender;
            $newuser->name = $request->Age;
            $newuser->name = $request->Mobile;
            $newuser->name = $request->Address;
            $newuser->name = $request->Password;
            $newuser->name = $request->Confirm_Password;
            $newuser->save();
        }
}

}