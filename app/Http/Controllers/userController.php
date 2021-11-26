<?php

namespace App\Http\Controllers;

use App\User;
use App\Sessions;
use App\Colorschemes;
use App\LeaderBoardInformations;
use App\UserProfiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\CustomData\Utilclass;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use App\resources\emails\mailExample;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Testing\Fakes\MailFake;
use App\config\services;
use GuzzleHttp\Client;
use Log;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Client as GuzzleHttpClient;
use DB;
use FCMGroup;
use FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use App\Notifications\Contracts\FirebaseNotification;
use LaravelFCM\Request\GroupRequest;
use Response;
use Maatwebsite\Excel\Facades\Excel;

class userController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['doLogin', 'store','adminLogin']]);
    }*/

    public function logoutAppUser(Request $request){
        $userID = $request->input('user_id');

        User::where('id','=',$userID)
            ->update([
                "deviceId" => null, "deviceType" => null, "token" => null
            ]);
        return response()->json(['statusCode' => '1', 'statusMessage' => 'Logged Out Successfully', 'Result' => null]);

    }

    public function store(Request $request)
    {
        $array = [];

        $admin = new User();

        $admin->email = $request->input('email');
        if (empty($admin->email)) {
            array_push($array, "email Required");
            //return response()->json(['statusCode'=>'0','statusMessage'=>'Email Required','Result'=>NULL]);
        }

        if (User::where('email', '=', Input::get('email'))->exists()) {
            return response()->json(['statusCode' => '400', 'statusMessage' => 'email Already Exists', 'Result' => NULL]);
        } else {
            $admin = new User();
            $admin->email = $request->input('email');
            // $admin->password=$request->input('password');
            $admin->password = Hash::make(Input::get("password"));
            $admin->name = $request->input('name');
            $admin->phonenumber = $request->input('phonenumber');
            $admin->departmentId = $request->input('departmentId');

            if (!$admin->password) {
                array_push($array, "Password Required");
            }
            if (count($array) > 0) {

                return response()->json(['statusCode' => '400', 'statusMessage' => 'Fill the given fields', 'Result' => $array]);
            }

            $admin->save();

            $UserProfiles = new UserProfiles();

            $UserProfiles->userId = $admin->id;

            $UserProfiles->save();

            $token = bin2hex(openssl_random_pseudo_bytes(25));
            DB::table('users')->where('id', $admin->id)->update(array('token' => $token));

            $admin->token = $token;

            //   Mail::send('emails.verify',["data" => $admin], function($message) use ($admin) {
            // $message->from('baqalah1@gmail.com', 'Triboth');

            // $message->to($admin->email, 'Mail Confirmation')->subject('Testing Mail');
            //         });

            $collection = collect(['id' => $admin->id, 'email' => $admin->email, 'token' => $admin->token, 'name' => $admin->name]);
            $collection->toJson();

            return response()->json(['statusCode' => '200', 'statusMessage' => 'Account Successfully Created', 'Result' => $collection]);

        }
    }

    public function updatePassWord(Request $request)
    {
        $email = $request->input('email');
        $oldpassword = $request->input('oldpassword');

        $getOldpass = DB::table('users')
            ->where('email', '=', $email)
            ->pluck('password')
            ->first();

        if (Hash::check($oldpassword, $getOldpass)) {
            $up = DB::table('users')->where('email', '=', $email)->update(array('password' => Hash::make(Input::get("newpassword"))));

            return response()->json(['statusCode' => '1', 'statusMessage' => 'Password is updated', 'Result' => $up]);
        } else {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Wrong Password', 'Result' => NULL]);

        }
    }

    public function confirm(Request $request, $id)
    {

        $admin = User::where('token', '=', $id)->first();
        if (!$admin) {
            return response()->json(['statusCode' => '1', 'statusMessage' => 'Something Went wrong', 'Result' => $admin]);
        } else {
            $account_status = 1;

            DB::table('admin_users')->where('token', $id)->update(array('account_status' => $account_status));

            $admin->save();

            return redirect('http://book-leisure2.herokuapp.com/#/login');
        }
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }

    public function doLogin(Request $request)
    {

        // return 'sss';
        $token = "";
        $Email = Input::get("email");
        // $Password = Input::get("password"); 
        $Password = Hash::make(Input::get("password"));

        // $check_User_role = DB::table('users') 
        //     ->where('email', '=', $Email)  
        //     ->first();
        //     if ($check_User_role->role ==1) {

        //       return response()->json(['statusCode'=>'0','statusMessage'=>'Sorry Unable to Login ','Result'=>NULL]);
        //     }
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Email or password wrong', 'Result' => NULL]);
        }
        $myUser = Auth::user();
        if (!$token) {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Incorrect Email or Password', 'Result' => NULL]);
        }

        // $token = bin2hex(openssl_random_pseudo_bytes(25));

        // $myUser = DB::table('admin_users')
        //     ->select()
        //     ->where('email', '=', $Email)
        //     ->where('password', '=', $Password)
        //     ->first();
        $myUser = Auth::user();

        // if ($myUser->account_status == 0) 
        // {
        //  return response()->json(['statusCode' => '0', 'statusMessage' => 'Kindly Verify Your Email', 'Result' => NULL]);
        // }   


        if ($myUser) {

            $myUser->token = $token;

            DB::table('users')->where('email', $Email)->update(array('token' => $token));
            DB::table('users')->where('email', $Email)->update(array('deviceId' => $request->deviceId));
            DB::table('users')->where('email', $Email)->update(array('deviceType' => Input::get("deviceType")));

            $colorschemes = \DB::table('colorschemes')
                ->first();


            // return json_encode($colorschemes);
            return response()->json(['statusCode' => '1', 'statusMessage' => 'Logged In', 'Result' => $myUser, 'schemes' => $colorschemes]);
        } else {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Email or Password Incorrect', 'Result' => NULL]);
        }
    }

    public function logout(Request $request)
    {

        Auth::logout();

        return response()->json(['statusCode' => '1', 'statusMessage' => 'Logout Successfully', 'Result' => Auth::user()]);


    }

    public function adminLogin(Request $request)
    {
        $token = "";
        $Email = Input::get("email");
        // $Password = Input::get("password"); 
        $Password = Hash::make(Input::get("password"));

        $check_User = DB::table('users')
            ->where('email', '=', $Email)
            ->first();
        // return json_encode($check_User);
        if (!$check_User) {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Email or password wrong', 'Result' => NULL]);
        }
        if ($check_User->role == 1) {

            $credentials = $request->only('email', 'password');

            if (!$token = Auth::attempt($credentials)) {
                return response()->json(['statusCode' => '0', 'statusMessage' => 'Email or password wrong', 'Result' => NULL]);
            }


            $myUser = Auth::user();
            if (!$token) {
                return response()->json(['statusCode' => '0', 'statusMessage' => 'Incorrect Email or Password', 'Result' => NULL]);
            }

            // $token = bin2hex(openssl_random_pseudo_bytes(25));

            // $myUser = DB::table('admin_users')
            //     ->select()
            //     ->where('email', '=', $Email)
            //     ->where('password', '=', $Password)
            //     ->first();
            $myUser = Auth::user();
            // return $myUser;
            // if ($myUser->active_status == 0)
            // {
            //  return response()->json(['statusCode' => '0', 'statusMessage' => 'sorry,You are no longer to able to Login', 'Result' => NULL]);
            // }
            // if ($myUser->account_status == 0)
            // {
            //  return response()->json(['statusCode' => '0', 'statusMessage' => 'Kindly Verify Your Email', 'Result' => NULL]);
            // }
            if ($myUser) {

                $myUser->token = $token;

                DB::table('users')->where('email', $Email)->update(array('token' => $token));
                // DB::table('users')->where('email', $Email)->update(array('fcmToken' => Input::get("fcmToken")));

                return response()->json(['statusCode' => '1', 'statusMessage' => 'Logged In', 'Result' => $myUser]);
            }
        } else {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Email or Password Incorrect', 'Result' => NULL]);
        }
    }

    public function notFound()
    {
        return response()->json(['statusCode' => '404', 'statusMessage' => 'Something Went Wrong', 'Result' => NULL]);

    }

    public function disableUser($id, Request $request)
    {
        $status = $request->input('status');

        $temp = DB::table('users')->where('id', $id)->update(array('active_status' => $status));

        return response()->json(['statusCode' => '1', 'statusMessage' => 'Successfully changed the status', 'Result' => $temp]);

    }

    public function deleteUser($id, Request $request)
    {
        $temp = DB::table('users')->where('id', $id)->delete();

        //         $count=DB::table('departments')
        //                   ->where('id','=',$admin->departmentId)
        //                   ->pluck('count')
        //                   ->first();
        //               $tem= $count+1;
        //               // return $count;
        // DB::table('departments')->where('id', $admin->departmentId)->update(array('count' => $tem));

        return response()->json(['statusCode' => '1', 'statusMessage' => 'User Successfully Deleted', 'Result' => $temp]);

    }

    public function generate_logins(Request $request)
    {
        $array = [];

        $admin = new User();

        $admin->email = $request->input('email');

        if (empty($admin->email)) {
            array_push($array, "email Required");
            return response()->json(['statusCode'=>'0','statusMessage'=>'Email Required','Result'=>NULL]);
        }

        if (User::where('email', '=', Input::get('email'))->exists()) {
            return response()->json(['statusCode' => '400', 'statusMessage' => 'email Already Exists', 'Result' => NULL]);
        } else {
            $rules = [
                'email' => 'required|email',
                'password' => 'required',
                'role' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => [$validator->errors()->all()],
                    'data' => null,
                ], 400);
            }
            $admin = new User();
            $admin->email = $request->input('email');
            // $admin->password=$request->input('password');
            $admin->password = Hash::make(Input::get("password"));
            $admin->name = $request->input('name');
            $admin->Surname = $request->input('Surname');
            $admin->role = $request->input('role');
            $admin->contact = $request->input('contact');
            $admin->companyName = $request->input('companyName');
            $admin->jobTitle = $request->input('jobTitle');
            $admin->gender = $request->input('gender');


            if (!$admin->password) {
                array_push($array, "Password Required");
            }
            if (count($array) > 0) {

                return response()->json(['statusCode' => '400', 'statusMessage' => 'Fill the given fields', 'Result' => $array]);
            }


            $admin->save();

            $token = bin2hex(openssl_random_pseudo_bytes(25));

            DB::table('users')->where('id', $admin->id)->update(array('token' => $token));

            $admin->token = $token;

            $getLogo = DB::table('colorschemes')
                ->pluck('appLogo')
                ->first();
            $getLogo = "http://yea.jobesk.com/backend/public/" . $getLogo;

            Mail::send([],[], function ($message) use ($admin, $request) {

                $message->from('info@yea.com', 'EventApp');

                $bodystring = "\n\n " . $admin->message . " \n\n Hello : " . $admin->name . " \n Your Email is : " . $admin->email . " \n Your Password is  : " . $request->password;

                $message->to($admin->email, 'Mail Confirmation')->subject('Welcome');
                $message->setBody($bodystring);
            });
            $collection = collect(['id' => $admin->id, 'email' => $admin->email, 'token' => $admin->token, 'name' => $admin->name]);

            $collection->toJson();

            // new User will be following all the previous users

            $users = DB::table('users')
                ->where('role', 2)
                ->pluck('id');

            for ($i = 0; $i < count($users); $i++) {

                $temp = array("userId" => $admin->id, "followerId" => $users[$i]);

                $lists = DB::table('followers')->insertGetId($temp);
            }
            DB::table('users')->where('id', $admin->id)->update(array('followingCount' => count($users)));

            return response()->json(['statusCode' => '200', 'statusMessage' => 'Account Successfully Created ,Kindly check your inbox or spam folder ! ', 'Result' => $collection]);

        }
        // }
        //   catch (\Exception $e) {
        //   return response()->json(['statusCode'=>'0','statusMessage'=>'Some thing went wrong','error' => $e->getMessage()]);
        // }
    }

    public function showLogins(Request $request)
    {

        $userId = $request->input('userId');

        $attendees = DB::table('users')
            ->where('role', 2)
            ->orderBy('name')
            ->get();
        // return $attendees;

        for ($i = 0; $i < count($attendees); $i++) {

            $followed = DB::table('followers')
                ->where('userId', '=', $userId)
                ->where('followerId', '=', $attendees[$i]->id)
                ->first();
            if ($followed) {
                $attendees[$i]->{'isfollowed'} = 1;
            } else
                $attendees[$i]->{'isfollowed'} = 0;
        }

        return response()->json(['statusCode' => '1', 'statusMessage' => 'showing all users', 'Result' => $attendees]);
    }

    public function showAdmins(Request $request)
    {

        $userId = $request->input('userId');

        $users = DB::table('users')
            ->where('id', $userId)
            ->pluck('role')
            ->first();
        if ($users == 1) {

            $users = DB::table('users')
                ->where('role', 1)
                ->orderBy('name')
                ->get();
            return response()->json(['statusCode' => '1', 'statusMessage' => 'showing all users', 'Result' => $users]);

        }

        return response()->json(['statusCode' => '1', 'statusMessage' => 'showing all users', 'Result' => $users]);

    }

    // public function showAdmins(Request $request)
    //  {

    //    $userId = $request->input('userId');

    //       $checkIFAnAdmin=DB::table('users')
    //                      ->where('id','=',$userId)
    //                      ->pluck('role')
    //                      ->first();
    //    if ($checkIFAnAdmin == 1) {

    //       $users=DB::table('users')
    //                      ->where('role','=',1)
    //                      ->get();

    //  return response()->json(['statusCode'=>'200','statusMessage'=>'showing all users','Result'=>$users]);

    //            }
    //  else{
    //           return response()->json(['statusCode'=>'0','statusMessage'=>'showing all users','Result'=>NULL]);

    //       }

    //  }

    public function forgotPassword(Request $request)
    {
        $rules = [
            'email' => 'required|email',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'please provide email', 'Result' => null]);
        }
        $user = User::where('email', '=', $request->input('email'))->first();
        if (is_null($user)) {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Email not found in our system', 'Result' => null]);
        }
        $pwd = str_shuffle(bin2hex(openssl_random_pseudo_bytes(3)));
        $user->password = Hash::make($pwd);
        $user->save();

        Mail::send('email.forgotPassword', ["data" => $pwd], function ($message) use ($user) {
            $message->from('info@yea.com', 'EventApp');
            $message->to($user->email, 'Mail Confirmation')->subject('New Password');
            // $message->to($user['email'], 'New Password')->subject('New Password');
        });
        return response()->json(['statusCode' => '1', 'statusMessage' => 'Please check your mail', 'Result' => null]);
    }



    // public function update($id,Request $request)
    // {
    //     $User=User::find($id);

    //        if(!$User)
    //       {
    //        return response()->json(['statusCode'=>'0','statusMessage'=>'Record Not Found','Result'=>NULL]);
    //       }
    //        DB::table('users')->where('id', $id)->update(array('email' => ""));

    //        // return;
    //        if ($request->has('email') ) {

    //           if (User::where('email','=',Input::get('email'))->exists() )
    //          {
    //          return response()->json(['statusCode'=>'400','statusMessage'=>'email Already Exists','Result'=>NULL]);
    //          }
    //       }
    //             $User->update($request->except(['token']));
    //          if ($request->has('password')) {
    //               DB::table('users')->where('id', $id)->update(array('password' => Hash::make(Input::get("password"))));
    //           }
    //                 DB::table('users')->where('id', $id)->update(array('email' =>Input::get("email")));

    //            return response()->json(['statusCode'=>'1','statusMessage'=>'user Successfully updated','Result'=>$User]);
    // }


    public function update($id, Request $request)
    {

        //for reference see the above same  function


        $User = User::find($id);
        // return $User;
        if (!$User) {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Record Not Found', 'Result' => NULL]);
        }
        // $VendorProfiles->update($request->all());
        if ($request->has('profileImage')) {

            $User->update($request->except(['profileImage', 'token', 'email', 'password']));

            $unique = bin2hex(openssl_random_pseudo_bytes(11));

            $format = '.png';

            $entityBody = $request['profileImage'];// file_get_contents('php://input');

            $imageName = $User->id . $unique . $format;

            $directory = "/images/profileImages/";

            $path = base_path() . "/public" . $directory;

            $data = base64_decode($entityBody);

            file_put_contents($path . $imageName, $data);

            $response = $directory . $imageName;

            $User->profileImage = $response;

            DB::table('users')->where('id', $id)->update(array('profileImage' => $response));

            if ($request->has('password')) {

                DB::table('users')->where('id', $id)->update(array('password' => Hash::make(Input::get("password"))));
            }
        } else {

            $User->update($request->except(['profileImage', 'token', 'email', 'password']));

            if ($request->has('password')) {

                DB::table('users')->where('id', $id)->update(array('password' => Hash::make(Input::get("password"))));
            }

            return response()->json(['statusCode' => '1', 'statusMessage' => 'user data is Updated', 'Result' => $User]);

        }
        return response()->json(['statusCode' => '1', 'statusMessage' => 'user data is Updated', 'Result' => $User]);

    }

    public function followOrUnfollow()
    {
        $userId = Input::get("userId");
        $followerId = Input::get("followerId");

        $Posts = DB::table('followers')
            ->where('userId', $userId)
            ->where('followerId', $followerId)
            ->first();
        if ($Posts) {

            DB::table('followers')->where('userId', $userId)->where('followerId', $followerId)->delete();

            DB::table('users')->where('id', $userId)->update(['followingCount' => DB::raw('IFNULL(followingCount - 1, 0)')]);
            DB::table('users')->where('id', $followerId)->update(['followersCount' => DB::raw('IFNULL(followersCount - 1, 0)')]);

            return response()->json(['statusCode' => '1', 'statusMessage' => 'successfully unfollowing the user', 'Result' => NULL]);

        } else {

            $temp = array("userId" => $userId, "followerId" => $followerId);

            $lists = DB::table('followers')->insertGetId($temp);

            DB::table('users')->where('id', $userId)->update(['followingCount' => DB::raw('followingCount + 1')]);

            DB::table('users')->where('id', $followerId)->update(['followersCount' => DB::raw('followersCount + 1')]);

            return response()->json(['statusCode' => '1', 'statusMessage' => 'successfully following the user', 'Result' => NULL]);

        }

    }

    public function leaderboard()
    {
        $userId = Input::get("userId");

        $Posts = DB::table('users')
            ->where('points', '>', 'max')
            ->orderBy('points', 'DESC')
            ->limit(10)
            ->get();


        for ($i = 0; $i < count($Posts); $i++) {

            $followed = DB::table('followers')
                ->where('userId', '=', $userId)
                ->where('followerId', '=', $Posts[$i]->id)
                ->first();
            if ($followed) {
                $Posts[$i]->{'isfollowed'} = 1;
            } else
                $Posts[$i]->{'isfollowed'} = 0;
        }
        return response()->json(['statusCode' => '1', 'statusMessage' => 'showing the leaderboard users', 'Result' => $Posts]);
    }

    public function pinPost()
    {
        $userId = Input::get("userId");
        $postId = Input::get("postId");

        $checkAlreadyPinned = DB::table('users')
            ->where('id', $userId)
            ->where('pinnedPostId', '=', $postId)
            ->first();

        // return json_encode($checkAlreadyPinned);

        if ($checkAlreadyPinned) {

            $Posts = DB::table('users')->where('id', $userId)->where('pinnedPostId', '=', $postId)->update(array('pinnedPostId' => NULL));

            return response()->json(['statusCode' => '1', 'statusMessage' => 'successfully unpinned the post', 'Result' => $Posts]);

        } else {

            $Posts = DB::table('users')->where('id', $userId)->update(array('pinnedPostId' => $postId));

            return response()->json(['statusCode' => '1', 'statusMessage' => 'post added as pinned post', 'Result' => $Posts]);

        }

    }

    public function showNotifications()
    {
        $userId = Input::get("userId");

        $Posts = DB::table('notifications')
            ->where('userId', $userId)
            ->orwhere('notificationType', '1')
            ->orwhere('notificationType', '5')
            ->orderBy('created_at', 'DESC')
            ->paginate(15);

        for ($i = 0; $i < count($Posts); $i++) {

            $Sessions = new Sessions();

            $Posts[$i]->{'sessionData'} = $Sessions->singleSessions($Posts[$i]->postId);

            // $Posts[$i]->{'sessionData'} = $this->getSessions($Posts[$i]->postId);//['asd'=>'123'];
        }
        // return $Posts;
        return response()->json(['statusCode' => '1', 'statusMessage' => 'showing Notifications', 'Result' => $Posts]);
    }

    public function getSessions($postId)
    {
        $sessions = DB::table('sessions')
            ->where('id', $postId)
            ->get();

        return $sessions;
    }

    public function showUserData($id)
    {

        $userId = Input::get("userId");

        $User = new User();

        $return = $User->userspost($id);

        for ($i = 0; $i < count($return); $i++) {

            $followed = DB::table('followers')
                ->where('userId', '=', $userId)
                ->where('followerId', '=', $id)
                ->first();


            if ($followed) {

                $return[$i]->{'isfollowed'} = 1;
            } else
                $return[$i]->{'isfollowed'} = 0;
        }

        for ($i = 0; $i < count($return); $i++) {

            for ($j = 0; $j < count($return[$i]->posts); $j++) {

                $liked = DB::table('post_likes')
                    ->where('userId', '=', $userId)
                    ->where('postId', '=', $return[$i]->posts[$j]->id)
                    ->first();

                if ($liked) {

                    // $pinned[$i]->comments[$j]->{'isLikedTheComment'} =1;

                    $return[$i]->posts[$j]->{'isLiked'} = 1;
                } else
                    $return[$i]->posts[$j]->{'isLiked'} = 0;

            }
        }
        for ($i = 0; $i < count($return); $i++) {

            for ($j = 0; $j < count($return[$i]->posts); $j++) {

                for ($k = 0; $k < count($return[$i]->posts[$j]->comments); $k++) {

                    $liked = DB::table('post_comment_likes')
                        ->where('userId', '=', $userId)
                        ->where('commentId', '=', $return[$i]->posts[$j]->comments[$k]->id)
                        ->first();

                    if ($liked) {

                        $return[$i]->posts[$j]->comments[$k]->{'isLikedTheComment'} = 1;
                    } else
                        $return[$i]->posts[$j]->comments[$k]->{'isLikedTheComment'} = 0;
                }
            }
        }
        return response()->json(['statusCode' => '1', 'statusMessage' => 'showing user details', 'Result' => $return]);
    }

    public function showNotificationsCount()
    {
        $userId = Input::get("userId");

        $notification1s = DB::table('notifications')
            ->where('userId', $userId)
            ->where('notifiacationStatus', '=', '0')
            ->count();

        return response()->json(['statusCode' => '1', 'statusMessage' => 'showing Notifications', 'Result' => $notification1s]);
    }

    public function updatenotification()
    {
        $userId = Input::get("userId");
        // return $userId;
        $notification1s = DB::table('notifications')
            ->where('userId', $userId)
            ->update(array('notifiacationStatus' => 1));

        return response()->json(['statusCode' => '1', 'statusMessage' => 'Notifications status updated', 'Result' => NULL]);
    }


//    public function updatenotification()
//     { 
//        $userId  = Input::get("userId");
// // return $userId;
//             $notification1s   =  DB::table('notifications')
//                               ->where('userId',$userId)
//                               ->update(array('notifiacationStatus' => 1));

//             return response()->json(['statusCode'=>'1','statusMessage'=>'Notifications status updated','Result'=>NULL]);
//       }
    public function searchAttendee(Request $request)
    {
        $userId = $request->input('userId');

        $attendeeName = $request->input('attendeeName');

        $attendeeName = \DB::table('users')
            ->Where('name', 'LIKE', '%' . $attendeeName . '%')
            ->get();

        for ($i = 0; $i < count($attendeeName); $i++) {

            $followed = DB::table('followers')
                ->where('userId', '=', $userId)
                ->where('followerId', '=', $attendeeName[$i]->id)
                ->first();
            if ($followed) {
                $attendeeName[$i]->{'isfollowed'} = 1;
            } else
                $attendeeName[$i]->{'isfollowed'} = 0;
        }

        return response()->json(['statusCode' => '1', 'statusMessage' => 'showing searched Attendee', 'Result' => $attendeeName]);

    }

    public function color(Request $request)
    {
        $flight = Colorschemes::updateOrCreate(

            ['id' => 1], ['statusColor' => $request->input('statusColor'), 'appColor' => $request->input('appColor'), 'btnColor' => $request->input('btnColor')]
        );
        if ($request->has('appLogo')) {

            $unique = bin2hex(openssl_random_pseudo_bytes(11));

            $format = '.png';

            $entityBody = $request['appLogo'];// file_get_contents('php://input');

            $imageName = '1' . $unique . $format;

            $directory = "/images/profileImages/";

            $path = base_path() . "/public" . $directory;

            $data = base64_decode($entityBody);

            file_put_contents($path . $imageName, $data);

            $response = $directory . $imageName;

            // $User->profileImage = $response;

            DB::table('colorschemes')->where('id', 1)->update(array('appLogo' => $response));
        }

        return response()->json(['statusCode' => '1', 'statusMessage' => 'Themes color upated', 'Result' => $flight]);

    }

    public function export(Request $request)
    {


        // $users = User::get();
        // $table =DB::table('users')
        // ->where('role',2)
        // ->get();
        // return $users;
        $table = User::all()->where('role', 2)->toArray();
        $filename = "tweets.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('email', 'name', 'Surname', 'jobTitle', 'companyName', 'contact', 'role'));

        foreach ($table as $row) {
            fputcsv($handle, array(
                $row['email'],
                $row['name'],
                $row['Surname'],
                $row['jobTitle'],
                $row['companyName'],
                $row['contact'],
                $row['role']));
        }
        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return $path = 'yea.jobesk.com/' . $filename;

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

    public function import(Request $request)
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
                $data[] = [
                    'name' => $customerArr[$i]['name'],
                    'Surname' => $customerArr[$i]['Surname'],
                    'email' => $customerArr[$i]['email'],
                    'jobTitle' => $customerArr[$i]['jobTitle'],
                    'companyName' => $customerArr[$i]['companyName'],
                    'contact' => $customerArr[$i]['contact'],
                    'password' => Hash::make($customerArr[$i]['password']),
                    'role' => 2,
                ];

                Mail::send('email.buyerEmail', ["data1" => $customerArr, "logo" => $getLogo], function ($message) use ($customerArr, $i) {

                    $message->from('info@yea.com', 'EventApp');

                    $bodystring = " Hello : " . $customerArr[$i]['name'] . " \n Your Email is : " . $customerArr[$i]['email'] . " \n Your Password is  : " . $customerArr[$i]['password'];

                    $message->to($customerArr[$i]['email'], 'Mail Confirmation')->subject('Welcome');
                    $message->setBody($bodystring);
                });

                $temp = DB::table('users')->insertGetId($data[$i]);


                $usersas = DB::table('users')
                    ->where('role', 2)
                    ->pluck('id');

                for ($j = 0; $j < count($usersas); $j++) {
                    $temp1 = array("userId" => $temp, "followerId" => $usersas[$j]);

                    $lists = DB::table('followers')->insertGetId($temp1);

                }
                DB::table('users')->where('id', $temp)->update(array('followingCount' => count($usersas)));
            }

            return response()->json(['statusCode' => '1', 'statusMessage' => 'File uploaded', 'Result' => NULL]);

        }

    }

    /*  public function import(Request $request)
   {



          if ($request->has('file')) {

          $extension = $request->file('file')->getClientOriginalExtension();

           $photo = time().'-'.$request->file('file')->getClientOriginalName();

                   $destination =  'api/public/uploads/';


                   $path = $request->file('file')->move($destination, $photo);


                $customerArr = $this->csvToArray($path);

                // return $customerArr;//[0]['email'];
                 $date = [];
                 for ($i = 0; $i < count($customerArr); $i ++)
                 {

                   // return $customerArr;
                     $data[] = [
                       'email' =>$customerArr[$i]['email'],
                       'name' =>  $customerArr[$i]['name'],
                       'password' =>  hash::make($customerArr[$i]['password']),
                       'role' => 2,

                     ];

      Mail::send([],[], function($message) use ($customerArr,$i) {

     $message->from('feedbacksystem18@gmail.com', 'EventApp');

     $bodystring =  " Hello : ".$customerArr[$i]['name']." \n Your Email is : ".$customerArr[$i]['email']." \n Your Password is  : ".$customerArr[$i]['password'] ;

     $message->to($customerArr[$i]['email'], 'Mail Confirmation')->subject('Welcome');
     $message->setBody($bodystring);
             });
                     //User::firstOrCreate($customerArr[$i]);
                 }

                   DB::table('users')->insert($data);

       return response()->json(['statusCode'=>'1','statusMessage'=>'File uploaded','Result'=>NULL]);

          }

   } */
    public function deletes(Request $request)
    {
        $userId = Input::get("userId");

        $checkRole = DB::table('users')
            ->where('id', '=', $userId)
            ->pluck('role')
            ->first();

        if (empty($checkRole)) {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'you are not authorized to perform this action', 'Result' => NULL]);
        }
        if ($checkRole == 1) {

            DB::table('followers')->truncate();
            DB::table('inbox_view_user')->truncate();
            DB::table('messages')->truncate();
            DB::table('notifications')->truncate();
            DB::table('posts')->truncate();
            DB::table('post_actions')->truncate();
            DB::table('post_attachements')->truncate();
            DB::table('post_comments')->truncate();
            DB::table('post_comment_likes')->truncate();
            DB::table('post_likes')->truncate();
            DB::table('sessions')->truncate();
            DB::table('session_speakers')->truncate();
            DB::table('session_sponsors')->truncate();
            DB::table('speakers')->truncate();
            DB::table('speaker_documents')->truncate();
            DB::table('sponsors')->truncate();
            DB::table('session_timeslots')->truncate();
            DB::table('timeslot_management')->truncate();
            DB::table('users')
                ->where('role', '=', 2)
                ->delete();
            return response()->json(['statusCode' => '1', 'statusMessage' => 'successfully emptied the db', 'Result' => NULL]);

        } else {
            return response()->json(['statusCode' => '1', 'statusMessage' => 'you are not authorized to perform this action', 'Result' => NULL]);

        }
    }


    public function info(Request $request)
    {
        $flight = LeaderBoardInformations::updateOrCreate(
            ['id' => 1], ['text' => $request->input('text')]
        );

        return response()->json(['statusCode' => '1', 'statusMessage' => 'LeaderBoardInformations upated', 'Result' => $flight]);

    }

    public function getinfo(Request $request)
    {
        $info = DB::table('leader_board_informations')
            ->first();


        return response()->json(['statusCode' => '1', 'statusMessage' => 'LeaderBoardInformations retrieved', 'Result' => $info]);

    }

    public function getColor(Request $request)
    {
        $colorschemes = DB::table('colorschemes')
            ->first();

        return response()->json(['statusCode' => '1', 'statusMessage' => 'color schemes retrieved', 'Result' => $colorschemes]);

    }

    public function getLogo(Request $request)
    {
        $getLogo = DB::table('colorschemes')
            ->pluck('appLogo')
            ->first();

        $getLogo = "http://yea.jobesk.com/api/public/" . $getLogo;

        return response()->json(['statusCode' => '1', 'statusMessage' => 'logo Url retrieved', 'Result' => $getLogo]);

    }

    public function deleteAttendees(Request $request)
    {

        $ids = $request->input('ids');

        // $string = trim($ids, ".");
        //        $split = explode(",", $string); 

        $delMultipleAttendees = DB::table('users')
            ->whereIn('id', $ids)
            ->delete();

        return response()->json(['statusCode' => '1', 'statusMessage' => 'Slected Attendees Deleted', 'Result' => NULL]);
    }

}