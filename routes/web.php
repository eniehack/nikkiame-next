<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Post;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Hash;
use Ulid\Ulid;
use App\Http\Controllers\SigninController;
use App\Http\Controllers\PostPassphraseConfirmationController;

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

Route::get('/signin',[SigninController::class,'get'] );
Route::post('/signin',[SigninController::class,'post']);

Route::resource('posts', PostController::class)->only([
    'create', 'store','show','edit','update','destroy'
]);

Route::get('/posts/{post}/pass_phrase',[PostPassphraseConfirmationController::class,'get'] )->name('post.passphrase.get');
Route::post('/posts/{post}/pass_phrase',[PostPassphraseConfirmationController::class,'post'])->name('post.passphrase.post');

Route::get('/', function(Request $request){
    if($request->session()->has('name')) {
        return view('timeline', ['name' => $request->session()->get('name')]);
    } else{
        return view('welcome');
    }

});

