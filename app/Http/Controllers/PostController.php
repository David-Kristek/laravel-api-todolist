<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Post as PostResources;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return  $request->user()->posts()->get(); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        // Post::create($request->only(['title', 'description']));
        return $request->user()->posts()->create($request->only(['title', 'description']));

        // return response()->json([
        //     'data' => 'Post created',
        // ]); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        // return  Post::findOrFail($id);
        return $request->user()->posts()->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        return $request->user()->posts()->findOrFail($id)->update($request->only(['title', 'description']));
        // Post::findOrFail($id)->update($request->only(['title', 'description']));
        // return response()->json([
        //     'data' => "Post updated",
        // ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        // $post = Post::findOrFail($id)->delete();
        // return response()->json([
        //     'data' => 'Post deleted',
        // ]);
        return $request->user()->posts()->findOrFail($id)->delete();
    }
}
