<?php

namespace App\Http\Controllers;

use App\User;
use App\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\CustomData\Utilclass;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use CloudConvert;
use DB;

class linkRespo
{
    public $link;

    public function test()
    {
        var_dump(get_object_vars($this));
    }
}

class postsController extends Controller
{
    //   public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    //..........Posts


    public function store(Request $request)
    {

        $Posts = new Posts();
        $rules = [
            'userId' => 'required',
            // 'postDescription' => 'required',   
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => [$validator->errors()->all()],
                'data' => null,
            ], 400);
        }

        $Posts = $Posts->create($request->except(['postLikesCount', 'postCommentsCount', 'postSharesCount']));

        if ($Posts->postMediaType == 'text') {
            DB::table('users')->where('id', $request->userId)->update(['points' => DB::raw('points + 1')]);
        }
        if ($Posts->postMediaType == 'text' && $Posts->postMediaType == 'image') {
            DB::table('users')->where('id', $request->userId)->update(['points' => DB::raw('points + 5')]);
        }
        if ($Posts->postMediaType == 'image') {
            DB::table('users')->where('id', $request->userId)->update(['points' => DB::raw('points + 2')]);
        }
        if ($Posts->postMediaType == 'video') {
            DB::table('users')->where('id', $request->userId)->update(['points' => DB::raw('points + 10')]);
        }
        $string = trim($request->attachmentURL, ".");

        $split = explode(",", $string);

        for ($i = 0; $i < count($split); $i++) {

            $temp = array("postId" => $Posts->id, "attachmentURL" => $split[$i]);

            $lists = DB::table('post_attachements')->insertGetId($temp);
        }

        DB::table('users')->where('id', $request->userId)->update(['postCount' => DB::raw('postCount + 1')]);

        $checkRole = DB::table('users')
            ->where('id', $request->userId)
            ->pluck('role')
            ->first();

        if ($checkRole == 1) {

            $temp = array("userId" => $request->userId, "postId" => $Posts->id, "notificationTitle" => 'Agenda Update', "notificationType" => '1', "notificationData" => 'Announcements/notifications from the organisers, Please check the latest Agenda Update');

            $lists = DB::table('notifications')->insertGetId($temp);
        }
        return response()->json(['statusCode' => '1', 'statusMessage' => 'Posts Successfully Created', 'Result' => $Posts]);
    }

    public function update($id, Request $request)
    {
        $Posts = Posts::find($id);

        if (!$Posts) {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Record Not Found', 'Result' => NULL]);
        }
        $Posts->update($request->except(['postLikesCount', 'postCommentsCount', 'postSharesCount']));

        return response()->json(['statusCode' => '1', 'statusMessage' => 'Posts Successfully Updated', 'Result' => $Posts]);
    }

    public function destroy($id, Request $request)
    {
        $Category = Posts::find($id);

        if (!$Category) {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Record Not Found', 'Result' => NULL]);
        }
        $Category->delete();
        DB::table('post_attachements')->where('postId', $id)->delete();
        DB::table('post_comments')->where('postId', $id)->delete();
        DB::table('post_likes')->where('postId', $id)->delete();

        return response()->json(['statusCode' => '1', 'statusMessage' => 'Post deleted', 'Result' => NULL]);
    }

    public function uploadAttach(Request $request)
    {
        try {

            if ($request->has('attachmentURL')) {

                $unique = bin2hex(openssl_random_pseudo_bytes(35));

                $format = '.png';

                $entityBody = $request['attachmentURL'];// file_get_contents('php://input');

                $imageName = time() . '-' . $format;

                $directory = "/images/postImages/";

                $path = base_path() . "/public" . $directory;

                $data = base64_decode($entityBody);

                file_put_contents($path . $imageName, $data);

                $response = $directory . $imageName;

                return response()->json(['statusCode' => '1', 'statusMessage' => 'url of uploaded file', 'url' => $response]);

                // return $response; 
            }

            if ($request->has('videoURL')) {

                $extension = $request->file('videoURL')->getClientOriginalExtension();

                $photo = time() . '-' . $request->file('videoURL')->getClientOriginalName();

                $temp = explode('.', $photo);
                $ext = array_pop($temp);
                $name = implode('.mp4', $temp);

                $ext = '.mp4';

                $destination = 'api/public/uploads/';

                $path = $request->file('videoURL')->move($destination, $photo . '.' . $ext);

                return response()->json(['statusCode' => '1', 'statusMessage' => 'url of uploaded file', 'url' => $destination . '' . $photo . '' . $ext]);

            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'data' => null,
            ], 400);
        }

    }

    public function like()
    {

        $userId = Input::get("userId");
        $postId = Input::get("postId");

        $Posts = DB::table('post_likes')
            ->where('userId', $userId)
            ->where('postId', $postId)
            ->first();


        if ($Posts) {

            DB::table('post_likes')->where('userId', $userId)->where('postId', $postId)->delete();

            DB::table('notifications')->where('actionedBy', $userId)->where('postId', $postId)->delete();

            DB::table('posts')->where('id', $postId)->update(['postLikesCount' => DB::raw('postLikesCount - 1')]);

            return response()->json(['statusCode' => '1', 'statusMessage' => 'successfully unliked the post', 'Result' => NULL]);

        } else {

            $temp = array("userId" => $userId, "postId" => $postId);

            $lists = DB::table('post_likes')->insertGetId($temp);

            DB::table('posts')->where('id', $postId)->update(['postLikesCount' => DB::raw('postLikesCount + 1')]);

            $postDoneBy = DB::table('posts')
                // ->where('userId',$userId)
                ->where('posts.id', '=', $postId)
                ->join('users', 'users.id', '=', 'posts.userId')
                ->select('users.name', 'users.id', 'users.deviceType')
                ->first();


            $getprofileImageofCommentor = DB::table('users')
                // ->where('userId',$userId)
                ->where('id', '=', $userId)
                ->select('users.name', 'users.id', 'users.profileImage')
                ->first();


            $postlikedBy = DB::table('post_likes')
                // ->where('userId',$userId)
                ->where('post_likes.postId', '=', $postId)
                ->join('users', 'users.id', '=', 'post_likes.userId')
                ->first();
            // return $postId;

            $temp = array(
                "actionedBy" => $getprofileImageofCommentor->id,
                "userId" => $postDoneBy->id,
                "imageUrl" => $getprofileImageofCommentor->profileImage,
                "notificationTitle" => $getprofileImageofCommentor->name,
                "notificationType" => '2', "postId" => $postId,
                "notificationData" => 'Liked your post');

            $lists = DB::table('notifications')->insertGetId($temp);

            //......Send Notification
            if ($postDoneBy->id == $getprofileImageofCommentor->id) {
                // return 'ssss';
                return response()->json(['statusCode' => '1', 'statusMessage' => 'successfully liked the post', 'Result' => NULL]);
            }


            $util = new Utilclass();
            $title = $getprofileImageofCommentor->name;
            $body = 'Liked your post';
            $userID = $postDoneBy->id;

            if ($postDoneBy->deviceType == 1) {
                $util->sendPushNotification($userID, $title, $body);
            }


            if ($postDoneBy->deviceType == 2) {
                $util->sendPushNotificationAdnroid($userID, $title, $body);
            }

            $util->sendPushNotification($userID, $title, $body);

            //   $bb =  array("notificationType" => 2, "postId" =>$postId, "title" =>'YEA',"message" =>$getprofileImageofCommentor->name.''.' Liked your post');

            //  $util = new Utilclass();

            //   $title ='YEA';
            //   $body = $bb;
            //   $userID =$postDoneBy->id;

            //  $util->sendPushNotification($userID,$title,$body);   

            return response()->json(['statusCode' => '1', 'statusMessage' => 'successfully liked the post', 'Result' => NULL]);
        }
    }

    public function showlikes()
    {
        $postId = Input::get("postId");


        $post_likes = DB::table('post_likes')
            ->where('postId', $postId)
            ->join('users', 'users.id', '=', 'post_likes.userId')
            ->select('users.name', 'users.profileImage', 'users.role', 'users.contact', 'users.jobTitle', 'users.companyName', 'users.email', 'post_likes.*')
            ->get();

        return response()->json(['statusCode' => '1', 'statusMessage' => 'successfully liked the post', 'Result' => $post_likes]);

    }

    public function showposts()
    {


        $userId = Input::get("userId");


        //.......................To get pinned post

        $users = DB::table('users')
            // ->where('userId',$userId)
            ->where('id', $userId)
            ->pluck('pinnedPostId')
            ->first();
        // return $users;

        if ($users) {

            $Posts = new Posts();

            $pinned = $Posts->pinned($users);

            for ($i = 0; $i < count($pinned); $i++) {

                $liked = DB::table('post_likes')
                    ->where('userId', '=', $userId)
                    ->where('postId', '=', $pinned[$i]->id)
                    ->first();

                if ($liked) {
                    $pinned[$i]->{'isLiked'} = 1;
                } else
                    $pinned[$i]->{'isLiked'} = 0;
            }

            for ($i = 0; $i < count($pinned); $i++) {

                for ($j = 0; $j < count($pinned[$i]->comments); $j++) {
                    // return $return[$j]->id;
                    $liked = DB::table('post_comment_likes')
                        ->where('userId', '=', $userId)
                        ->where('commentId', '=', $pinned[$i]->comments[$j]->id)
                        ->first();
                    // return $liked;
                    if ($liked) {

                        $pinned[$i]->comments[$j]->{'isLikedTheComment'} = 1;
                    } else
                        $pinned[$i]->comments[$j]->{'isLikedTheComment'} = 0;
                }
            }

            //... to show all post followed by the users or the user itself following


            $followersPosts = DB::table('followers')
                // ->where('userId',$userId)
                ->where('userId', $userId)
                ->pluck('followerId');
            // ->get();


            $Posts = new Posts();

            $return = $Posts->post($followersPosts, $userId, $users);

            // return $return[0]->comments[0]->id;

            for ($i = 0; $i < count($return); $i++) {

                for ($j = 0; $j < count($return[$i]->comments); $j++) {
                    // return $return[$j]->id;
                    $liked = DB::table('post_comment_likes')
                        ->where('userId', '=', $userId)
                        ->where('commentId', '=', $return[$i]->comments[$j]->id)
                        ->first();
                    // return $liked;
                    if ($liked) {

                        $return[$i]->comments[$j]->{'isLikedTheComment'} = 1;
                    } else
                        $return[$i]->comments[$j]->{'isLikedTheComment'} = 0;
                }
            }

            for ($i = 0; $i < count($return); $i++) {

                $liked = DB::table('post_likes')
                    ->where('userId', '=', $userId)
                    ->where('postId', '=', $return[$i]->id)
                    ->first();

                if ($liked) {

                    $return[$i]->{'isLiked'} = 1;
                } else
                    $return[$i]->{'isLiked'} = 0;
            }

            for ($i = 0; $i < count($return); $i++) {

                for ($j = 0; $j < count($return[$i]->comments); $j++) {
                    // return $return[$j]->id;
                    $liked = DB::table('post_comment_likes')
                        ->where('userId', '=', $userId)
                        ->where('commentId', '=', $return[$i]->comments[$j]->id)
                        ->first();
                    // return $liked;
                    if ($liked) {

                        $return[$i]->comments[$j]->{'isLikedTheComment'} = 1;
                    } else
                        $return[$i]->comments[$j]->{'isLikedTheComment'} = 0;
                }
            }
            return response()->json(['statusCode' => '1', 'statusMessage' => 'successfully showing the post', 'Result' => $return, 'pinned' => $pinned]);
        } else {
            //... to show all post followed by the users or the user itself following

            $followersPosts = DB::table('followers')
                // ->where('userId',$userId)
                ->where('userId', $userId)
                ->pluck('followerId');
            // ->get();

            $Posts = new Posts();

            $return = $Posts->post($followersPosts, $userId,$users);

            for ($i = 0; $i < count($return); $i++) {

                $liked = DB::table('post_likes')
                    ->where('userId', '=', $userId)
                    ->where('postId', '=', $return[$i]->id)
                    ->first();

                // return json_encode($liked);

                if ($liked) {
                    // return $rating[1];
                    $return[$i]->{'isLiked'} = 1;
                } else
                    $return[$i]->{'isLiked'} = 0;
            }

            for ($i = 0; $i < count($return); $i++) {

                for ($j = 0; $j < count($return[$i]->comments); $j++) {
                    // return $return[$j]->id;
                    $liked = DB::table('post_comment_likes')
                        ->where('userId', '=', $userId)
                        ->where('commentId', '=', $return[$i]->comments[$j]->id)
                        ->first();
                    // return $liked;
                    if ($liked) {

                        $return[$i]->comments[$j]->{'isLikedTheComment'} = 1;
                    } else
                        $return[$i]->comments[$j]->{'isLikedTheComment'} = 0;
                }
            }
            return response()->json(['statusCode' => '1', 'statusMessage' => 'successfully showing the post', 'Result' => $return, 'pinned' => []]);
        }
    }


    //.........reversing the above content for comments

    public function showposts222()
    {
        $userId = Input::get("userId");


        //.......................To get pinned post

        $users = DB::table('users')
            // ->where('userId',$userId)
            ->where('id', $userId)
            ->pluck('pinnedPostId')
            ->first();

        if ($users) {

            $Posts = new Posts();

            $pinned = $Posts->pinned1($users);

            for ($i = 0; $i < count($pinned); $i++) {

                $liked = DB::table('post_likes')
                    ->where('userId', '=', $pinned[$i]->userId)
                    ->where('postId', '=', $pinned[$i]->id)
                    ->first();

                if ($liked) {
                    $pinned[$i]->{'isLiked'} = 1;
                } else
                    $pinned[$i]->{'isLiked'} = 0;
            }

            for ($i = 0; $i < count($pinned); $i++) {

                for ($j = 0; $j < count($pinned[$i]->comments); $j++) {
                    // return $return[$j]->id;
                    $liked = DB::table('post_comment_likes')
                        ->where('userId', '=', $userId)
                        ->where('commentId', '=', $pinned[$i]->comments[$j]->id)
                        ->first();
                    // return $liked;
                    if ($liked) {

                        $pinned[$i]->comments[$j]->{'isLikedTheComment'} = 1;
                    } else
                        $pinned[$i]->comments[$j]->{'isLikedTheComment'} = 0;
                }
            }

            //... to show all post followed by the users or the user itself following

            $followersPosts = DB::table('followers')
                // ->where('userId',$userId)
                ->where('userId', $userId)
                ->pluck('followerId');
            // ->get();

            $Posts = new Posts();

            $return = $Posts->post1($followersPosts, $userId);

            // return $return[0]->comments[0]->id;

            for ($i = 0; $i < count($return); $i++) {

                for ($j = 0; $j < count($return[$i]->comments); $j++) {
                    // return $return[$j]->id;
                    $liked = DB::table('post_comment_likes')
                        ->where('userId', '=', $userId)
                        ->where('commentId', '=', $return[$i]->comments[$j]->id)
                        ->first();
                    // return $liked;
                    if ($liked) {

                        $return[$i]->comments[$j]->{'isLikedTheComment'} = 1;
                    } else
                        $return[$i]->comments[$j]->{'isLikedTheComment'} = 0;
                }
            }

            for ($i = 0; $i < count($return); $i++) {

                $liked = DB::table('post_likes')
                    ->where('userId', '=', $return[$i]->userId)
                    ->where('postId', '=', $return[$i]->id)
                    ->first();

                if ($liked) {

                    $return[$i]->{'isLiked'} = 1;
                } else
                    $return[$i]->{'isLiked'} = 0;
            }

            for ($i = 0; $i < count($return); $i++) {

                for ($j = 0; $j < count($return[$i]->comments); $j++) {
                    // return $return[$j]->id;
                    $liked = DB::table('post_comment_likes')
                        ->where('userId', '=', $userId)
                        ->where('commentId', '=', $return[$i]->comments[$j]->id)
                        ->first();
                    // return $liked;
                    if ($liked) {

                        $return[$i]->comments[$j]->{'isLikedTheComment'} = 1;
                    } else
                        $return[$i]->comments[$j]->{'isLikedTheComment'} = 0;
                }
            }
            return response()->json(['statusCode' => '1', 'statusMessage' => 'successfully liked the post', 'Result' => $return, 'pinned' => $pinned]);
        } else {

            //... to show all post followed by the users or the user itself following

            $followersPosts = DB::table('followers')
                // ->where('userId',$userId)
                ->where('userId', $userId)
                ->pluck('followerId');
            // ->get();

            $Posts = new Posts();

            $return = $Posts->post1($followersPosts, $userId);

            for ($i = 0; $i < count($return); $i++) {

                $liked = DB::table('post_likes')
                    ->where('userId', '=', $return[$i]->userId)
                    ->where('postId', '=', $return[$i]->id)
                    ->first();

                // return json_encode($liked);

                if ($liked) {
                    // return $rating[1];
                    $return[$i]->{'isLiked'} = 1;
                } else
                    $return[$i]->{'isLiked'} = 0;
            }

            for ($i = 0; $i < count($return); $i++) {

                for ($j = 0; $j < count($return[$i]->comments); $j++) {
                    // return $return[$j]->id;
                    $liked = DB::table('post_comment_likes')
                        ->where('userId', '=', $userId)
                        ->where('commentId', '=', $return[$i]->comments[$j]->id)
                        ->first();
                    // return $liked;
                    if ($liked) {

                        $return[$i]->comments[$j]->{'isLikedTheComment'} = 1;
                    } else
                        $return[$i]->comments[$j]->{'isLikedTheComment'} = 0;
                }
            }


            return response()->json(['statusCode' => '1', 'statusMessage' => 'successfully liked the post', 'Result' => $return, 'pinned' => []]);
        }
    }

    public function addCommentToPost(Request $request)
    {

        $userId = Input::get("userId");
        $postId = Input::get("postId");
        $comment = Input::get("comment");


        // doing it because whneever the comment is done on the post its created_at changes , so before moving further hold its last time and updating at the end of this function

        $postsTimeStamp = DB::table('posts')
            ->where('posts.id', '=', $postId)
            ->pluck('posts.created_at')
            ->first();
        //return json_encode($postsTimeStamp);


        $temp = array("postId" => $postId, "userId" => $userId, "comment" => $comment);

        $lists = DB::table('post_comments')->insertGetId($temp);

        DB::table('posts')->where('id', $postId)->update(['postCommentsCount' => DB::raw('postCommentsCount + 1')]);

        $postDoneBy = DB::table('posts')
            // ->where('userId',$userId)
            ->where('posts.id', '=', $postId)
            ->join('users', 'users.id', '=', 'posts.userId')
            ->select('users.name', 'users.id', 'users.profileImage', 'users.deviceType')
            ->first();

        $getprofileImageofCommentor = DB::table('users')
            // ->where('userId',$userId)
            ->where('id', '=', $userId)
            ->select('users.name', 'users.id', 'users.profileImage')
            ->first();

        $postcommentedBy = DB::table('post_comments')
            // ->where('userId',$userId)
            ->where('post_comments.postId', '=', $postId)
            ->join('users', 'users.id', '=', 'post_comments.userId')
            ->first();


        $util = new Utilclass();
        $title = $getprofileImageofCommentor->name;
        $body = $getprofileImageofCommentor->name . 'commented on your post';
        $userID = $postDoneBy->id;


        if ($postDoneBy->id == $getprofileImageofCommentor->id) {

            return response()->json(['statusCode' => '1', 'statusMessage' => 'successfully commented the post', 'Result' => NULL]);
        }

        if ($postDoneBy->deviceType == 1) {
            $util->sendPushNotification($userID, $title, $body);
        }

        if ($postDoneBy->deviceType == 2) {
            $util->sendPushNotificationAdnroid($userID, $title, $body);
        }
        // $util->sendPushNotification($userID,$title,$body);
        // $util->sendPushNotificationAdnroid($userID,$title,$body);


        $temp = array("userId" => $postDoneBy->id, "actionedBy" => $getprofileImageofCommentor->id, "notificationTitle" => $getprofileImageofCommentor->name, "notificationType" => '3', "postId" => $postId, "notificationData" => 'commented on your post', "imageUrl" => $getprofileImageofCommentor->profileImage);

        $lists = DB::table('notifications')->insertGetId($temp);


        $getPostBack = DB::table('post_comments')
            ->where('userId', $userId)
            ->where('postId', $postId)
            ->first();


        // updating time back to when the post was created

        DB::table('posts')->where('id', $postId)->update(array('created_at' => $postsTimeStamp));

        DB::table('users')->where('id', $userId)->update(['points' => DB::raw('points + 3')]);


        return response()->json(['statusCode' => '1', 'statusMessage' => 'successfully commented the post', 'Result' => $getPostBack]);

    }

    public function singlePost()
    {

        $postId = Input::get("postId");
        $userId = Input::get("userId");

        $Posts = new Posts();

        $return = $Posts->singlepost($postId);

        for ($i = 0; $i < count($return); $i++) {

            $liked = DB::table('post_likes')
                ->where('userId', '=', $return[$i]->userId)
                ->where('postId', '=', $return[$i]->id)
                ->first();

            if ($liked) {
                // return $rating[1];
                $return[$i]->{'isLiked'} = 1;
            } else
                $return[$i]->{'isLiked'} = 0;
        }

        for ($i = 0; $i < count($return); $i++) {

            for ($j = 0; $j < count($return[$i]->comments); $j++) {
                // return $return[$j]->id;
                $liked = DB::table('post_comment_likes')
                    ->where('userId', '=', $userId)
                    ->where('commentId', '=', $return[$i]->comments[$j]->id)
                    ->first();
                // return $liked;
                if ($liked) {

                    $return[$i]->comments[$j]->{'isLikedTheComment'} = 1;
                } else
                    $return[$i]->comments[$j]->{'isLikedTheComment'} = 0;
            }
        }


        return response()->json(['statusCode' => '1', 'statusMessage' => 'successfully showing the post', 'Result' => $return]);

    }

    public function likeToComment()
    {
        $userId = Input::get("userId");
        $commentId = Input::get("commentId");

        $Posts = DB::table('post_comment_likes')
            ->where('userId', $userId)
            ->where('commentId', $commentId)
            ->first();
        if ($Posts) {

            DB::table('post_comment_likes')->where('userId', $userId)->where('commentId', $commentId)->delete();

            DB::table('post_comments')->where('id', $commentId)->update(['commentlikesCount' => DB::raw('commentlikesCount - 1')]);

            return response()->json(['statusCode' => '1', 'statusMessage' => 'successfully unliked the comment', 'Result' => NULL]);

        } else {

            $temp = array("userId" => $userId, "commentId" => $commentId);

            $lists = DB::table('post_comment_likes')->insertGetId($temp);

            DB::table('post_comments')->where('id', $commentId)->update(['commentlikesCount' => DB::raw('commentlikesCount + 1')]);


            $commentDoneBy = DB::table('post_comments')
                // ->where('userId',$userId)
                ->where('post_comments.id', '=', $commentId)
                ->join('users', 'users.id', '=', 'post_comments.userId')
                ->select('users.name', 'users.id', 'post_comments.postId', 'users.deviceType')
                ->first();

            // return json_encode($commentDoneBy);
            $commentlikedBy = DB::table('post_comment_likes')
                // ->where('userId',$userId)
                ->where('post_comment_likes.userId', '=', $userId)
                ->join('users', 'users.id', '=', 'post_comment_likes.userId')
                ->first();
            // return json_encode($commentlikedBy);
            // return json_encode($commentDoneBy);


            $temp = array(
                "userId" => $commentDoneBy->id,
                "postId" => $commentDoneBy->postId,
                "notificationTitle" => 'Like on your comment',
                "notificationType" => '4',
                "notificationData" => $commentlikedBy->name . ' Liked your comment');

            $lists = DB::table('notifications')->insertGetId($temp);

            //.......send push notification

            $bb = array("notificationType" => 4, "postId" => $commentDoneBy->postId, "commentId" => $commentId, "title" => 'YEA', "message" => $commentlikedBy->name . '' . ' Liked your comment');


            //......Send Notification

            $util = new Utilclass();
            $title = 'YEA';
            $body = $commentlikedBy->name . '' . ' Liked your comment';
            $userID = $commentDoneBy->id;

            if ($commentDoneBy->deviceType == 1) {
                $util->sendPushNotification($userID, $title, $body);
            }


            if ($commentDoneBy->deviceType == 2) {
                $util->sendPushNotificationAdnroid($userID, $title, $body);
            }

            // $util->sendPushNotification($userID,$title,$body);
            // $util->sendPushNotificationAdnroid($userID,$title,$body);

            // $util = new Utilclass();

            //  $title ='YEA';
            //  $body = $bb;
            //  $userID =$commentDoneBy->id;

            // $util->sendPushNotification($userID,$title,$body);

            DB::table('users')->where('id', $userId)->update(['points' => DB::raw('points + 2')]);

            return response()->json(['statusCode' => '1', 'statusMessage' => 'successfully liked the comment', 'Result' => NULL]);
        }
    }

    public function adminPost()
    {
        // ................ to get admin post

        $adminsPost = DB::table('users')
            // ->where('userId',$userId)
            ->where('users.role', '=', 1)
            ->join('posts', 'posts.userId', '=', 'users.id')
            ->get();

        return response()->json(['statusCode' => '1', 'statusMessage' => 'showing the admin posts', 'Result' => $adminsPost]);
    }


    public function showcomment()
    {
        $postId = Input::get("postId");
        $userId = Input::get("userId");

        $post_comments = DB::table('post_comments')
            ->where('postId', $postId)
            ->join('users', 'users.id', '=', 'post_comments.userId')
            ->select('users.name', 'users.profileImage', 'post_comments.*')
            ->get();
        // return $post_comments;
        for ($i = 0; $i < count($post_comments); $i++) {

            $liked = DB::table('post_comment_likes')
                ->where('userId', '=', $userId)
                ->where('commentId', '=', $post_comments[$i]->id)
                ->first();

            if ($liked) {

                $post_comments[$i]->{'isLikedTheComment'} = 1;
            } else
                $post_comments[$i]->{'isLikedTheComment'} = 0;
        }

        return response()->json(['statusCode' => '1', 'statusMessage' => 'showing post comments', 'Result' => $post_comments]);
    }


    public function AllpostForADmin()
    {
        $Posts = new Posts();

        $return = $Posts->AllpostForADmin();

        return response()->json(['statusCode' => '1', 'statusMessage' => 'showing post comments', 'Result' => $return]);
    }

    public function Allposts()
    {
        $Posts = new Posts();

        $return = $Posts->AllpostForADmin();

        return response()->json(['statusCode' => '1', 'statusMessage' => 'showing post comments', 'Result' => $return]);
    }

    public function showAttache()
    {
        $postId = Input::get("postId");

        $post_attachements = DB::table('post_attachements')
            ->where('post_attachements.postId', '=', $postId)
            ->get();

        return response()->json(['statusCode' => '1', 'statusMessage' => 'showing the attachement of the posts', 'Result' => $post_attachements]);
    }

} 