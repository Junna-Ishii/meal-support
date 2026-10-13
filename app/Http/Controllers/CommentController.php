<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * コメントを保存する
     */
    public function store(Request $request, $post_id)
    {
        // 投稿が存在するか確認する
        $post = Post::findOrFail($post_id);

        // コメントの入力チェック
        $request->validate([
            'comment_body' . $post_id => 'required|max:250',
        ]);

        // コメントを保存する
        $this->comment->body = $request->input('comment_body' . $post_id);
        $this->comment->user_id = Auth::id();
        $this->comment->post_id = $post->id;
        $this->comment->save();

        // ログインユーザーの役割に応じて投稿詳細へ戻る
        if (Auth::user()->role_id == 1) {
            return redirect()->route('nutritionist.post.show', $post->id);
        }

        return redirect()->route('post.show', $post->id);
    }

    /**
     * コメントを削除する
     */
    public function destroy($id)
    {
        // 削除対象のコメントを取得する
        $comment = $this->comment->findOrFail($id);

        // 自分のコメント以外は削除できないようにする
        if ($comment->user_id != Auth::id()) {
            abort(403);
        }

        $comment->delete();

        return redirect()->back();
    }
}