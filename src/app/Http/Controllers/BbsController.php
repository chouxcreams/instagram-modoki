<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Bbs;

class BbsController extends Controller
{
    // Indexページの表示
    public function index() {
        $bbs = Bbs::all();
        return view('bbs.index', ["bbs" => $bbs]);
    }

    // 投稿された内容を表示するページ
    public function create(Request $request) {

        // バリデーションチェック
        $request->validate([
            'name' => 'required|max:10',
            'comment' => 'required|min:5|max:140',
        ]);

        // 投稿内容の受け取って変数に入れる
        $name = $request->input('name');
        $comment = $request->input('comment');

        Bbs::insert(["name" => $name, "comment" => $comment]); // データベーステーブルbbsに投稿内容を入れる

           $bbs = Bbs::all(); // 全データの取り出し
           return view('bbs.index', ["bbs" => $bbs]); // bbs.indexにデータを渡す
    }

}