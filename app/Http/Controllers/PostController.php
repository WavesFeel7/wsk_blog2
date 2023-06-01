<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function store(Request $request)
    {
        try {
            $title = request('title');
            $description = request('description');
            $description = request('img');
            $user = Auth::user();

            // Проверяем, есть ли загруженное изображение
            if ($request->hasFile('img')) {
                $img = $request->file('img');

                // Сохраняем изображение и получаем его путь
                $imgPath = Storage::disk('public')->put('images', $img);

                // Создаем новый пост и сохраняем данные, включая путь к изображению
                $post = new Post;
                $post->title = $title;
                $post->description = $description;
                $post->author = $user->id;
                $post->img = $imgPath;
                $post->save();
            } else {
                // Создаем новый пост и сохраняем данные, включая путь к изображению
                $post = new Post;
                $post->title = $title;
                $post->description = $description;
                $post->author = $user->id;
                $post->save();
            }

            return response()->json(['status' => 'success'], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if (auth()->user()->id !== $post->author) {
            return response()->json([
                'status' => 'forbidden',
                'message' => 'Вы не являетесь автором поста'
            ]);
        }
        $post = Post::findOrFail($id);
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        if ($request->hasFile('img')) {
            $img = $request->file('img');

            // Сохраняем новое изображение и получаем его путь
            $imgPath = Storage::disk('public')->put('images', $img);

            // Удаляем предыдущее изображение, если оно существует
            Storage::disk('public')->delete($post->img);

            // Обновляем путь к изображению в модели поста
            $post->img = $imgPath;
        }

        $post->save();
        return response()->json(['status' => 'success']);
    }
}
