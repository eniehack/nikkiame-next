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
use Embed\Embed;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\Embed\EmbedExtension;
use League\CommonMark\Extension\Embed\EmbedRenderer;
use League\CommonMark\Extension\Embed\Bridge\OscaroteroEmbedAdapter;
use League\CommonMark\Renderer\HtmlDecorator;
use League\CommonMark\MarkdownConverter;

use function PHPUnit\Framework\isFalse;
use function PHPUnit\Framework\returnArgument;

use Illuminate\Support\Facades\Log;
use League\CommonMark\Extension\Embed\Embed as EmbedEmbed;

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
            return Redirect::route('posts.create')->withErrors($validator)->withInput();
        }

        if (PostScope::Private === $request->enum("scope", PostScope::class)) {
            $privatepost_validator = Validator::make($request->all(), [
                "pass_phrase" => ["required", "min:8", "regex:/^[a-zA-Z0-9\#\&\:\;\$\%\@\^\`\~\\\.\,\|\-\_\<\>\*\+\!\?\=\{\}\(\)\[\]\"\'\ ]+$/"],
            ]);
            if ($privatepost_validator->fails()){
                return Redirect::route('posts.create')->withErrors($privatepost_validator)->withInput();
            }
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
        $post->scope = $request->enum("scope", PostScope::class);
        $post->save();
        $user = User::find($request->session()->get('ulid'));

        if ($post->scope === PostScope::Private) {
            $post_passphrase = new PostPassphrase();
            $post_passphrase->post_id = $post_id;
            $post_passphrase->passphrase = Hash::make($request->string("pass_phrase"));
            $post_passphrase->save();
        }
        return Redirect::route("posts.show", ["post" => $post_id, "user" => $user->user_id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user, Post $post) {
        $requestedUser = $request->session()->get('ulid');
        $config = [
            'embed' => [
                'adapter' => new OscaroteroEmbedAdapter(),
            ],
        ];
        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new EmbedExtension());
        $environment->addRenderer(Embed::class, new HtmlDecorator(new EmbedRenderer(), 'div', ['class' => 'embeded-content']));
        $converter = new MarkdownConverter($environment);
        $editButtonFlag = false;
        if(isset($requestedUser) && ($user -> ulid == $requestedUser)){
            $editButtonFlag = true;
        }
        if(($post->scope === PostScope::Draft)  && ! $editButtonFlag){
            return response("NOT FOUND", 404);
        }
        if (! $editButtonFlag && $post->scope === PostScope::Private) {
            if(!($request->session()->has(($post->id).'_access_allowed'))) {
                return redirect()->route("post.passphrase.get" , ["post" => $post -> id, "user" => $user->user_id]);
            }
        }

        /*
        return view('post/show',['title' => $post -> title ,
                                'content' => $post -> content ,
                                'created_at' => $post -> created_at ,
                                'updated_at' => $post -> updated_at ,
                                'author' => $user,
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
    public function edit(Request $request, User $user, Post $post) {
        if ($request->session()->has('ulid')) {
            $requested_ulid = $request->session()->get('ulid');
            if (isset($requested_ulid)&&($requested_ulid == $user->ulid)){
                return view('post/edit',['title' => $post -> title ,
                                "user_id" => $user->user_id,
                                'content' => $post->content,
                                'post_id' => $post->id,
                                'scope'=> $post->scope
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
    public function update(Request $request, User $user, Post $post) {

        if ($request->session()->has('ulid')) {

            $requested_ulid = $request->session()->get('ulid');
            if (isset($requested_ulid)&&($requested_ulid == $post-> user->ulid)){

                $validator = Validator::make($request->all(), [
                    "title" => ["required"],
                    "content" => ["required"],
                ]);

                $post_id = $post -> id;

                if ($validator->fails()){
                    return Redirect::route('posts.edit', ['user' => $user->user_id, 'post' => $post_id])->withErrors($validator)->withInput();
                }
                $post->title = $request->string('title');
                $post->content = $request->string('content');
                $post->scope = $request->enum("scope", PostScope::class);
                if ($post->scope === PostScope::Private) {
                    $post_passphrase = PostPassphrase::find($post->id);
                    if (!isset($post_passphrase)){
                        $post_passphrase = new PostPassphrase();
                        $post_passphrase->post_id = $post_id;
                    }
                    $post_passphrase->passphrase = Hash::make($request->string("pass_phrase"));
                    $post_passphrase->save();
                }
                $post->save();
                return Redirect::route("posts.show", ['user' => $user->user_id, "post" => $post_id], 201);

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
    public function destroy(Request $request, User $user, Post $post) {
        if ($request->session()->has('ulid')) {
            $requested_ulid = $request->session()->get('ulid');
            if (isset($requested_ulid)&&($requested_ulid == $user->ulid)){
                $post->delete();
                return redirect('/');
            }
            else return response("forbidden",403);
        }
        else return response("forbidden",403);
    }
}
