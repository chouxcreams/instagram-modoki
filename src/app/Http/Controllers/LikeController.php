<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Like;
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

        $post_id = $request->get('post_id');
        $like_users = Like::select('user_id')->where('post_id', $post_id)->get();
        $user_names = [];
        foreach($like_users as $like_user) {
            $user_name = User::select('github_id')->where('id', $like_user['user_id'])->get();
            $user_names[] = $user_name[0]['github_id'];
        }
        return view('like', ['session'=>$session, 'user_names'=>$user_names]);
    }

    public function like(Request $request) {
        $like = [
            'post_id' => $request->post('post_id'),
            'user_id' => $request->post('user_id')
        ];
        Like::insert($like);
        return redirect('/');
    }

    public function dislike(Request $request) {
        Like::destroy($request->post('like_id'));
        return redirect('/');
    }
}