<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Comment;

class CommentController extends Controller
{
    public function create(Request $request){
        $request ->validate([
            'content' => 'required',
            'blog_id' => 'required',
        ]);

        $comment = new Comment();
        $comment -> content = $request -> content;
        $comment -> blog_id = $request -> blog_id;
        $comment -> user_id = auth() -> user() -> id;
        $comment -> save();

        return response()->json([
            'status'=> 'success',
            'message'=> 'Comment created successfully',
            'comment'=> $comment
        ]);

    }


    public function edit(Request $request){
        $request ->validate([
            'content' => 'required',
            'id' => 'required',
        ]);

        $comment = Comment::find($request -> id);

        $current_user_id = auth() -> user() -> id;

        if(!$comment)
        {
            return response()->json([
                'status'=> 'error',
                'message'=> 'Comment not found',
            ], 404);
        }

        if($comment -> user_id != $current_user_id)
        {
            return response()->json([
                'status'=> 'error',
                'message'=> 'You are not authorized to edit this comment',
            ], 401);
        }

        $comment -> content = $request -> content;
        $comment -> user_id = auth() -> user() -> id;
        $comment -> save();

        return response()->json([
            'status'=> 'success',
            'message'=> 'Comment updated successfully',
            'comment'=> $comment
        ]);

    }
}
