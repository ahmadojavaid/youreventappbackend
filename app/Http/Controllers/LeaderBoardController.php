<?php
/**
 * Created by PhpStorm.
 * User: JBBravo
 * Date: 08-Aug-19
 * Time: 5:14 PM
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Http\Request;

class LeaderBoardController extends Controller
{
    public function modifyLeaderBoard(Request $request){
        $validator = Validator::make($request->all(), [
            'text' => 'required',
            'text_image' => 'required',
            'image' => 'required',
            'video' => 'required',
            'like' => 'required',
            'comment' => 'required'
        ]);

        if ($validator->fails()) {

            //Getting error messages and sending them in response
            $errorMsg = $validator->messages();

            return response()->json(['statusCode' => '0', 'statusMessage' => 'Error! Params Missing', 'Result' => $errorMsg], 422);
        } else {
            DB::table('leaderboard_points')->where('id','=',1)
                ->insert([
                    "text" => $request->get('text'), "text_image" => $request->get('text_image'),
                    "image" => $request->get('image'), "video" => $request->get('video'),
                    "like" => $request->get('like'),"comment" => $request->get('comment')
                ]);
            return response()->json(['statusCode' => '1', 'statusMessage' => 'Updated leaderboard points', 'Result' => null], 200);
        }
    }

    public function getLeaderboardScores(){
        $details = DB::table('leaderboard_points')->first();
        return response()->json(['statusCode' => '1', 'statusMessage' => 'Showing LeaderBoard List', 'Result' => $details], 200);
    }


}