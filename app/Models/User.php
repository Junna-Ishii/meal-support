<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // ユーザーのテストデータ作成と通知機能を利用する
    use HasFactory, Notifiable;


    // ==========================================
    // 一括登録・更新を許可する項目
    // ==========================================
    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    // ==========================================
    // 外部への出力時に隠す項目
    // ==========================================
    protected $hidden = [
        'password',
        'remember_token',
    ];


    // ==========================================
    // データ型の変換設定
    // ==========================================
    protected function casts(): array
    {
        return [
            // メールアドレスの確認日時を日時型として扱う
            'email_verified_at' => 'datetime',

            // パスワードをハッシュ化して保存する
            'password' => 'hashed',
        ];
    }


    // ==========================================
    // ユーザーの食事記録とのリレーション
    // ==========================================
    public function posts()
    {
        // このユーザーの食事記録を新しい順に取得する
        return $this->hasMany(Post::class)->latest();
    }


    // ==========================================
    // 栄養士が行った評価とのリレーション
    // ==========================================
    public function evaluations()
    {
        // このユーザーが栄養士として行った評価を取得する
        // nutritionist_idを使って評価データと紐付ける
        return $this->hasMany(Evaluation::class, 'nutritionist_id');
    }
}