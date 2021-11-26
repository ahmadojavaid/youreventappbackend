<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });



//..........user Signup

        $router->get('user-logout', array('uses' => 'userController@logoutAppUser'));
		$router->post('usersignup', array('uses' => 'userController@store')); 
		$router->post('logout', array('uses' => 'userController@logout')); 
		$router->post('blockUser/{id}', array('uses' => 'userController@disableUser')); 
		$router->delete('deleteUser/{id}', array('uses' => 'userController@deleteUser')); 
		$router->post('updatePassWord', array('uses' => 'userController@updatePassWord')); 
		$router->post('forgotPassword', array('uses' => 'userController@forgotPassword')); 
		$router->post('doLogin', array('uses' => 'userController@doLogin'));
		$router->post('adminLogin', array('uses' => 'userController@adminLogin'));
		$router->post('generate_logins', array('uses' => 'userController@generate_logins')); 
	    $router->get('attendees', array('uses' => 'userController@showLogins')); 
	    $router->get('showAdmins', array('uses' => 'userController@showAdmins')); 
	    $router->post('updateUser/{id}', array('uses' => 'userController@update')); 
	    $router->get('user/{id}', array('uses' => 'userController@showUserData')); 
	    $router->post('follow', array('uses' => 'userController@followOrUnfollow')); 
	    $router->get('leaderboard', array('uses' => 'userController@leaderboard'));
        $router->post('update-leaderboard', array('uses' => 'LeaderBoardController@modifyLeaderBoard'));
        $router->post('get-leaderboard', array('uses' => 'LeaderBoardController@getLeaderboardScores'));
	    $router->post('pinPost', array('uses' => 'userController@pinPost')); 
	    $router->get('showNotifications', array('uses' => 'userController@showNotifications')); 
	    $router->get('notifyCount', array('uses' => 'userController@showNotificationsCount')); 
	    $router->get('updatenotification', array('uses' => 'userController@updatenotification')); 
	    $router->get('searchAttendee', array('uses' => 'userController@searchAttendee')); 
	    $router->get('export', array('uses' => 'userController@export'));
	    $router->post('import', array('uses' => 'userController@import'));
	    $router->post('color', array('uses' => 'userController@color'));
	    $router->delete('deletes', array('uses' => 'userController@deletes'));
	    $router->post('info', array('uses' => 'userController@info'));
	    $router->get('getinfo', array('uses' => 'userController@getinfo'));
	    $router->get('getColor', array('uses' => 'userController@getColor'));
	    $router->get('getLogo', array('uses' => 'userController@getLogo'));
	    $router->post('deleteAttendees', array('uses' => 'userController@deleteAttendees'));
 

	    //..........Create Post Routes 


		$router->post('post', array('uses' => 'postsController@store')); 
		$router->delete('post/{id}', array('uses' => 'postsController@destroy')); 
		$router->post('upload', array('uses' => 'postsController@uploadAttach')); 
		$router->post('like', array('uses' => 'postsController@like')); 
		$router->get('showlikes', array('uses' => 'postsController@showlikes')); 
		$router->get('post', array('uses' => 'postsController@showposts')); 
		$router->get('showposts222', array('uses' => 'postsController@showposts222')); 
		$router->post('comment', array('uses' => 'postsController@addCommentToPost')); 
		$router->post('likeToComment', array('uses' => 'postsController@likeToComment')); 
	    $router->get('adminPost', array('uses' => 'postsController@adminPost')); 
	    $router->get('showcomment', array('uses' => 'postsController@showcomment')); 
	    $router->get('singlePost', array('uses' => 'postsController@singlePost')); 
	    $router->get('AllpostForADmin', array('uses' => 'postsController@AllpostForADmin')); 
	    $router->get('Allposts', array('uses' => 'postsController@Allposts')); 
	    $router->get('showAttache', array('uses' => 'postsController@showAttache')); 

		//..........Create SPonsor Routes 

		$router->post('sponsor', array('uses' => 'sponsorsController@store')); 
		$router->get('sponsor/{id}', array('uses' => 'sponsorsController@getSponsor')); 
		$router->post('sponsor/{id}', array('uses' => 'sponsorsController@update')); 
		$router->delete('sponsor/{id}', array('uses' => 'sponsorsController@destroy')); 
		$router->get('sponsor', array('uses' => 'sponsorsController@show')); 
		$router->get('searchsponsor', array('uses' => 'sponsorsController@searchsponsor'));
        $router->get('schedules', array('uses' => 'sponsorsController@getSchedules'));
        $router->post('availability/status', array('uses' => 'sponsorsController@setAvailabilityStatus'));
        $router->get('availability/confirmed', array('uses' => 'sponsorsController@getConfirmedAttendee'));
        $router->get('availability/unconfirmed', array('uses' => 'sponsorsController@getUnConfirmedAttendee'));

        //Calendar Meeting Time Slots

        $router->get('get-timeslots', array('uses' => 'Meeting\AttendeeTimeSlotController@getTimeSlots'));

        //Attendee TimeSlot Management
        $router->get('available-timeslots', array('uses' => 'Meeting\AttendeeTimeSlotController@AvailTimeSlots'));
        $router->get('attendee-not-confirmed-ts', array('uses' => 'Meeting\AttendeeTimeSlotController@attendeeNotConfirmedTS'));
        $router->get('attendee-confirmed-ts', array('uses' => 'Meeting\AttendeeTimeSlotController@attendeeConfirmedTS'));
        $router->post('attendee-request-ts', array('uses' => 'Meeting\AttendeeTimeSlotController@attendeeRequestTS'));
        $router->get('attendee-cancelled-ts', array('uses' => 'Meeting\AttendeeTimeSlotController@attendeeCancelledTS'));
        $router->get('fetch-attendee-requests', array('uses' => 'Meeting\AttendeeTimeSlotController@fetchAttendeeRequests'));
        $router->get('attendee-meeting-confirmed', array('uses' => 'Meeting\AttendeeTimeSlotController@fetchMeetingConfirmed'));
        $router->post('attendee-response', array('uses' => 'Meeting\AttendeeTimeSlotController@AttendeeRequestResponse'));

        //Sponsor TimeSlot Management
        $router->get('sponsor-available-ts', array('uses' => 'Meeting\SponsorTimeSlotController@SponsorAvailTimeSlots'));
        $router->get('sponsor-not-confirmed-ts', array('uses' => 'Meeting\SponsorTimeSlotController@sponsorNotConfirmedTS'));
        $router->get('sponsor-confirmed-ts', array('uses' => 'Meeting\SponsorTimeSlotController@sponsorConfirmedTS'));
        $router->post('sponsor-request-ts', array('uses' => 'Meeting\SponsorTimeSlotController@sponsorRequestTS'));
        $router->get('sponsor-cancelled-ts', array('uses' => 'Meeting\SponsorTimeSlotController@SponsorCancelledTS'));
        $router->get('fetch-sponsor-requests', array('uses' => 'Meeting\SponsorTimeSlotController@fetchSponsorRequests'));
        $router->post('sponsor-response', array('uses' => 'Meeting\SponsorTimeSlotController@SponsorRequestResponse'));
        $router->get('sponsor-meeting-confirmed', array('uses' => 'Meeting\SponsorTimeSlotController@fetchMeetingConfirmed'));


			//..........Create Speaker Routes 

		$router->post('speaker', array('uses' => 'speakerController@store')); 
		$router->post('importSpeakerCSV', array('uses' => 'speakerController@importSpeakerCSV')); 
		$router->get('speaker/{id}', array('uses' => 'speakerController@getSpeaker')); 
		$router->post('speaker/{id}', array('uses' => 'speakerController@update')); 
		$router->delete('speaker/{id}', array('uses' => 'speakerController@destroy')); 
		$router->get('speaker', array('uses' => 'speakerController@show')); 
		$router->get('searchSpeaker', array('uses' => 'speakerController@searchSpeaker')); 
	     

			//..........Create Speakers Session Routes 

		$router->post('speakersession', array('uses' => 'speakerController@storespeakerSession'));  
		$router->post('speakersession/{id}', array('uses' => 'speakerController@updatespeakerSession')); 
		$router->delete('speakersession/{id}', array('uses' => 'speakerController@destroyspeakerSession'));  
	     


			//..........Create Speakers Session Routes 

		 // $router->post('storespeakerSessiondoc', array('uses' => 'speakerController@storespeakerSessiondoc'));  
		// $router->post('speakersession/{id}', array('uses' => 'speakerController@updatespeakerSession')); 
		$router->delete('destroyspeakerSessiondoc/{id}', array('uses' => 'speakerController@destroyspeakerSessiondoc'));  
	     
			//..........Create messages Routes 

		$router->post('message', array('uses' => 'messagesController@store')); 
		$router->get('getConv', array('uses' => 'messagesController@getConv')); 
		$router->get('showMessageCount', array('uses' => 'messagesController@showMessageCount')); 
		// $router->post('message/{id}', array('uses' => 'messagesController@update')); 
		// $router->delete('message/{id}', array('uses' => 'messagesController@destroy')); 
		$router->get('message', array('uses' => 'messagesController@show')); 
	       
			//.......... agenda Routes 

		$router->post('notifyUsers', array('uses' => 'agendaController@notifyUsers'));
		$router->post('addSession', array('uses' => 'agendaController@addSession'));
		$router->post('importSessionCSV', array('uses' => 'agendaController@importSessionCSV'));
		$router->post('addSessionDoc', array('uses' => 'agendaController@addSessionDoc')); 
		$router->delete('destroysessionData/{id}', array('uses' => 'agendaController@destroysessionData'));
		$router->post('editSession/{id}', array('uses' => 'agendaController@editSession'));
		$router->get('session', array('uses' => 'agendaController@getSession'));
		$router->get('session/{id}', array('uses' => 'agendaController@getSingleSession'));

        $router->get('linkedin', function () {
            return view('linkedin');
        });
        $router->get('note/{session_id}/{uid}', 'NotesController@getNotes');
        $router->post('create/note', 'NotesController@createNotes');
        $router->post('note/update', 'NotesController@updateNote');

    $router->get('/', function () {
        return view('linkedin');
    });
    $router->get('/redirect/{provider}', 'socialcontroller@redirect');
	$router->get('/callback/{provider}', 'socialcontroller@callback');
	

	//SignUp
	$router->get('/signup', 'SignUpController@signUpStart');

