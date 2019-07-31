<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Illuminate\Support\Facades\Auth;
use App\Model\Post;
use App\Model\User;
use Storage;

class LikeController extends Controller
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
            $github_ids = User::select('github_id')->where('id', $user_id)->get();
            $post['github_id'] = $github_ids[0]['github_id'];
        }
        return view('home', ['session'=>$session, 'posts'=>$posts, 'user_id'=>$user_id]);
    }
}