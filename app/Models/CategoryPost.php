<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    // 使用するテーブル名を指定する
    protected $table = 'category_post';

    // 登録・更新を許可する項目
    protected $fillable = [
        'post_id',
        'category_id',
    ];

    // 作成日時・更新日時の自動管理を無効にする
    public $timestamps = false;


    // ==========================================
    // カテゴリーとのリレーション
    // ==========================================
    public function category()
    {
        // この中間テーブルのカテゴリーIDに対応するカテゴリーを取得する
        return $this->belongsTo(Category::class);
    }
}