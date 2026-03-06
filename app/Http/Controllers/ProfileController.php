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
        // 1. バリデーション（条件をすべて反映）
        $request->validate([
            'username' => 'required|string|min:2|max:12', // 2文字以上12文字以内
            'email' => [
                'required',
                'string',
                'email',
                'min:5',
                'max:40', // 5文字以上40文字以内
                Rule::unique('users', 'email')->ignore(Auth::id()), // 自分のメールアドレスを除外して重複チェック
            ],
            'password' => 'required|string|alpha_num|min:8|max:20|confirmed', // 英数字のみ8-20文字
            'password_confirmation' => 'required|string|alpha_num|min:8|max:20', // パスワード一致確認
            'bio' => 'nullable|string|max:150', // 150文字以内
            'icon_image' => 'nullable|image|mimes:jpg,png,bmp,gif,svg|max:2048', // 指定の画像形式
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