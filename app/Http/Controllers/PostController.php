<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use App\View;
use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Post::get();
        foreach ($items as $item) {
            $item->countLikes = Like::getCountLike($item->id);
            $item->countViews = View::getCountViews($item->id);
        }
        $vars = compact('items');
        return view('posts.index', $vars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = false;
        $categories = Category::get();
        $vars = compact('item', 'categories');
        return view('posts.create_edit', $vars);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = Post::create([
            'title'       => $request->title,
            'subtitle'    => $request->subtitle,
            'text'        => $request->text,
            'category_id' => $request->category_id,
            'user_id'     => \Auth::id(),
            'tags'        => $request->tags,
        ]);
        $this->savePreview($item->id);
        return redirect()->route('posts.edit', $item->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Post::findOrFail($id);
        $tags = $this->getTags($id);
        $vars = compact('item', 'tags');
        $this->increaseViews($id);
        $item->countViews = View::getCountViews($id);
        $item->countLikes = Like::getCountLike($id);
        return view('posts.show', $vars);
    }

    private function increaseViews($id)
    {
        $viewed = View::where('post_id', $id)->where('ip', request()->ip())->count();
        if (!$viewed) {
            View::create([
                'ip'      => request()->ip(),
                'post_id' => $id,
            ]);
        }
    }

    public function like()
    {
        $id = request()->id;
        $liked = Like::where('post_id', $id)->where('ip', request()->ip())->count();
        if (!$liked) {
            Like::create([
                'ip'      => request()->ip(),
                'post_id' => $id,
            ]);
            return response()->json(['liked' => 1, 'likedCount' => Like::getCountLike($id)]);
        } else {
            $item = Like::where('post_id', $id)->where('ip', request()->ip())->first();
            $item->delete();
            return response()->json(['liked' => 0, 'likedCount' => Like::getCountLike($id)]);
        }
    }

    private function getTags($id)
    {
        $item = Post::findOrFail($id);
        $list = $item->tags;
        return explode(',', $list);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Post::findOrFail($id);
        $categories = Category::get();
        $vars = compact('item', 'categories');
        return view('posts.create_edit', $vars);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Post::findOrFail($id);
        $item->update([
            'title'       => $request->title,
            'subtitle'    => $request->subtitle,
            'text'        => $request->text,
            'category_id' => $request->category_id,
            'tags'        => $request->tags,
        ]);
        $this->savePreview($id);
        return redirect()->route('posts.edit', $item->id);
    }

    private function savePreview($id)
    {
        $item = Post::findOrFail($id);
        if (request()->hasFile('preview')) {
            $path = request()->file('preview')->store('public/previews');
            $item->preview = $path;
            $item->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Post::findOrFail($id);
        Storage::delete($item->preview);
        $item->delete();
        return response()->json($item);
    }

    public function byUser($id)
    {
        $posts = Post::whereActive(1)->where('user_id', $id)->paginate(10);
        foreach ($posts as $post) {
            $post->countViews = View::getCountViews($post->id);
        }
        $vars = compact('posts');
        return view('posts.byuser', $vars);
    }

    public function switchPublish()
    {
        $id = request()->id;
        $item = Post::findOrFail($id);
        if ($item->active == 1) {
            $item->active = 0;
        } else {
            $item->active = 1;
        }
        $item->save();
        return response()->json($item);
    }

    /**
     * Загрузка картинки для редактора
    */
    public function uploadEditor()
    {
        $path = request()->file('image')->store('public/uploads/editor');
        $url = Storage::url($path);

        return response()->json([
            'success' => true,
            'message' => 'Image uploaded',
            'data' => ['link' => $url],
        ]);
    }

}