<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index()
    {
        $home_posts = $this->getHomePosts();

        return view('users.home')
            ->with('home_posts', $home_posts);
    }

    // ログインしているユーザー自身の投稿だけ取得する
    private function getHomePosts()
    {
        return $this->post
            ->where('user_id', Auth::user()->id)
            ->latest()
            ->get();
    }
}