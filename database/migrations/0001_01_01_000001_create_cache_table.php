<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * マイグレーションを実行する
     */
    public function up(): void
    {
        // キャッシュを保存するテーブル
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary(); // キャッシュの識別キー
            $table->mediumText('value');      // キャッシュの値
            $table->integer('expiration');    // 有効期限
        });

        // キャッシュのロック情報を保存するテーブル
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary(); // ロックの識別キー
            $table->string('owner');          // ロックの所有者
            $table->integer('expiration');    // ロックの有効期限
        });
    }

    /**
     * マイグレーションを取り消す
     */
    public function down(): void
    {
        // キャッシュ関連のテーブルを削除する
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};