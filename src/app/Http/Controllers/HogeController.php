<?php
namespace App\Http\Controllers;
class HogeController extends Controller
{
    public function index()
    {
        $hoge = '';
        $rand = rand(1, 10);
        for ($i=0; $i<$rand; $i++) $hoge=$hoge.'hoge';
        return view('hoge', ['hoge' => $hoge]);    
    }
}