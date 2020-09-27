<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\MessageBag;
use InterventionImage;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {

        $user = \Auth::user();
        $id = Auth::id();

        $posts = Post::withCount('users')->orderBy('users_count', 'desc')->paginate(5);


        $q = \Request::query();

        if(isset($q['category_id'])){
            $posts = Post::latest()->where('category_id', $q['category_id'])->paginate(3);
            $posts->load('category', 'user' );


            $authUser = Auth::user();
            $param = [
            'authUser' => $authUser,
            ];

            return view('posts.index', [
                'posts' => $posts,$param,
                'category_id' => $q['category_id'],
                'authUser' => $authUser,
                'user' => $user
            ]);

        } else {
            $posts = Post::latest()->simplePaginate(5);
            $posts->load('category', 'user');

            $authUser = Auth::user();
            $param = [
            'authUser' => $authUser,
            ];

            return view('posts.index', [
                'posts' => $posts, $param,
                'user' => $user
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {

        if($request->file('image')->isValid()) {

        $post = new Post;
        $input = $request->only($post->getFillable());
        $post->user_id = $request->user_id;
        $post->category_id = $request->category_id;
        $post->content = $request->content;
        $post->title = $request->title;

        $filename = $request->file('image')->store('/public/image');

        $post->image = basename($filename);

        $post->save();
        }



        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->load('category', 'user', 'comments.user', );
        $authUser = Auth::user();
        $param = [
        'authUser' => $authUser,
        ];

        return view('posts.show', [
            'post' => $post,$param

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
    public function search(Request $request)
    {

        $posts = Post::where('title', 'like', "%{$request->search}%")
        ->orWhere('content', 'like', "%{$request->search}%")
        ->paginate(5);

        $search_result = $request->search.'の検索結果'.$posts->total().'件';

        return view('posts.index', [
            'posts' => $posts,
            'search_results' => $search_result,
            'search_query' => $request->search
            ]);
    }

}
