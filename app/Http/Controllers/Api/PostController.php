<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct() {
        $this -> middleware( 'can:posts.index' )   -> only( 'index' );
        $this -> middleware( 'can:posts.store' )   -> only( 'store' );
        $this -> middleware( 'can:posts.show' )    -> only( 'show' );
        $this -> middleware( 'can:posts.update' )  -> only( 'update' );
        $this -> middleware( 'can:posts.destroy' ) -> only( 'destroy' );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return response() -> json([
            "message" => "All posts",
            "posts" => Post::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request -> validate([
            'title' => 'required|max:150|unique:posts',
            'content' => 'required'
        ]);

        $post = auth() -> user() -> posts() -> create($request -> all() );

        return response() -> json([
            "message" => "New post",
            "post" => $post
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post) {
        return response() -> json([
            "message" => "Post detail",
            "post" => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post) {
        $request -> validate([
            'title' => 'required|max:150|unique:posts,title,' . $post -> id,
            'content' => 'required'
        ]);

        $post -> update( $request -> all() );

        return response() -> json([
            "message" => "Updated post",
            "post" => $post
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post) {
        $post -> delete();

        return response() -> json([
            "message" => "Deleted post"
        ]);
    }
}
