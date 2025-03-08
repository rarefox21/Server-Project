<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function create(Request $request){
        $request ->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $blog = new Blog();
        $blog -> title = $request -> title;
        $blog -> content = $request -> content;
        $blog -> user_id = auth() -> user() -> id;
        $blog -> save();

        return response()->json([
            'status'=> 'success',
            'message'=> 'Blog created successfully',
            'blog'=> $blog
        ]);

    }

    public function edit(Request $request){
        $request ->validate([
            'title' => 'required',
            'content' => 'required',
            'id' => 'required',
        ]);

        $blog = Blog::find($request -> id);

        $current_user_id = auth() -> user() -> id;

        if(!$blog)
        {
            return response()->json([
                'status'=> 'error',
                'message'=> 'Blog not found',
            ], 404);
        }

        if($blog -> user_id != $current_user_id)
        {
            return response()->json([
                'status'=> 'error',
                'message'=> 'You are not authorized to edit this blog',
            ], 401);
        }

        $blog -> title = $request -> title;
        $blog -> content = $request -> content;
        $blog -> user_id = auth() -> user() -> id;
        $blog -> save();

        return response()->json([
            'status'=> 'success',
            'message'=> 'Blog updated successfully',
            'blog'=> $blog
        ]);

    }


    public function delete(Request $request){
        $request ->validate([
            'id' => 'required',
        ]);

        $blog = Blog::find($request -> id);

        $current_user_id = auth() -> user() -> id;

        if(!$blog)
        {
            return response()->json([
                'status'=> 'error',
                'message'=> 'Blog not found',
            ], 404);
        }

        if($blog -> user_id != $current_user_id)
        {
            return response()->json([
                'status'=> 'error',
                'message'=> 'You are not authorized to delete this blog',
            ], 401);
        }

        $blog -> delete();

        return response()->json([
            'status'=> 'success',
            'message'=> 'Blog deleted successfully',
        ]);

    }


    public function getAllBlogs(){
        $blogs = Blog::with(['user'])->withCount(['votes','comments', 'upvotes', 'downvotes'])
                    ->get();

        return response()->json([
            'status'=> 'success',
            'message'=> 'Blogs fetched successfully',
            'blogs'=> $blogs
        ]);

    }


    public function singleBlog($id){
        
        $blog = Blog::where('id',$id)->with(['user', 'comments'])
                    ->withCount(['votes','comments', 'upvotes', 'downvotes'])
                    ->first();

        if(!$blog)
        {
            return response()->json([
                'status'=> 'error',
                'message'=> 'Blog not found',
            ], 404);
        }

        return response()->json([
            'status'=> 'success',
            'message'=> 'Blog fetched successfully',
            'blog'=> $blog
        ]);

    }
}
