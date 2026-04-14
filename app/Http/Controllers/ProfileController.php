<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Post;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * 自分のプロフィール編集画面
     */
    public function profile()
    {
        return view('profiles.profile');
    }

/**
     * プロフィール更新処理
     */
    public function update(Request $request): RedirectResponse
    {
        // 1. バリデーション
        $request->validate([
            'username' => 'required|string|min:2|max:12',
            'email' => [
                'required',
                'string',
                'email',
                'min:5',
                'max:40',
                Rule::unique('users', 'email')->ignore(Auth::id()),
            ],
            'password' => 'required|string|alpha_num|min:8|max:20|confirmed',
            'password_confirmation' => 'required|string|alpha_num|min:8|max:20',
            'bio' => 'nullable|string|max:150',
            'icon_image' => 'nullable|image|mimes:jpg,png,bmp,gif,svg|max:2048',
        ], [
            // --- 第2引数：カスタムメッセージ ---
            'required' => ':attributeを入力してください。',
            'confirmed' => 'パスワードが一致しません。',
            'min' => ':attributeは:min文字以上で入力してください。',
            'max' => ':attributeは:max文字以内で入力してください。',
            'email' => '有効なメールアドレスを入力してください。',
            'image' => '指定されたファイルが画像ではありません。',
            'mimes' => ':attributeは :values 形式のファイルを指定してください。',
        ], [
            // --- 第3引数：属性名の日本語化 ---
            'username' => 'ユーザー名',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'password_confirmation' => 'パスワード確認',
            'bio' => '自己紹介',
            'icon_image' => 'アイコン画像',
        ]);

        $user = Auth::user();

        // 2. 基本情報のセット
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->bio = $request->input('bio');

        // 3. パスワードの更新（ハッシュ化して保存）
        $user->password = bcrypt($request->input('password'));

        // 4. アイコン画像の保存処理
        if ($request->hasFile('icon_image')) {
            $file = $request->file('icon_image');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('images'), $fileName);
            $user->icon_image = $fileName;
        }

        // 5. データベース保存
        $user->save();

        // 6. TOPページへリダイレクト
        return redirect('/top');
    }

    /**
     * 他人のプロフィール表示画面
     */
    public function otherProfile($id)
    {
        // 1. もし自分のIDが渡されたら、自分の編集ページへリダイレクト
        if ($id == Auth::id()) {
            return redirect()->route('profile');
        }

        // 2. 送られてきたIDのユーザーを取得
        $user = User::findOrFail($id);

        // 3. そのユーザーの投稿を最新順で取得
        $posts = Post::where('user_id', $id)->latest()->get();

        // 4. 「相手専用のView」を返す
        return view('profiles.otherProfile', compact('user', 'posts'));
    }
}