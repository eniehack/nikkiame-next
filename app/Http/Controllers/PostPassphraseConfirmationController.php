<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Post;
use App\Models\PostPassphrase;
use \DateTime;

class PostPassphraseConfirmationController extends Controller
{
    public function get(Request $request, Post $post){
        return view('post/passphrase_confirm', ['post_id' => $post -> id]);
    }

    public function post(Request $request){
        $hidden_post_id = $request->string('post_id');
        $true_passphrase = PostPassphrase::find($hidden_post_id);
        if (!Hash::check( $request->string('passphrase') , $true_passphrase->passphrase )){
            return response("Not Found", 404);
        }
        session()->put(($hidden_post_id).'_access_allowed', (new DateTime())->format(DATE_ATOM));
        return redirect()->action([PostController::class, 'show'], ["post" => $hidden_post_id]);
    }
}
