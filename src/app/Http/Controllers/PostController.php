<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Post;
use App\Model\User;
use App\Model\Like;
use Storage;

class PostController extends Controller
{
    public function index(Request $request) {
        if (!$request->session()->exists('github_token')) {
            return redirect('login');
        }
        $csrf_token = mt_rand();
        $request->session()->push('csrf_token', $csrf_token);
        return view('post', ['csrf_token'=>$csrf_token]);
    }

    public function createPost(Request $request) {
        if ($request->session()->exists('csrf_token')) redirect('/');

        $session_token = $request->session()->pull('csrf_token');
        $post_token = $request->post('csrf_token'); 
        if ($session_token != $post_token) redirect('/');
        $request->session()->push('csrf_token', mt_rand());

        $now = date("Y/m/d H:i:s");
        $post_array = [
            'num_of_likes'=>0,
            'created_at'=>$now,
            'updated_at'=>$now
            ];
        
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
        $file = $request->file('file');
        if ($request->file('file')->isValid([])) {
            $post_array['img_file'] = Storage::disk('s3')->put('/', $file);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors();
        }

        $post_array['user_id'] = $request->session()->get('user_id');
        $caption = $request->post('caption');
        if (is_null($caption)) $caption = "";
        $post_array['caption'] = $caption;
        Post::insert($post_array);
        return redirect('/');
    }

    public function deletePost(Request $request) {
        $id = $request->post('post_id');
        $posts = Post::where('id', $id)->get();
        $deleter_id = $request->session()->get('user_id');

        if ($deleter_id != $posts[0]['user_id']) return redirect('/');
        $users = User::where('id', $posts[0]['user_id'])->get();
        $user_num_of_likes = $users[0]['num_of_likes'] - $posts[0]['num_of_likes'];

        $likes = Like::where('post_id', $id)->get();
        foreach ($likes as $like) {
            Like::destroy($like['id']);
        }

        $users[0]->update(['num_of_likes'=>$user_num_of_likes]);
        Storage::disk('s3')->delete($posts[0]['img_file']);
        Post::destroy($id);
        return redirect('/');
    }
}