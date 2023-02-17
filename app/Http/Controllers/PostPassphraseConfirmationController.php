<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Post;
use App\Models\User;
use App\Models\PostPassphrase;
use \DateTime;

class PostPassphraseConfirmationController extends Controller
{
    public function get(Request $request, User $user, Post $post){
        return view('post/passphrase_confirm', ['post_id' => $post -> id, "user_id" => $user->user_id]);
    }

    public function post(Request $request, User $user){
        $hidden_post_id = $request->string('post_id');
        $true_passphrase = PostPassphrase::find($hidden_post_id);
        if (!Hash::check( $request->string('passphrase') , $true_passphrase->passphrase )){
            return response("Not Found", 404);
        }
        session()->put(($hidden_post_id).'_access_allowed', (new DateTime())->format(DATE_ATOM));
        return redirect()->action([PostController::class, 'show'], ["post" => $hidden_post_id, "user" => $user->user_id]);
    }
}
