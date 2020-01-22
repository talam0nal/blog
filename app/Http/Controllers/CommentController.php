<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Comment::get();
        $vars = compact('items');
        return view('comments.index', $vars);
    }

    public function switchPublish()
    {
        $id = request()->id;
        $item = Comment::findOrFail($id);
        if ($item->active == 1) {
            $item->active = 0;
        } else {
            $item->active = 1;
        }
        $item->save();
        return response()->json($item);
    }

    public function store(Request $request)
    {
        Comment::create([
            'text'    => nl2br($request->text),
            'user_id' => \Auth::id(),
            'post_id' => $request->postId,
        ]);
        return redirect()->route('posts.show', $request->postId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Comment::findOrFail($id);
        $item->delete();
        return response()->json($item);
    }
}