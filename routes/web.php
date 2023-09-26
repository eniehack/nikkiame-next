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
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\InvitationController;

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

Route::get('/signup',[SignupController::class,'get'] )->name('signup.get');
Route::post('/signup',[SignupController::class,'post'] );

Route::get('/signin',[SigninController::class,'get'] )->name('signin.get');
Route::post('/signin',[SigninController::class,'post']);

Route::get('/posts/new',[PostController::class,'create'])->name('posts.create');
Route::get('/@{user:user_id}/p/{post}',[PostController::class,'show'])->name('posts.show');
Route::get('/@{user:user_id}/p/{post}/edit',[PostController::class,'edit'])->name('posts.edit');
Route::post('/posts/new',[PostController::class,'store'])->name('posts.store');
Route::put('/@{user:user_id}/p/{post}/edit',[PostController::class,'update'])->name('posts.update');
Route::delete('/@{user:user_id}/p/{post}/',[PostController::class,'destroy'])->name('posts.destroy');

Route::get('/@{user:user_id}/p/{post}/pass_phrase',[PostPassphraseConfirmationController::class,'get'] )->name('post.passphrase.get');
Route::post('/@{user:user_id}/p/{post}/pass_phrase',[PostPassphraseConfirmationController::class,'post'])->name('post.passphrase.post');

Route::get('/', function(Request $request){
    if($request->session()->has('name')) {
        return view('timeline', ['name' => $request->session()->get('name')]);
    } else{
        return view('welcome');
    }

});

Route::get('/@{user:user_id}',[UserProfileController::class,'get'])->name("user.profile");
Route::get('/admin/invitation',[InvitationController::class,'get']);
