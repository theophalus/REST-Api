<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        $postsCollection = new Collection($posts, new PostTransformer());
        $data = fractal($postsCollection)->toArray();
        return response()->json($data);
    }

    public function show($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }
        $postItem = new Item($post, new PostTransformer());
        $data = fractal($postItem)->toArray();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        $post = Post::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ]);

        $postItem = new Item($post, new PostTransformer());
        $data = fractal($postItem)->toArray();
        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        $postItem = new Item($post, new PostTransformer());
        $data = fractal($postItem)->toArray();
        return response()->json($data);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $post->delete();
        return response()->json(['message' => 'Post deleted']);
    }
}
