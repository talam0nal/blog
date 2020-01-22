<?php

namespace App\Http\Controllers;

use App\{Post, View, Like, Category};
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Category::get();
        foreach ($items as $item) {
            $item->publicationsCount = Post::where('category_id', $item->id)->count();
        }
        $vars = compact('items');
        return view('categories.index', $vars);
    }

    public function siteIndex()
    {
        $posts = Post::whereActive(1)->paginate(10);
        $categories = Category::get();
        foreach ($posts as $post) {
            $post->countViews = View::getCountViews($post->id);
            $post->countLikes = Like::getCountLike($post->id);
        }
        $vars = compact('posts', 'categories');
        return view('categories.site_index', $vars);      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = false;
        $vars = compact('item');
        return view('categories.create_edit', $vars);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = Category::create([
            'title' => $request->title,
            'user_id' => \Auth::id(),
        ]);
        return redirect()->route('categories.edit', $item->id);
    }

    public function show($id)
    {
        $posts = Post::whereActive(1)->where('category_id', $id)->paginate(10);
        $categories = Category::get();
        foreach ($posts as $post) {
            $post->countViews = View::getCountViews($post->id);
            $post->countLikes = Like::getCountLike($post->id);
        }
        $vars = compact('posts', 'categories');
        return view('categories.site_index', $vars);  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Category::findOrFail($id);
        $vars = compact('item');
        return view('categories.create_edit', $vars);
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
        $item = Category::findOrFail($id);
        $item->update([
            'title' => $request->title,
        ]);
        return redirect()->route('categories.edit', $item->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Category::findOrFail($id);
        $item->delete();
        return response()->json($item);
    }
}
