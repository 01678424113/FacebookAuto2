<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('id','>',0)->paginate(10);
        return view('posts.index', ['posts' => $posts]);
    }
}
