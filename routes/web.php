<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Post;
use App\Http\Controllers\SignupController;
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

Route::get('/signup',[SignupController::class,'get'] );
Route::post('/signup',[SignupController::class,'post'] );

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
Route::get('/post',function(Request $request){
    if($request->session()->has('name')) {
        return view('post');
    } else{
        return redirect('/signin');
    }
});

Route::post('/post', function(Request $request){
    if(!$request->session()->has('name')){
        return redirect('/signin');
    }
    $validator = Validator::make($request->all(), [
        "content" => ["required"],
    ]);
    if($validator -> fails()){
        return redirect('/post')->withErrors($validator)->withInput();
    }

    $post = new Post();
    if( ! $request->filled("title")) {
        $now = new DateTime();
        $post->title = $now->format("Y-m-d");
    } else {
        $post->title = $request->string('title');
    }
    $post->content = $request->string('content');
    $post->author = $request->session()->get('ulid');;
    $post->id = (string) Ulid::generate();;
    $post->is_draft = false;
    $post->scope = 0;
    $post->save();
    return response('Created', 201)
    ->header('Content-Type', 'text/plain');
});
