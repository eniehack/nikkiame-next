<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Ulid\Ulid;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/

Route::get('/signup', function () {
    return view('signup');
});

// name: required, max(20)
// pass: required, minlength
// uid: user_id, unique, max(15), min(1)
Route::post('/signup', function(Request $request) {

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
    //$user->password = password_hash($pass, PASSWORD_ARGON2ID, ['memory_cost' => 65536, 'time_cost' => 4, 'threads' => 1]);
    $user->user_id = $uid;
    $user->ulid = (string) Ulid::generate();
    $user->save();

    return response('Hello World', 201)
        ->header('Content-Type', 'text/plain');
});

Route::get('/signin',function(){
    return view('signin');
});

Route::post('/signin',function(Request $request){

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
});

Route::get('/', function(Request $request){
    if($request->session()->has('name')) {
        return view('timeline', ['name' => $request->session()->get('name')]);
    } else{
        return view('welcome');
    }

});

 //https://laravel.com/docs/9.x/authentication#password-confirmation-routing
