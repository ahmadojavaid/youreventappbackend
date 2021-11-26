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
use App\Messages;
use Illuminate\Support\Facades\Mail;
use DB;
 
class messagesController extends Controller
{  

    //   public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }
 


   public function show()
  {       
    // $userId = Input::get("userId");

    // $otherUserId = Input::get("otherUserId");
 
       $toUser = Input::get("toUser");

       $fromUser = Input::get("fromUser");

    // $Messages   =  DB::table('messages')

    //                           ->where('toUser',$toUser)
    //                           ->where('fromUser',$fromUser)
    //                           ->orwhere('fromUser',$toUser)    
    //                           // ->orwhere('toUser',$fromUser) 
    //                           // ->join('users','users.id','=','messages.toUser')
    //                           // ->join('users as sender','sender.id','=','messages.fromUser')
    //                           // ->orderBy('messages.created_at', 'asc')
    //                           // ->select('messages.messageText','messages.created_at','messages.id as messageId','users.id as senderId','users.name as senderName','users.profileImage as senderProfileImage','users.isOnline as senderOnlineStatus','sender.id as recieverId','sender.name as recieverName','sender.profileImage as recieverProfileImage','sender.isOnline as recieverOnlineStatus')     
    //                           ->get();  
 
         $Messages   =     Messages::where(function($query)use($toUser,$fromUser) {
                   $query->where('toUser',$toUser)
                      ->Where('fromUser',$fromUser);
                })
         ->orWhere(function ($query)use($toUser,$fromUser) {
                  $query->where('toUser',$fromUser)
                      ->where('fromUser',$toUser);
                })->get();


          // DB::table('messages')
          //     ->where(function($query)use($toUser,$fromUser) {
          //                $query->where('toUser',$toUser)
          //                   ->Where('fromUser',$fromUser);
          //             })
          //      ->orWhere(function ($query)use($toUser,$fromUser) {
          //               $query->where('toUser',$fromUser)
          //                   ->where('fromUser',$toUser);
          //             }) ->update(array('messageStatus' => 1));
                             


                  // DB::table('messages')
                  //             ->where('toUser',$toUser)
                  //             ->update(array('messageStatus' => 1));


    return response()->json(['statusCode'=>'1','statusMessage'=>'showing all Messages','Result'=>$Messages]);
  }

  public function store(Request $request)
  {    
     $Activities = Messages::create($request->except(['sponsorImage']));
       
       
              $inbox_view_user = DB::table('inbox_view_user') 
                  ->where('toUser', '=', $request->toUser) 
                  ->where('fromUser', '=', $request->fromUser) 
                  ->delete(); 


          $inbox_view_user = DB::table('inbox_view_user') 
                  ->where('toUser', '=', $request->fromUser) 
                  ->where('fromUser', '=', $request->toUser) 
                  ->delete(); 

              $temp = array("toUser" => $request->toUser,'fromUser' =>$request->fromUser,'lastmessage' => $request->messageText);
          
               $inbox_view_user =  DB::table('inbox_view_user')->insertGetId($temp);

    //.....................for push notifications


         //......To user message
         $messageSentTo  =  DB::table('users')
                                 // ->where('userId',$userId)
                                    ->where('id','=',$request->toUser) 
                                    ->select('users.id')
                                    ->first(); 


             //  $util = new Utilclass();
             //  $title = 'New Messsage';
             //  $body =  'New Message Recieved';
             //  $userID =$messageSentTo->id;

             // $util->sendPushNotification($userID,$title,$body);  

         $sender = DB::table('users') 
                   ->where('id', '=', $request->fromUser)   
                   ->select('users.name')  
                   ->first();      

         $reciever = DB::table('users') 
                   ->where('id', '=', $request->toUser)   
                   ->select('users.name','users.id','deviceType')  
                   ->first();   
                  // return json_encode($reciever->deviceType);
     // $bb =  array("notificationType" => 5, "message" => $sender->name.''.' sent you a message', "title" =>'YEA');
 
              $util = new Utilclass();
              $title ='YEA';
              $body = $sender->name.''.' sent you a message';
              $userID =$reciever->id;

            if ($reciever->deviceType == 1 ) {
                $util->sendPushNotification($userID,$title,$body); 
                }  


           if ($reciever->deviceType == 2) {
               $util->sendPushNotificationAdnroid($userID,$title,$body);   
                }    
             // $util->sendPushNotification($userID,$title,$body); 
               

    return response()->json(['statusCode'=>'1','statusMessage'=>'Messages Created','Result'=>$Activities]);
  }
   
  //  public function update($id,Request $request)
  // {     
  //  $Activities=Messages::find($id);

  //    if(!$Activities)
  //   {
  //    return response()->json(['statusCode'=>'0','statusMessage'=>'Record Not Found','Result'=>NULL]);
  //   } 
  //            $Activities->update($request->except(['sponsorImage']));
          
  //       return response()->json(['statusCode'=>'1','statusMessage'=>'Messages Data is Updated','Result'=>$Activities]);
 
  // } 
  
  


   public function getConv(Request $request)
    {   
         $userId = Input::get("userId"); 

          $inbox_view_user = DB::table('inbox_view_user') 
                  ->orwhere('toUser', '=', $request->userId) 
                   ->orwhere('fromUser', '=', $request->userId)
                    ->join('users','users.id','=','inbox_view_user.toUser')
                     ->join('users as sender','sender.id','=','inbox_view_user.fromUser') 
                      ->select('inbox_view_user.lastmessage','inbox_view_user.created_at','inbox_view_user.id as messageId','sender.id as recieverId','sender.name as recieverName','sender.profileImage as recieverProfileImage','sender.isOnline as recieverOnlineStatus','users.id as senderId','users.name as senderName','users.profileImage as senderProfileImage','users.isOnline as senderOnlineStatus')
                     //->select('inbox_view_user.lastmessage','inbox_view_user.created_at','inbox_view_user.id as messageId','sender.id as recieverId','sender.name as recieverName','sender.profileImage as recieverProfileImage','sender.isOnline as recieverOnlineStatus')
                   ->orderBy('inbox_view_user.created_at', 'desc')     
                   ->get();  
             for ($i=0; $i <count($inbox_view_user) ; $i++) { 

         $inbox_view_user[$i]->{'currentUserId'} = $userId;
         
        }

                  DB::table('messages')
                              ->where('toUser',$userId)
                              ->update(array('messageStatus' => 1));
 
          return response()->json(['statusCode'=>'1','statusMessage'=>'showing last Messages','Result'=>$inbox_view_user]);
 
    }

  public function destroy($id,Request $request)
  { 
    
    $Category=Messages::find($id);
   
    if(!$Category)
       {
             return response()->json(['statusCode'=>'0','statusMessage'=>'Record Not Found','Result'=>NULL]);
       }
            $Category->delete();
  
          return response()->json(['statusCode'=>'1','statusMessage'=>'Messages deleted','Result'=>NULL]);
        } 
   public function showMessageCount()
    { 
       $userId  = Input::get("userId");
       
            $notification1s   =  DB::table('messages')
                              ->where('toUser',$userId)
                              ->where('messageStatus','=','0')
                              ->count(); 
 
            return response()->json(['statusCode'=>'1','statusMessage'=>'showing Notifications','Result'=>$notification1s]);
      }
  
   // public function updatenotification()
   //  { 
   //     $userId  = Input::get("userId");
   //        // return $userId;
   //          $notification1s   =  DB::table('notifications')
   //                            ->where('userId',$userId)
   //                            ->update(array('notifiacationStatus' => 1));
                     
   //          return response()->json(['statusCode'=>'1','statusMessage'=>'Notifications status updated','Result'=>NULL]);
   //   }
       
   }