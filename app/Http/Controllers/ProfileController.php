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

class ProfileController extends Controller
{
    public function profile(){
        return view('profiles.profile');
    }

    public function otherProfile($id){

        // 送られてきたIDのユーザーを取得
        $user = User::where('id', $id)->first();
        // そのユーザーの投稿を取得
        $posts = Post::where('user_id', $id)->latest()->get();

        return view('profiles.profile', compact('user', 'posts'));
    }
}
