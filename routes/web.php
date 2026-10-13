<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NutritionistController;

Auth::routes();


// ==================================================
// お試しログイン
// ログイン画面から誰でも利用できる
// ==================================================

// 一般ユーザーとして試す
Route::get('/trial/user', function () {

    $user = \App\Models\User::where('email', 'user@example.com')->firstOrFail();

    Auth::login($user);

    return redirect()->route('index');
})->name('trial.user');


// 栄養士として試す
Route::get('/trial/nutritionist', function () {

    $nutritionist = \App\Models\User::where('email', 'nutritionist@example.com')->firstOrFail();

    Auth::login($nutritionist);

    return redirect()->route('nutritionist.home');
})->name('trial.nutritionist');



Route::group(['middleware' => 'auth'], function () {


    // ==================================================
    // 一般ユーザー専用
    // role_id = 2
    // ==================================================

    Route::middleware('role:2')->group(function () {

        // Home
        Route::get('/', [HomeController::class, 'index'])
            ->name('index');


        // ------------------------------
        // Post
        // ------------------------------

        // 投稿作成画面
        Route::get('/post/create', [PostController::class, 'create'])
            ->name('post.create');

        // 投稿保存
        Route::post('/post/store', [PostController::class, 'store'])
            ->name('post.store');

        // 投稿詳細
        Route::get('/post/{id}/show', [PostController::class, 'show'])
            ->name('post.show');

        // 投稿編集画面
        Route::get('/post/{id}/edit', [PostController::class, 'edit'])
            ->name('post.edit');

        // 投稿更新
        Route::patch('/post/{id}/update', [PostController::class, 'update'])
            ->name('post.update');

        // 投稿削除
        Route::delete('/post/{id}/delete', [PostController::class, 'destroy'])
            ->name('post.destroy');


        // ------------------------------
        // Profile
        // ------------------------------

        // プロフィール表示
        Route::get('/profile/{id}/show', [ProfileController::class, 'show'])
            ->name('profile.show');

        // プロフィール編集画面
        Route::get('/profile/edit', [ProfileController::class, 'edit'])
            ->name('profile.edit');

        // プロフィール更新
        Route::patch('/profile/update', [ProfileController::class, 'update'])
            ->name('profile.update');

        // 栄養士のプロフィール表示
        Route::get('/nutritionist/{id}/profile', [ProfileController::class, 'nutritionistShowForUser'])
            ->name('nutritionist.profile.public');
    });



    // ==================================================
    // コメント
    // 一般ユーザー・栄養士 共通
    // ==================================================

    // コメント保存
    Route::post('/post/{post_id}/store', [CommentController::class, 'store'])
        ->name('comment.store');

    // コメント削除
    Route::delete('/comment/{id}/delete', [CommentController::class, 'destroy'])
        ->name('comment.destroy');



    // ==================================================
    // 栄養士専用
    // role_id = 1
    // ==================================================

    Route::middleware('role:1')->group(function () {

        // 栄養士ホーム
        Route::get('/nutritionist/home', [NutritionistController::class, 'home'])
            ->name('nutritionist.home');


        // 栄養士が投稿詳細を見る
        Route::get('/nutritionist/post/{post_id}/show', [NutritionistController::class, 'show'])
            ->name('nutritionist.post.show');


        // ------------------------------
        // 評価
        // ------------------------------

        // 評価作成画面
        Route::get('/nutritionist/post/{post_id}/evaluation/create', [NutritionistController::class, 'create'])
            ->name('nutritionist.evaluation.create');

        // 評価保存
        Route::post('/nutritionist/post/{post_id}/evaluation', [NutritionistController::class, 'store'])
            ->name('nutritionist.evaluation.store');

        // 評価編集画面
        Route::get('/nutritionist/evaluation/{evaluation_id}/edit', [NutritionistController::class, 'edit'])
            ->name('nutritionist.evaluation.edit');

        // 評価更新
        Route::put('/nutritionist/evaluation/{evaluation_id}', [NutritionistController::class, 'update'])
            ->name('nutritionist.evaluation.update');


        // ------------------------------
        // 栄養士プロフィール
        // ------------------------------

        // 栄養士プロフィール表示
        Route::get('/nutritionist/profile/{id}/show', [ProfileController::class, 'nutritionistShow'])
            ->name('nutritionist.profile.show');

        // 栄養士プロフィール編集
        Route::get('/nutritionist/profile/edit', [ProfileController::class, 'nutritionistEdit'])
            ->name('nutritionist.profile.edit');

        // 栄養士プロフィール更新
        Route::patch('/nutritionist/profile/update', [ProfileController::class, 'nutritionistUpdate'])
            ->name('nutritionist.profile.update');

        // ユーザーのプロフィールを見る
        Route::get('/nutritionist/user/{id}/profile', [ProfileController::class, 'nutritionistUserShow'])
            ->name('nutritionist.user.profile.show');
    });
});
