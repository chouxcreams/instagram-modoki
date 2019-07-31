<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Illuminate\Support\Facades\Auth;
use App\Model\Post;
use Storage;

class HomeController extends Controller
{
    public function index(Request $request) {
        if ($request->session()->exists('github_token')) {
            $session = 'login';
        } else {
            $session = 'logout';
        }
        $posts = Post::all();
        $user_id = $request->session()->get('user_id');
        foreach ($posts as $post) {
            $post['img_path'] = Storage::disk('s3')->url($post['img_file']);
        }
        return view('home', ['session'=>$session, 'posts'=>$posts, 'user_id'=>$user_id]);
    }
}