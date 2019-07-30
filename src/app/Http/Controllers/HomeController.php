<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Illuminate\Support\Facades\Auth;
use App\Model\Post;

class HomeController extends Controller
{
    public function index(Request $request) {
        if ($request->session()->exists('github_token')) {
            $session = 'login';
        } else {
            $session = 'logout';
        }
        $posts = Post::all();
        $user_id = $posts[0]['id'];
        return view('home', ['session'=>$session, 'posts'=>$posts, 'user'=>$user_id]);
    }
}