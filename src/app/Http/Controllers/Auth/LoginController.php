<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;// 追加！
use Illuminate\Http\Request;// 追加！
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * GitHubの認証ページヘユーザーをリダイレクト
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()// 追加！
    {
        return Socialite::driver('github')->scopes(['read:user', 'public_repo'])->redirect(); 
    }

    /**
     * GitHubからユーザー情報を取得
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request)
    {
        $github_user = Socialite::driver('github')->user();

        $now = date("Y/m/d H:i:s");
        $app_user = DB::select('select * from users where name = ?', [$github_user->user['login']]);
        if (empty($app_user)) {
            $default_icon = $github_user['avatar_url'];
            DB::insert('insert into users (name, icon_file, num_of_likes, remember_token, created_at, updated_at) values (?, ?, ?, ?, ?, ?)', 
            [$github_user->user['login'], $default_icon, 0, $github_user->token, $now, $now]);
            $app_user = DB::select('select * from users where name = ?', [$github_user->user['login']]);
        }

        $request->session()->put('user_id', $app_user[0]->id);
        $request->session()->put('github_token', $github_user->token);

        return redirect('/');
    }
}
