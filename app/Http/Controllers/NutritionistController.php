<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class NutritionistController extends Controller
{
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }


    // ==========================================
    // 栄養士のホーム画面
    // ==========================================
    public function home()
    {
        // 投稿と投稿者、評価データを取得し、新しい投稿から順番に並べる
        $posts = $this->post->with('user', 'evaluation')->latest()->get();

        // 評価がまだ付いていない投稿の件数を数える
        $unevaluated_count = $posts->whereNull('evaluation')->count();

        // 評価済みの投稿の件数を数える
        $evaluated_count = $posts->whereNotNull('evaluation')->count();

        // ホーム画面に投稿と各件数を渡す
        return view('nutritionists.home')
            ->with('posts', $posts)
            ->with('unevaluated_count', $unevaluated_count)
            ->with('evaluated_count', $evaluated_count);
    }


    // ==========================================
    // 投稿の詳細画面
    // ==========================================
    public function show($post_id)
    {
        // 指定された投稿と投稿者、評価データを取得する
        // 投稿が存在しない場合は404エラーを返す
        $post = $this->post
            ->with('user', 'evaluation')
            ->findOrFail($post_id);

        // 投稿の詳細画面に投稿データを渡す
        return view('nutritionists.posts.show')
            ->with('post', $post);
    }


    // ==========================================
    // 評価の新規作成画面
    // ==========================================
    public function create($post_id)
    {
        // 指定された投稿を取得する
        // 投稿が存在しない場合は404エラーを返す
        $post = $this->post->findOrFail($post_id);

        // すでに評価済みの場合はホーム画面に戻す
        // 1つの投稿に対して評価は1件までとする
        if ($post->evaluation) {
            return redirect()->route('nutritionist.home');
        }

        // 評価入力画面に投稿データを渡す
        return view('nutritionists.evaluations.create')
            ->with('post', $post);
    }


    // ==========================================
    // 評価の編集画面
    // ==========================================
    public function edit($evaluation_id)
    {
        // 指定された評価を取得する
        // 評価が存在しない場合は404エラーを返す
        $evaluation = Evaluation::findOrFail($evaluation_id);

        // 評価の編集画面に評価データを渡す
        return view('nutritionists.evaluations.edit')
            ->with('evaluation', $evaluation);
    }


    // ==========================================
    // 評価の更新処理
    // ==========================================
    public function update(Request $request, $evaluation_id)
    {
        // 入力された評価とコメントを検証する
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|max:1000',
        ]);

        // 更新する評価を取得する
        // 評価が存在しない場合は404エラーを返す
        $evaluation = Evaluation::findOrFail($evaluation_id);

        // フォームから送信された内容に更新する
        $evaluation->rating = $request->rating;
        $evaluation->comment = $request->comment;

        // 更新した内容をデータベースに保存する
        $evaluation->save();

        // 保存後、栄養士のホーム画面に戻る
        return redirect()->route('nutritionist.home');
    }


    // ==========================================
    // 評価の新規保存処理
    // ==========================================
    public function store(Request $request, $post_id)
    {
        // 入力された評価とコメントを検証する
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|max:1000',
        ]);

        // すでに評価済みの場合はホーム画面に戻す
        // 1つの投稿に対して評価は1件までとする
        if (Evaluation::where('post_id', $post_id)->exists()) {
            return redirect()->route('nutritionist.home');
        }

        // 新しい評価データを作成する
        $evaluation = new Evaluation();

        // 評価対象の投稿IDを設定する
        $evaluation->post_id = $post_id;

        // ログイン中の栄養士のIDを設定する
        $evaluation->nutritionist_id = auth()->user()->id;

        // フォームから送信された評価とコメントを設定する
        $evaluation->rating = $request->rating;
        $evaluation->comment = $request->comment;

        $evaluation->save();

        return redirect()->route('nutritionist.home');
    }
}
