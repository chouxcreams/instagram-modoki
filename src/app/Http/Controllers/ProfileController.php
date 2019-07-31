<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Post;
use App\Model\User;
use Storage;

class ProfileController extends Controller
{
    public function index(Request $request) {
        if ($request->session()->exists('github_token')) {
            $session = 'login';
        } else {
            $session = 'logout';
        }

        $user_id = str_replace('/profile/', '', $request->server('REQUEST_URI'));
        $posts = Post::select('img_file')->where('user_id', $user_id)->get();
        $users = User::select('*')->where('id', $user_id)->get();

        foreach ($posts as $post) {
            $post['img_path'] = Storage::disk('s3')->url($post['img_file']);
        }

        return view('profile', ['user'=>$users[0], 'posts'=>$posts, 'session'=>$session]);
    }
}