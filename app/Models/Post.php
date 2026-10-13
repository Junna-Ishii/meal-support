<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // ==========================================
    // 投稿者とのリレーション
    // ==========================================
    public function user()
    {
        // この食事記録を投稿したユーザーを取得する
        return $this->belongsTo(User::class);
    }


    // ==========================================
    // カテゴリーとのリレーション
    // ==========================================
    public function categoryPost()
    {
        // この食事記録に紐づくカテゴリーの関連データを取得する
        return $this->hasMany(CategoryPost::class);
    }


    // ==========================================
    // コメントとのリレーション
    // ==========================================
    public function comments()
    {
        // この食事記録に投稿されたコメントを取得する
        return $this->hasMany(Comment::class);
    }


    // ==========================================
    // 栄養士の評価とのリレーション
    // ==========================================
    public function evaluation()
    {
        // この食事記録に対する評価を取得する
        return $this->hasOne(Evaluation::class);
    }
}