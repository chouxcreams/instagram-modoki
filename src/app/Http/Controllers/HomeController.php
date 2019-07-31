<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Illuminate\Support\Facades\Auth;
use App\Model\Post;
use App\Model\User;
use App\Model\Like;
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

            $github_ids = User::select('github_id')->where('id', $post['user_id'])->get();
            $post['github_id'] = $github_ids[0]['github_id'];

            $likes = Like::select('id')->where([
                ['post_id', $post['id']],
                ['user_id', $user_id]
            ])->get();
            $post['liked'] = !empty($likes[0]);
            $post['like_id'] = null;
            if($post['liked']) $post['like_id'] = $likes[0]['id'];
        }
        return view('home', ['session'=>$session, 'posts'=>$posts, 'user_id'=>$user_id]);
    }
}