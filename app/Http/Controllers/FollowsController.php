<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post; // Postモデルを使用可能にする

class FollowsController extends Controller
{
    // フォローリスト表示
    public function followList(){
        // 1. ログインユーザーがフォローしているユーザーのIDを取得
        $following_ids = Auth::user()->follows()->pluck('followed_id');

        // 2. フォローしているユーザーの情報を取得（アイコン表示用）
        $followList = Auth::user()->follows()->get();

        // 3. フォローしているユーザーの投稿を取得
        $posts = Post::with('user')
            ->whereIn('user_id', $following_ids)
            ->latest()
            ->get();

        // 4. view に $followList と $posts を渡す
        return view('follows.followList', compact('followList', 'posts'));
    }

    // フォロワーリスト表示（同様のロジックで投稿を表示する場合）
    public function followerList(){
        $follower_ids = Auth::user()->followers()->pluck('following_id');
        $followerList = Auth::user()->followers()->get();
        
        $posts = Post::with('user')
            ->whereIn('user_id', $follower_ids)
            ->latest()
            ->get();

        return view('follows.followerList', compact('followerList', 'posts'));
    }
}