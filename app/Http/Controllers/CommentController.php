<?php

namespace App\Http\Controllers;

use App\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $content = request('content');

        if($content) {
            $comment = new Comments();
            $comment->content = $content;
            $comment->user_id = Auth::user()->id;
            $comment->post_id = $id;
            $comment->save();
            return response()->json(['message' => 'sucess', 'content' => $content]);

        } else {
            return response()->json(['message' => 'error', 'content' => $content]);
        }

        /*
        Table Likes

        id
        user_id
        posts_id
        is_checked = false

        Required

        Likes::where('posts_id', $id)->orWhere('is_checked', true)->count()->get()



        CreateLikes

        Likes

        $checked Likes::where('posts_id', $id)->orWhere('user_id', $user)

        if($checked) {
            $checked->is_checked = false
            $checked->save()
        }

        */ 

    }
}
