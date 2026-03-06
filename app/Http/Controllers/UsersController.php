<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * ユーザー検索
     */
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // 自分以外のユーザーを取得するクエリ
        $query = User::where('id', '!=', Auth::id());

        // 検索ワードがある場合、部分一致検索を追加
        if (!empty($keyword)) {
            $query->where('username', 'LIKE', "%{$keyword}%");
        }

        $users = $query->get();

        return view('users.search', compact('users', 'keyword'));
    }

    /**
     * フォロー実行
     */
    public function follow($id)
    {
        Auth::user()->follows()->attach($id);
        return back();
    }

    /**
     * フォロー解除
     */
    public function unfollow($id)
    {
        Auth::user()->follows()->detach($id);
        return back();
    }
}