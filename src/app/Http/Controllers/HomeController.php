<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request) {
        if ($request->session()->exists('github_token')) {
            $session = 'login';
        } else {
            $session = 'logout';
        }
        return view('home', ['session'=>$session]);
    }

    public function logout(Request $request) {
        $request->session()->pull('github_token');
        return redirect('/');
    }
}