<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Like;
use App\Model\User;
use App\Model\Post;
use Storage;

class LikeController extends Controller
{
    public function index(Request $request) {
        if ($request->session()->exists('github_token')) {
            $session = 'login';
        } else {
            $session = 'logout';
        }

        $post_id = $request->get('post_id');
        $like_users = Like::select('user_id')->where('post_id', $post_id)->get();
        $user_names = [];
        foreach($like_users as $like_user) {
            $user_name = User::select('name')->where('id', $like_user['user_id'])->get();
            $user_names[] = $user_name[0]['name'];
        }
        return view('like', ['session'=>$session, 'user_names'=>$user_names]);
    }

    public function like(Request $request) {
        $now = date("Y/m/d H:i:s");
        $post_id = $request->post('post_id');
        $like = [
            'post_id' => $post_id,
            'user_id' => $request->session()->get('user_id'),
            'created_at' => $now,
            'updated_at' => $now
        ];
        Like::insert($like);

        Post::where('id', $post_id)->increment('num_of_likes');

        $poster = Post::select('user_id')->where('id', $post_id)->get();
        User::where('id', $poster[0]['user_id'])->increment('num_of_likes');

        return redirect('/');
    }

    public function dislike(Request $request) {
        $like_id = $request->post('like_id');

        $like = Like::select('post_id', 'user_id')->where('id', $like_id)->get();
        $post_id = $like[0]['post_id'];
        $user_id = $like[0]['user_id'];

        Post::where('id', $post_id)->decrement('num_of_likes');
        
        User::where('id', $user_id)->decrement('num_of_likes');

        Like::destroy($like_id);
        return redirect('/');
    }
}