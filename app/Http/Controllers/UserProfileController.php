<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Enums\PostScope;

class UserProfileController extends Controller
{
    //
    public function get(Request $request, User $user){

        $user_all_posts = Post::where('author', $user->ulid);
        $requestedUser = $request->session()->get('ulid');

        if (!(isset($requestedUser) && ($user -> ulid == $requestedUser))){
            $user_all_posts = $user_all_posts->where([
                ['scope', PostScope::Public],
                ['is_draft', false],
            ]);
        }
        $user_all_posts = $user_all_posts->orderBy("created_at","desc")->get();

        return view ("user/userprofile",["user_all_posts" =>$user_all_posts, "user"=>$user]);
    }
}
