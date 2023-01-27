<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SigninController extends Controller
{
    public function get(){
        return view('signin');
    }

    public function post(Request $request){

        $validator = Validator::make($request->all(), [
            "uid" => ["required"],
            "pass" => ["required"]
        ]);

        if ($validator->fails()) {
            return redirect('/signin')->withErrors($validator)->withInput();
        }
        $pass=$request->string('pass');
        $uid=$request->string('uid');

        if (Auth::attempt(['user_id' => $uid, 'password' => $pass])) {
            // Authentication was successful...
            $request->session()->regenerate();
            $request->session()->put('uid',$uid);

            $user = User::where('user_id', $uid)->first();
            $request->session()->put('name',$user->name);
            $request->session()->put('ulid',$user->ulid);


            return redirect('/');
        }else{
            return redirect('/signin')->withErrors([
                    'pass' => ['The provided password does not match our records.']
                ])->withInput();
        }
    }
}
