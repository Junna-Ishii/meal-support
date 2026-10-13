<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Imagick;

class PostController extends Controller
{
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }


    // ==========================================
    // 食事記録の作成画面
    // ==========================================
    public function create()
    {
        return view('users.posts.create');
    }


    // ==========================================
    // 画像を確認して保存する
    // ==========================================
    private function saveImage($image)
    {
        // 拡張子と画像形式を取得する
        $extension = strtolower($image->getClientOriginalExtension());
        $mimeType = $image->getMimeType();

        // HEIC・HEIF形式の場合はJPEGに変換する
        if (in_array($extension, ['heic', 'heif'])) {

            // Imagickで画像を読み込む
            $imagick = new Imagick($image->getRealPath());

            // 先頭の画像を選択する
            $imagick->setIteratorIndex(0);

            // 実際の画像形式を確認する
            $format = strtolower($imagick->getImageFormat());

            // HEIC・HEIF以外の画像は受け付けない
            if (!in_array($format, ['heic', 'heif'])) {
                $imagick->clear();
                $imagick->destroy();

                return false;
            }

            // JPEG形式に変換する
            $imagick->setImageFormat('jpeg');

            // 画像の品質を設定する
            $imagick->setImageCompressionQuality(85);

            // 保存先のファイル名を作成する
            $filename = uniqid() . '.jpg';
            $path = 'posts/' . $filename;

            // 変換した画像を保存する
            $saved = Storage::disk('public')->put(
                $path,
                $imagick->getImageBlob()
            );

            // 画像データを解放する
            $imagick->clear();
            $imagick->destroy();

            if (!$saved) {
                return false;
            }

            return $path;
        }

        // JPEG・PNG・GIF以外の画像は受け付けない
        if (!in_array($mimeType, [
            'image/jpeg',
            'image/png',
            'image/gif',
        ])) {
            return false;
        }

        return $image->store('posts', 'public');
    }


    // ==========================================
    // 食事記録の新規保存
    // ==========================================
    public function store(Request $request)
    {
        // 入力内容を検証する
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|file|max:5120',
            'meal_content' => 'nullable|max:1000',
            'comment' => 'nullable|max:1000',
        ], [
            'category_id.required' => 'カテゴリーを選択してください。',
            'category_id.exists' => '選択したカテゴリーが存在しません。',
            'image.required' => '画像を選択してください。',
            'image.max' => '画像は5MB以下にしてください。',
            'meal_content.max' => '食事内容は1000文字以内で入力してください。',
            'comment.max' => 'コメントは1000文字以内で入力してください。',
        ]);

        $image = $request->file('image');

        $imagePath = $this->saveImage($image);

        // 対応していない画像の場合は入力画面に戻す
        if (!$imagePath) {
            return back()
                ->withInput()
                ->withErrors([
                    'image' => 'JPEG、PNG、GIF、HEIC、HEIF形式の画像を選択してください。',
                ]);
        }


        $post = new Post();

        // 投稿者と入力内容を設定する
        $post->user_id = Auth::id();
        $post->image = $imagePath;
        $post->meal_content = $request->meal_content;
        $post->comment = $request->comment;

        $post->save();

        // 投稿とカテゴリーを関連付ける
        DB::table('category_post')->insert([
            'category_id' => $request->category_id,
            'post_id' => $post->id,
        ]);

        return redirect()->route('index');
    }


    // ==========================================
    // 食事記録の詳細画面
    // ==========================================
    public function show($id)
    {
        $post = $this->post->findOrFail($id);

        if (
            Auth::user()->role_id != 1
            && Auth::id() != $post->user_id
        ) {
            return redirect()->route('index');
        }

        // 詳細画面に食事記録を渡す
        return view('users.posts.show')
            ->with('post', $post);
    }


    // ==========================================
    // 食事記録の編集画面
    // ==========================================
    public function edit($id)
    {
        $post = $this->post->findOrFail($id);

        if (Auth::id() != $post->user_id) {
            return redirect()->route('index');
        }

        // 編集画面に食事記録を渡す
        return view('users.posts.edit')
            ->with('post', $post);
    }


    // ==========================================
    // 食事記録の更新
    // ==========================================
    public function update(Request $request, $id)
    {
        // 入力内容を検証する
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'meal_content' => 'nullable|max:1000',
            'comment' => 'nullable|max:1000',
            'image' => 'nullable|file|max:5120',
        ], [
            'category_id.required' => 'カテゴリーを選択してください。',
            'category_id.exists' => '選択したカテゴリーが存在しません。',
            'meal_content.max' => '食事内容は1000文字以内で入力してください。',
            'comment.max' => 'コメントは1000文字以内で入力してください。',
            'image.max' => '画像は5MB以下にしてください。',
        ]);

        $post = $this->post->findOrFail($id);

        if (Auth::id() != $post->user_id) {
            return redirect()->route('index');
        }

        // 食事内容とコメントを更新する
        $post->meal_content = $request->meal_content;
        $post->comment = $request->comment;

        // 古い画像の保存先を記録する
        $oldImage = $post->image;

        // 新しい画像が送信された場合
        if ($request->hasFile('image')) {

            // アップロードされた画像を取得する
            $image = $request->file('image');

            $newImage = $this->saveImage($image);

            // 対応していない画像の場合は編集画面に戻す
            if (!$newImage) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'image' => 'JPEG、PNG、GIF、HEIC、HEIF形式の画像を選択してください。',
                    ]);
            }

            // 新しい画像の保存先を設定する
            $post->image = $newImage;
        }

        $post->save();

        // 投稿とカテゴリーの関連付けを更新する
        DB::table('category_post')
            ->where('post_id', $post->id)
            ->delete();

        DB::table('category_post')->insert([
            'category_id' => $request->category_id,
            'post_id' => $post->id,
        ]);

        // 新しい画像への更新が完了した場合、古い画像を削除する
        if (
            $request->hasFile('image')
            && $oldImage
            && $oldImage !== $post->image
        ) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()->route('post.show', $id);
    }


    // ==========================================
    // 食事記録の削除
    // ==========================================
    public function destroy($id)
    {
        $post = $this->post->findOrFail($id);

        if (Auth::id() != $post->user_id) {
            return redirect()->route('index');
        }

        // 削除する画像の保存先を記録する
        $imagePath = $post->image;

        $post->delete();

        // 食事記録の削除後に画像を削除する
        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()->route('index');
    }
}