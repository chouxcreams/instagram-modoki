<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Post;

class PostController extends Controller
{
    public function index(Request $request) {
        if ($request->session()->exists('github_token')) {
            $session = 'login';
        } else {
            $session = 'logout';
        }
        return view('post', ['session'=>$session]);
    }

    public function createPost(Request $request) {
        $post_array = ['num_of_likes'=>0];
        
        // 画像のアップロード
        $this->validate($request, [
            'file' => [
                // 必須
                'required',
                // アップロードされたファイルであること
                'file',
                // 画像ファイルであること
                'image',
                // MIMEタイプを指定
                'mimes:jpeg,png',
            ]
        ]);

        if ($request->file('file')->isValid([])) {
            $post_array['img_file'] = basename($request->file->store('public'));
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors();
        }

        $post_array['user_id'] = $request->session()->get('user_id');
        $post_array['caption'] = $request->post('caption');
        Post::insert($post_array);
        return redirect('/');
    }
}