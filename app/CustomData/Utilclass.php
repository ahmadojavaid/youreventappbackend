<?php 

namespace App\CustomData;
use DB; 


class Utilclass 
{

	public function isAuthenticated($id, $token)
	{


		 //Check if this is a valid token
      $myToken = DB::table('users')->where('id', $id)->value('token');

      if($token != $myToken)
      {

        return false;
      }
      else
    {
		return true;
  	}

	}

  public function sendPushNotification($userID,$title,$body)
  {

    $FcmToken = DB::table('users')->where('id', $userID)->pluck('deviceId')->first();
 
        $notification = array("title" => $title, "body" => $body, "sound" => "default", "type"=>"");
        
        $temp = array("to" => $FcmToken, "notification" => $notification);

        $url = "https://fcm.googleapis.com/fcm/send";

            $client = new \GuzzleHttp\Client([
            'headers' => [ 'Content-Type' => 'application/json',
            'Authorization' => "key=AAAABf22rsg:APA91bF6enOFcFiL28U4_oftVmEDhZ8JL0ep8Fx-Jj6F4lAXf9Pvrg6UjP12vfA1rrENYroO0X7cVfcssUTvLNKmKNuRlMXU9DEDIbtfRV7P7oGnseGf-0VIAk_QqcYR0dDtta8GdNS-"
             ]
        ]);
 
if (empty($FcmToken)) 
{
 return;
}
  
  $response = $client->post($url, [ 'body' => json_encode($temp) ]);


  return $response;

  } 

  public function sendPushNotificationAdnroid($userID,$title,$body)
  {

    $FcmToken = DB::table('users')->where('id', $userID)->pluck('deviceId')->first();
 
        $notification = array("title" => $title, "body" => $body, "sound" => "default");
        
        $temp = array("to" => $FcmToken, "data" => $notification);

        $url = "https://fcm.googleapis.com/fcm/send";

            $client = new \GuzzleHttp\Client([
            'headers' => [ 'Content-Type' => 'application/json',
            'Authorization' => "key=AAAABf22rsg:APA91bF6enOFcFiL28U4_oftVmEDhZ8JL0ep8Fx-Jj6F4lAXf9Pvrg6UjP12vfA1rrENYroO0X7cVfcssUTvLNKmKNuRlMXU9DEDIbtfRV7P7oGnseGf-0VIAk_QqcYR0dDtta8GdNS-"
             ]
        ]);
 
if (empty($FcmToken)) 
{
 return;
}
  
$response = $client->post($url, [ 'body' => json_encode($temp) ]);


return $response;

  } 
  
// 	public function sendPushNotificationAgenda($userID,$title,$body)
// 	{

//     $FcmToken = DB::table('users')->where('id', $userID)->pluck('deviceId')->first();
 
//         $notification = array("title" => $title, "body" => $body, "sound" => "default","notificationType" => 1,"AgendaId" => $body->id, "title" =>'YEA',  "message" =>'Agenda Update');
        
//         $temp = array("to" => $FcmToken, "data" => $notification);

//         $url = "https://fcm.googleapis.com/fcm/send";

//             $client = new \GuzzleHttp\Client([
//             'headers' => [ 'Content-Type' => 'application/json',
//             'Authorization' => "key=AAAABf22rsg:APA91bF6enOFcFiL28U4_oftVmEDhZ8JL0ep8Fx-Jj6F4lAXf9Pvrg6UjP12vfA1rrENYroO0X7cVfcssUTvLNKmKNuRlMXU9DEDIbtfRV7P7oGnseGf-0VIAk_QqcYR0dDtta8GdNS-"
//              ]
//         ]);
 
// if (empty($FcmToken)) 
// {
//  return;
// }


// $response = $client->post($url, [ 'body' => json_encode($temp) ]);


// return $response;

// 	}	

	// public function sendPushNotificationToGroup($GroupName,$title,$body)
	// {

 //  $FcmToken = DB::table('groupfcmtokens')->where('GroupName',$GroupName)->pluck('GroupToken')->first();


 //  $notification = array("title" => $title, "body" => $body, "sound" => "default");

 //  $temp = array("to" => $FcmToken, "notification" => $notification);

 //  $url = "https://fcm.googleapis.com/fcm/send";

 //      $client = new \GuzzleHttp\Client([
 //      'headers' => [ 'Content-Type' => 'application/json',
 //      'Authorization' => "key= AAAAhf3z1Ec:APA91bHPalWRjzPRATLMKGzNflfLNaFQ7dkfqJG4RAJNh8fO3zMtnH47opLH552gF_eVVO9m1x3lpauagN592L9GzGdlruj2UuIHTjo0Y42S2P3aencI9oWXkgpxt10n5MpDWcmLzXug"
 //     ]
 //  ]);

 //    $response = $client->post($url, [ 'body' => json_encode($temp) ]);


 //    return $response;


	
	// }		


}