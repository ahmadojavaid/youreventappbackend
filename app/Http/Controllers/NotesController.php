<?php


namespace App\Http\Controllers;


use App\SessionNote;
use App\Sessions;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Mail;

class NotesController extends Controller
{

     public function getNotes($session_id, $uid){

         $data = SessionNote::where('session_id', $session_id)->where('user_id', $uid)->first();
         if (!$data){
             return response()->json(['Message' => 'No data found', 'statusCode'=>0]);
         }
         else{
             return response()->json(['Message' => 'Data found', 'statusCode' => 1, 'data' => $data]);
         }
     }

     public function createNotes(Request $request){
         try {
             $note = SessionNote::where('user_id', $request->user_id)->where('session_id', $request->session_id)->first();
             if ($note) {
                 $note->note_body = $request->body;
                 $note->updated_at = Carbon::now();
                 $note->update();
             } else {
                 $note = new SessionNote();
                 $note->note_body = $request->body;
                 $note->user_id = $request->user_id;
                 $session = Sessions::find($request->session_id);
                 $session->note()->save($note);
             }
             $user = User::where('id', $request->user_id)->select('email')->first();
             if ($user) {
                 Mail::send('notes', ["data" => $note], function ($message) use ($user) {
                     $message->from('info@yea.com', 'EventApp');
                     $message->to($user->email, 'You saved the notes')->subject('Your Saved Notes');
                 });
             }
             return response()->json(['Message' => 'Data Added successfully successfully', 'statusCode' => 1, 'data' => $note]);
         }catch (Exception $exception){
             return response()->json(['Message' => $exception->getMessage(), 'statusCode' => 0]);
         }
     }
     public function updateNote(Request $request){
        $note =  SessionNote::find($request->id);
        $note->note_body = $request->body;
        $note->save();
     }
}