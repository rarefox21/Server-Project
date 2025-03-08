<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;

class VoteController extends Controller
{
    public function create(Request $request){
        $request ->validate([
            'vote' => 'required',
            'blog_id' => 'required',
        ]);

        $exiting_vote = Vote::where('blog_id', $request -> blog_id)
                            ->where('user_id', auth() -> user() -> id)
                            ->first();

        if($exiting_vote){
            $exiting_vote   ->user_id = auth()->user()->id;
            $exiting_vote -> vote = $request -> vote;
            $exiting_vote -> blog_id = $request -> blog_id;
            $exiting_vote -> save();

            return response()->json([
                'status'=> 'success',
                'message'=> 'Vote updated successfully',
                'vote'=> $exiting_vote
            ]);
        }

        $vote = new Vote();
        $vote -> vote = $request -> vote;
        $vote -> blog_id = $request -> blog_id;
        $vote -> user_id = auth() -> user() -> id;
        $vote -> save();

        return response()->json([
            'status'=> 'success',
            'message'=> 'Vote created successfully',
            'vote'=> $vote
        ]);

    }

}
