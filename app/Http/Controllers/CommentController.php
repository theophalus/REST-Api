<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Transformers\CommentTransformer;
use Illuminate\Http\Request;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::all();
        $commentsCollection = new Collection($comments, new CommentTransformer());
        $data = fractal($commentsCollection)->toArray();
        return response()->json($data);
    }

    public function show($id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json(['error' => 'Comment not found'], 404);
        }
        $commentItem = new Item($comment, new CommentTransformer());
        $data = fractal($commentItem)->toArray();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required',
            'post_id' => 'required|exists:posts,id',
        ]);

        $comment = Comment::create([
            'body' => $request->input('body'),
            'post_id' => $request->input('post_id'),
        ]);

        $commentItem = new Item($comment, new CommentTransformer());
        $data = fractal($commentItem)->toArray();
        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json(['error' => 'Comment not found'], 404);
        }

        $this->validate($request, [
            'body' => 'required',
            'post_id' => 'required|exists:posts,id',
        ]);

        $comment->body = $request->input('body');
        $comment->post_id = $request->input('post_id');
        $comment->save();

        $commentItem = new Item($comment, new CommentTransformer());
        $data = fractal($commentItem)->toArray();
        return response()->json($data);
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json(['error' => 'Comment not found'], 404);
        }

        $comment->delete();
        return response()->json(['message' => 'Comment deleted']);
    }
}
