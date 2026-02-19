<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post; // Postモデルの使用を宣言
use Illuminate\Support\Facades\Auth; // ログイン情報取得のため

class PostsController extends Controller
{
    // 投稿画面の表示
    public function index(){
        // 自分とフォローしている人のIDを取得
        $ids = Auth::user()->follows()->pluck('followed_id')->toArray();
        $ids[] = Auth::id();

        // そのIDに該当する投稿のみ取得
        $posts = Post::with('user')
            ->whereIn('user_id', $ids)
            ->latest()
            ->get();
        return view('posts.index', compact('posts'));
    }

    // ★投稿の登録処理
    public function postCreate(Request $request){
        // 1. バリデーション（入力必須、1〜150文字）
        $request->validate([
            'newPost' => 'required|string|min:1|max:150',
        ]);

        // 2. フォームからの入力値を取得
        $post_content = $request->input('newPost');
        $user_id = Auth::id(); // 現在ログインしているユーザーのID

        // 3. データベースに保存
        Post::create([
            'post' => $post_content,
            'user_id' => $user_id,
        ]);

        // 4. トップページにリダイレクト
        return redirect('/top');
    }

    public function postUpdate(Request $request){
    // バリデーション
    $request->validate([
        'upPost' => 'required|string|min:1|max:150',
    ]);

    $id = $request->input('id');
    $up_post = $request->input('upPost');

    // 指定したIDの投稿を更新
    Post::where('id', $id)->update(['post' => $up_post]);

    return redirect('/top');
    }

    public function postDelete($id){

    // 指定したID、かつ、ログインユーザー自身の投稿のみを削除
        \App\Models\Post::where('id', $id)
        ->where('user_id', \Illuminate\Support\Facades\Auth::id())
        ->delete();

        return redirect('/top');
    }

}