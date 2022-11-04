<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Ulid\Ulid;


class SignupController extends Controller
{
    public function get(){
        return view('signup');
    }
    public function post(Request $request){
        $validator = Validator::make($request->all(), [
            "name" => ["required","max:20"],
            "uid" => ["required","max:15","min:1","regex:/^[0-9a-z._]+$/","unique:App\Models\User,user_id"],
            "pass" => ["required","min:8"]
        ]);

        if ($validator->fails()) {
            return redirect('/signup')->withErrors($validator)->withInput();
        }

        $name=$request->string('name');
        $pass=$request->string('pass');
        $uid=$request->string('uid');

        $user = new User;

        $user->name = $name;
        $user->password = Hash::make($pass);
        $user->user_id = $uid;
        $user->ulid = (string) Ulid::generate();
        $user->save();

        return redirect('/signin');
    }
}
