<?php

namespace App\Http\Controllers;

use App\Model\Img;
use Illuminate\Http\Request;

class SignInController extends Controller
{
    public function index() {
        return view('signin');
    }
}