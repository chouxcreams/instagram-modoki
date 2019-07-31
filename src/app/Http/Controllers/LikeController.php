<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Like;
use Storage;

class LikeController extends Controller
{
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