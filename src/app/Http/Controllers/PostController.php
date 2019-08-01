<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Post;
use Storage;

class PostController extends Controller
{
    public function index(Request $request) {
        if (!$request->session()->exists('github_token')) {
            return redirect('login');
        }
        return view('post');
    }

    public function createPost(Request $request) {
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
        $post = Post::where('id', $id)->get();
        Storage::disk('s3')->delete($post[0]['img_file']);
        Post::destroy($id);
        return redirect('/');
    }
}