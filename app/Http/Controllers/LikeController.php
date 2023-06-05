<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, $id)
    {
        $user_id = Auth::user()->id;

        $existingLike = Like::where('user_id', $user_id)
            ->where('post_id', $id)
            ->first();

        if ($existingLike) {
            $existingLike->is_checked = !$existingLike->is_checked;

            $existingLike->save();

            return response()->json(['message' => 'Like status updated successfully', 'like' => $existingLike]);
        }

        $like = Like::create([
            'user_id' => $user_id,
            'post_id' => $id,
            'is_checked' => true, // Устанавливаем is_checked в true для нового лайка
        ]);

        return response()->json(['message' => 'Like created successfully', 'like' => $like]);
    }

    public function countLikes($id)
    {
        $count = Like::where('post_id', $id)->where('is_checked', true)->count();
        return response()->json(['count' => $count]);
    }
}
