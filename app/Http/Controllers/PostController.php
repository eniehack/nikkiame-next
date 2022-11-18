<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Post;
use App\Models\User;
use \DateTime;
use Ulid\Ulid;
use League\CommonMark\CommonMarkConverter;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
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
    public function store(Request $request)
    {
        if (!$request->session()->has('name')) {
            return redirect('/signin');
        }
        $validator = Validator::make($request->all(), [
            "content" => ["required"],
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
        $post->scope = 0;
        $post->save();

        return Redirect::route("posts.show", ["post" => $post_id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $converter = new CommonMarkConverter();
        $author = User::find($post->author);
        return view('post/show',['title' => $post -> title ,
                                'content' => $post -> content ,
                                'created_at' => $post -> created_at ,
                                'updated_at' => $post -> updated_at ,
                                'author' => $author,
                                'converter' => $converter
                            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
