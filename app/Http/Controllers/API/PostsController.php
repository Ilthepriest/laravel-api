<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{
    public function index(){
        $posts = Post::with(['tags', 'category', 'user'])->orderByDesc('id')->paginate(9);  //con with mostra le relazioni (oppure all())
        return $posts;
    }
}
