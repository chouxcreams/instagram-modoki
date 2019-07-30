<?php

namespace App\Http\Controllers;

use App\Model\Img;
use Illuminate\Http\Request;

class SignInController extends Controller
{
    public function index() {
        return view('signin');
    }

    public function logout(Request $request) {
        $request->session()->pull('github_token');
        $request->session()->pull('user_id');
        return redirect('/');
    }
}