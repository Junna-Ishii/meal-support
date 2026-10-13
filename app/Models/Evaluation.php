<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    // ==========================================
    // 評価対象の食事記録とのリレーション
    // ==========================================
    public function post()
    {
        // この評価が付けられた食事記録を取得する
        return $this->belongsTo(Post::class);
    }


    // ==========================================
    // 評価した栄養士とのリレーション
    // ==========================================
    public function nutritionist()
    {
        // この評価を行った栄養士を取得する
        // nutritionist_idを使ってユーザー情報と紐付ける
        return $this->belongsTo(User::class, 'nutritionist_id');
    }
}