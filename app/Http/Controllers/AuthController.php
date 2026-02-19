<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $request->validate([
            // UserName
            'username' => [
                'required',
                'string',
                'min:2',
                'max:12',
            ],

            // MailAddress
            'email' => [
                'required',
                'string',
                'email',
                'min:5',
                'max:40',
                'unique:users,email',
            ],

            // Password
            'password' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9]+$/',
                'min:8',
                'max:20',
                'confirmed',
            ],

            // PasswordConfirm
            'password_confirmation' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9]+$/',
                'min:8',
                'max:20',
        ],
        ],
        // エラーメッセージ（日本語）
        [
            'username.required' => 'ユーザー名は必須です',
            'username.min' => 'ユーザー名は2文字以上で入力してください',
            'username.max' => 'ユーザー名は12文字以内で入力してください',

            'email.required' => 'メールアドレスは必須です',
            'email.email' => 'メールアドレスの形式が正しくありません',
            'email.min' => 'メールアドレスは5文字以上で入力してください',
            'email.max' => 'メールアドレスは40文字以内で入力してください',
            'email.unique' => 'このメールアドレスは既に登録されています',

            'password.required' => 'パスワードは必須です',
            'password.regex' => 'パスワードは英数字のみ使用できます',
            'password.min' => 'パスワードは8文字以上で入力してください',
            'password.max' => 'パスワードは20文字以内で入力してください',
            'password.confirmed' => 'パスワードが一致しません',

            'password_confirmation.required' => 'パスワード確認は必須です',
            'password_confirmation.regex' => 'パスワード確認は英数字のみ使用できます',
        ]);

    // 登録処理
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'icon_image' => 'icon1.png',
        ]);

        //Auth::login($user);

        return redirect()->route('register.added')
            ->with('username', $user->username);

    }

public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors([
            'email' => 'ログイン情報が正しくありません',
        ]);
    }

    // 🔹 DBが「平文パスワード」の場合
    if ($user->password === $request->password) {

        // 初回ログイン時に暗号化
        $user->password = Hash::make($request->password);
        $user->save();

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/home');
    }

    // 🔹 DBが「ハッシュ」の場合（通常）
    if (Hash::check($request->password, $user->password)) {

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/home');
    }

    // 🔹 どれにも当てはまらない場合
    return back()->withErrors([
        'email' => 'ログイン情報が正しくありません',
    ]);
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}