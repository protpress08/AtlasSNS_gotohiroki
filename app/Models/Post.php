<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // 一括割り当て（Mass Assignment）を許可するカラムを指定
    protected $fillable = [
        'user_id',
        'post',
    ];

    // Userモデルとのリレーション（1つの投稿は1人のユーザーに属する）
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}