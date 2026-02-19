<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
        protected $fillable = [
            'username',
            'email',
            'password',
            'icon_image',
            'bio',
        ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * フォローしているユーザーを取得（自分がフォロー側）
     */
    public function follows()
    {
        // 第2引数: 中間テーブル名 (follows)
        // 第3引数: 自分のIDを示すカラム (following_id_id)
        // 第4引数: 相手のIDを示すカラム (followed_id)
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'followed_id');
    }

    /**
     * フォロワーを取得（自分がフォローされている側）
     */
    public function followers()
    {
        // 第3引数と第4引数のカラムを入れ替える
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'following_id');
    }

    // Postモデルとのリレーション（1人のユーザーは複数の投稿を持つ）
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * 指定したユーザーをフォローしているかチェックする
     */
    public function isFollowing($userId)
    {
        return $this->follows()->where('followed_id', $userId)->exists();
    }
}
