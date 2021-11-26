<?php


namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class socialcontroller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function callback($provider, Request $request)
    {
        try {
            return $request;
             dd(Socialite::driver($provider)->stateless()->user());
//            $linkdinUser = Socialite::driver('linkedin')->stateless()->user();
//            return $linkdinUser;
//            $existUser = User::where('email',$linkdinUser->email)->first();
//            if($existUser) {
//                Auth::loginUsingId($existUser->id);
//            }
//            else {
//                $user = new User;
//                $user->name = $linkdinUser->name;
//                $user->email = $linkdinUser->email;
//                $user->linkedin_id = $linkdinUser->id;
//                $user->password = md5(rand(1,10000));
//                $user->save();
//                Auth::loginUsingId($user->id);
//            }
//            return redirect()->to('/home');
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }
}