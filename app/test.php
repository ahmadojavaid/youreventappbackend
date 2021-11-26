/*ae Andoird da ae
<?php
$server_key = "AAAAnZpojC0:APA91bEO8lbL_KRzxE0jEDNXo3r7xQsiIObDCji0tnBth4-rqRrF4EiG6cchnbxx7fBvGFp2PuH_oZeGDrwNBB4-ws-CSKoCzNfueuWLXR0GDvpad8Jb3UC0VBiO_JnJ_Y3UwtBaBw6X";

$otoken = "d7VtkfdoPC8:APA91bGC3lsH_mCDIa6gRAKvvV4K6cA0Es6k_7-Nt9jyBrMuZCTsndl9heL6L_1NAjeY9OchptBwDs2hZKSBriWZSFCabgnOvMNugVVczsToT2rapjQ4iJT-1l6xCs5f5V-vcgreVROx";
$registration_ids = array($otoken);
 



$data = array(
    "body"=> "Phone Wapis dy do bhhai",
    "title" => "Phone Wapis", 
    "NewFiled" => "New Data"

    );
$fields = array(
        "registration_ids" =>$registration_ids,
        "data" => $data,
        "time_to_live"=>15000 //mili seconds of life of notioction
);

$headers = array(
        "Authorization: key=".$server_key,
        "Content-Type: application/json"
);


#Send Reponse To FireBase Server
$ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );
#Echo Result Of FireBase Server

?>
 

<!-- Second Method -->
<?php

    include "db.php";
    
    
    
    $senderID = $_POST['sender_id'];
    $senderName = $POST['sender_name'];
    $id = $_POST['recevier_id'];
    $chatmsg = $_POST['chat_msg'];
 
    
    
    $user = "select * from users where user_id = '$id'";
    $rr1 = mysqli_query ($con, $user);
    $row1 = mysqli_fetch_assoc($rr1);
    
    
    $devID = $row1['deviceID'];
    

   

$registrationIds = array( $devID ); //Replace this with your device token


// API access key from Google API's Console                              
define( 'API_ACCESS_KEY', 'AAAAupTnU5A:APA91bEqB5LsCsbTsXKtaCPAhpt09W8idmO0DZUWveA6CfNP1UijX6AgDHdiVVY-5_XNKP7X_0nRsnNqWtS5JoLmYR1-xFirVYGQjLZXsD5CRvzK-_q3ySMmDAu7jCWwC9-VfwAaTHpU' );
// prep the bundle
$msg = array(
        'body'  => "Please tap here to view message",
        'title'     => "Mission app",
        'vibrate'   => 1,
        'msg' => $chatmsg, 
        'sender_id' => $senderID, 
        'type' => "chatMsg", 
        'senderName' => $senderName, 
        'sound'     => 1,
    );
$fields = array(
            'registration_ids'  => $registrationIds,
            'notification'      => $msg
        ); 
$headers = array(
            'Authorization: key=' . 'AAAAupTnU5A:APA91bEqB5LsCsbTsXKtaCPAhpt09W8idmO0DZUWveA6CfNP1UijX6AgDHdiVVY-5_XNKP7X_0nRsnNqWtS5JoLmYR1-xFirVYGQjLZXsD5CRvzK-_q3ySMmDAu7jCWwC9-VfwAaTHpU',
            'Content-Type: application/json'
        );

$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );
echo $result;








?>
*/