<?php

namespace App\Http\Controllers;

use App\Models\PostPassphrase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Models\Post;
use App\Models\User;
use App\Enums\PostScope;
use \DateTime;
use Ulid\Ulid;
use League\CommonMark\CommonMarkConverter;
use function PHPUnit\Framework\isFalse;
use function PHPUnit\Framework\returnArgument;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        if($request->session()->has('name')) {
            return view('post/create');
        } else{
            return redirect('/signin');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if (!$request->session()->has('name')) {
            return redirect('/signin');
        }
        $validator = Validator::make($request->all(), [
            "content" => ["required"],
            "scope" => ["required", "integer"],
        ]);
        if ($validator->fails()){
            return redirect('/posts/create')->withErrors($validator)->withInput();
        }

        $post = new Post();
        if ( ! $request->filled("title")) {
            $now = new DateTime();
            $post->title = $now->format("Y-m-d");
        } else {
            $post->title = $request->string('title');
        }
        $post_id = (string) Ulid::generate();
        $post->content = $request->string('content');
        $post->author = $request->session()->get('ulid');
        $post->id = $post_id;
        $post->is_draft = false;
        $post->scope = $request->enum("scope", PostScope::class);
        $post->save();

        if (PostScope::Private === $request->enum("scope", PostScope::class)) {
            $privatepost_validator = Validator::make($request->all(), [
                "pass_phrase" => ["required", "min:8", "regex:/^[a-zA-Z0-9\#\&\:\;\$\%\@\^\`\~\\\.\,\|\-\_\<\>\*\+\!\?\=\{\}\(\)\[\]\"\'\ ]+$/"],
            ]);
            if ($privatepost_validator->fails()){
                return redirect('/posts/create')->withErrors($privatepost_validator)->withInput();
            }

            $post_passphrase = new PostPassphrase();
            $post_passphrase->post_id = $post_id;
            $post_passphrase->passphrase = Hash::make($request->string("pass_phrase"));
            $post_passphrase->save();
        }

        return Redirect::route("posts.show", ["post" => $post_id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Post $post) {
        $requestedUser = $request->session()->get('ulid');
        $converter = new CommonMarkConverter();
        $author = User::find($post->author);
        $editButtonFlag = false;
        if(isset($requestedUser) && ($author -> ulid == $requestedUser)){
            $editButtonFlag = true;
        }
        if (! $editButtonFlag) {
            if(!($request->session()->has(($post->id).'_access_allowed'))) {
                return redirect()->route("post.passphrase.get" , ["post" => $post -> id]);
            }
        }

        /*
        return view('post/show',['title' => $post -> title ,
                                'content' => $post -> content ,
                                'created_at' => $post -> created_at ,
                                'updated_at' => $post -> updated_at ,
                                'author' => $author,
                                'converter' => $converter,
                                'editButtonFlag' => $editButtonFlag
                            ]);
                            */
        return view ('post/show', ['post' => $post,
                                    'converter' => $converter,
                                    'editButtonFlag' => $editButtonFlag]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Post $post) {
        if ($request->session()->has('ulid')) {
            $requested_ulid = $request->session()->get('ulid');
            if (isset($requested_ulid)&&($requested_ulid == $post->user->ulid)){
                return view('post/edit',['title' => $post -> title ,
                                'content' => $post -> content ,
                                'post_id' => $post -> id,
                            ]);
                    }else{
                        return response("forbidden",403);
                    }

        }else{
            return response("forbidden",403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post) {

        if ($request->session()->has('ulid')) {

            $requested_ulid = $request->session()->get('ulid');
            if (isset($requested_ulid)&&($requested_ulid == $post-> user->ulid)){

                $validator = Validator::make($request->all(), [
                    "title" => ["required"],
                    "content" => ["required"],
                ]);

                $post_id = $post -> id;

                if ($validator->fails()){
                    return redirect('/posts'.'/'.$post_id.'/edit')->withErrors($validator)->withInput();
                }
                $post->title = $request->string('title');
                $post->content = $request->string('content');
                $post->save();
                return Redirect::route("posts.show", ["post" => $post_id], 201);

            }else{
                return response("forbidden",403);
            }

        }else{
            return response("forbidden",403);
        }

        // $post -> title = $request -> string()

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Post $post) {
        if ($request->session()->has('ulid')) {
            $requested_ulid = $request->session()->get('ulid');
            if (isset($requested_ulid)&&($requested_ulid == $post->user->ulid)){
                $post->delete();
                return redirect('/');
            }
            else return response("forbidden",403);
        }
        else return response("forbidden",403);
    }
}
