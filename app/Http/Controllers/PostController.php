<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
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
        ]);
        $this->savePreview($item->id);
        return redirect()->route('posts.edit', $item->id);
        //tags
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        ]);
        $this->savePreview($id);
        return redirect()->route('posts.edit', $item->id);
    }

    private function savePreview($id)
    {
        $item = Post::findOrFail($id);
        if (request()->hasFile('preview')) {
            $path = request()->file('preview')->store('public/previews');
        } else {
            $path = '';
        }
        $item->preview = $path;
        $item->save();
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