<?php

namespace App\Http\Controllers;

use App\Post;
use App\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function main()
    {
        $posts = Post::whereActive(1)->paginate(10);
        foreach ($posts as $post) {
            $post->countViews = View::getCountViews($post->id);
        }
        $vars = compact('posts');
        return view('site.main', $vars);        
    }

}