<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //
    public function search(Request $request)
    {
            // 1. 検索ワードを取得
            $keyword = $request->input('keyword');

            // 2. クエリビルダを開始（自分以外のユーザーを指定）
            $query = User::where('id', '!=', Auth::id());

            // 3. 検索ワードがある場合、ユーザー名で部分一致検索
            if (!empty($keyword)) {
            $query->where('username', 'LIKE', "%{$keyword}%");
        }

            // 4. ユーザー一覧を取得
            $users = $query->get();

            // 5. ビューに変数（ユーザー一覧と入力したワード）を渡す
            return view('users.search', [
            'users' => $users,
            'keyword' => $keyword
        ]);
    }
    
    /**
     * フォロー実行
     */
    public function follow($id)
    {
        // ログインユーザーが対象ユーザーをフォロー（中間テーブルにレコード追加）
        Auth::user()->follows()->attach($id);
        return back(); // 検索ページへリロード
    }

    /**
     * フォロー解除
     */
    public function unfollow($id)
    {
        // ログインユーザーが対象ユーザーのフォローを解除（レコード削除）
        Auth::user()->follows()->detach($id);
        return back(); // 検索ページへリロード
    }
}
