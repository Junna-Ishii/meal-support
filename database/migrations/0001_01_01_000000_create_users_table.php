<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // ==========================================
    // テーブルの作成
    // ==========================================
    public function up(): void
    {
        // ユーザー情報を保存するテーブル
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // ユーザーの名前
            $table->string('name');

            // メールアドレス（重複不可）
            $table->string('email')->unique();

            // プロフィール画像の保存先
            $table->longText('avatar')->nullable();

            // パスワード
            $table->string('password');

            // 自己紹介（未入力可）
            $table->string('introduction', 100)->nullable();

            // ユーザーの役割（1：栄養士、2：一般ユーザー）
            $table->unsignedBigInteger('role_id')
                ->default(2)
                ->comment('1:栄養士, 2:一般ユーザー');

            $table->timestamps();
        });


        // パスワード再設定用のトークンを保存するテーブル
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });


        // ログインセッションを保存するテーブル
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }


    // ==========================================
    // テーブルの削除
    // ==========================================
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};