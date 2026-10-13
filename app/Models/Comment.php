<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // ==========================================
    // コメントを投稿したユーザーとのリレーション
    // ==========================================
    public function user()
    {
        // このコメントを投稿したユーザーを取得する
        return $this->belongsTo(User::class);
    }
}