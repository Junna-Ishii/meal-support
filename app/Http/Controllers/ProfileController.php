<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Imagick;
use Throwable;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    // ==========================================
    // 一般ユーザーのプロフィール表示
    // ==========================================
    public function show($id)
    {
        $user = $this->user->findOrFail($id);

        return view('users.profile.show')
            ->with('user', $user);
    }


    // ==========================================
    // 一般ユーザーのプロフィール編集画面
    // ==========================================
    public function edit()
    {
        $user = $this->user->findOrFail(Auth::id());

        // 編集画面にユーザー情報を渡す
        return view('users.profile.edit')
            ->with('user', $user);
    }


    // ==========================================
    // 一般ユーザーのプロフィール更新
    // ==========================================
    public function update(Request $request)
    {
        $user = $this->updateProfile($request);

        // 更新に失敗した場合はエラー画面への戻り先を返す
        if ($user instanceof \Illuminate\Http\RedirectResponse) {
            return $user;
        }

        return redirect()->route('profile.show', $user->id);
    }


    // ==========================================
    // 栄養士のプロフィール表示
    // ==========================================
    public function nutritionistShow($id)
    {
        // 栄養士のアカウントだけを取得する
        $user = $this->user
            ->where('role_id', 1)
            ->findOrFail($id);

        return view('nutritionists.profile.show')
            ->with('user', $user);
    }


    // ==========================================
    // 一般ユーザーが栄養士のプロフィールを見る
    // ==========================================
    public function nutritionistShowForUser($id)
    {
        // 栄養士のアカウントだけを取得する
        $user = $this->user
            ->where('role_id', 1)
            ->findOrFail($id);

        // 栄養士のプロフィール画面に情報を渡す
        return view('users.profile.nutritionist-show')
            ->with('user', $user);
    }


    // ==========================================
    // 栄養士がユーザーのプロフィールを見る
    // ==========================================
    public function nutritionistUserShow($id)
    {
        // 一般ユーザーのアカウントだけを取得する
        $user = $this->user
            ->where('role_id', 2)
            ->findOrFail($id);

        // ユーザーのプロフィール画面に情報を渡す
        return view('nutritionists.profile.user-show')
            ->with('user', $user);
    }


    // ==========================================
    // 栄養士のプロフィール編集画面
    // ==========================================
    public function nutritionistEdit()
    {
        $user = $this->user->findOrFail(Auth::id());

        // 編集画面にユーザー情報を渡す
        return view('nutritionists.profile.edit')
            ->with('user', $user);
    }


    // ==========================================
    // 栄養士のプロフィール更新
    // ==========================================
    public function nutritionistUpdate(Request $request)
    {
        $user = $this->updateProfile($request);

        // 更新に失敗した場合はエラー画面への戻り先を返す
        if ($user instanceof \Illuminate\Http\RedirectResponse) {
            return $user;
        }

        return redirect()->route('nutritionist.profile.show', $user->id);
    }


    // ==========================================
    // プロフィール更新の共通処理
    // ==========================================
    private function updateProfile(Request $request)
    {
        // 入力内容を検証する
        $request->validate([
            'name' => 'required|min:1|max:255',
            'email' => 'required|email|max:50|unique:users,email,' . Auth::id(),
            'avatar' => 'nullable|file|max:5120',
            'introduction' => 'nullable|max:100',
        ], [
            'name.required' => '名前を入力してください。',
            'name.min' => '名前を入力してください。',
            'name.max' => '名前は255文字以内で入力してください。',
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'email.max' => 'メールアドレスは50文字以内で入力してください。',
            'email.unique' => 'このメールアドレスはすでに使用されています。',
            'avatar.max' => 'プロフィール画像は5MB以下にしてください。',
            'introduction.max' => '自己紹介は500文字以内で入力してください。',
        ]);

        $user = $this->user->findOrFail(Auth::id());

        // 新しい画像の保存先を記録する変数
        $newPath = null;

        // 画像が送信された場合
        if ($request->hasFile('avatar')) {

            // アップロードされた画像を取得する
            $image = $request->file('avatar');

            // 拡張子と画像形式を取得する
            $extension = strtolower($image->getClientOriginalExtension());
            $mimeType = $image->getMimeType();

            if (in_array($extension, ['heic', 'heif'])) {

                // Imagickで画像を読み込み、JPEGに変換する
                try {
                    $imagick = new Imagick($image->getRealPath());

                    // 先頭の画像を選択する
                    $imagick->setIteratorIndex(0);

                    // 実際の画像形式を確認する
                    $format = strtolower($imagick->getImageFormat());

                    if (!in_array($format, ['heic', 'heif'])) {
                        $imagick->clear();
                        $imagick->destroy();

                        return back()
                            ->withInput()
                            ->withErrors([
                                'avatar' => '有効なHEIC・HEIF画像を選択してください。',
                            ]);
                    }

                    // JPEG形式に変換する
                    $imagick->setImageFormat('jpeg');
                    $imagick->setImageCompressionQuality(85);

                    // 保存先のファイル名を作成する
                    $filename = uniqid() . '.jpg';
                    $newPath = 'avatars/' . $filename;

                    // 変換した画像を保存する
                    $saved = Storage::disk('public')->put(
                        $newPath,
                        $imagick->getImageBlob()
                    );

                    // 画像データを解放する
                    $imagick->clear();
                    $imagick->destroy();

                    // 保存に失敗した場合
                    if (!$saved) {
                        return back()
                            ->withInput()
                            ->withErrors([
                                'avatar' => '画像を保存できませんでした。もう一度お試しください。',
                            ]);
                    }
                } catch (Throwable $e) {
                    // 変換中にエラーが発生した場合
                    return back()
                        ->withInput()
                        ->withErrors([
                            'avatar' => '画像を読み込めませんでした。別の画像を選択してください。',
                        ]);
                }
            } else {

                // JPEG・PNG・GIF以外の画像は受け付けない
                if (!in_array($mimeType, [
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                ])) {
                    return back()
                        ->withInput()
                        ->withErrors([
                            'avatar' => 'JPEG、PNG、GIF、HEIC、HEIF形式の画像を選択してください。',
                        ]);
                }

                // 対応する画像を保存する
                $newPath = $image->store('avatars', 'public');

                // 保存に失敗した場合
                if (!$newPath) {
                    return back()
                        ->withInput()
                        ->withErrors([
                            'avatar' => '画像を保存できませんでした。もう一度お試しください。',
                        ]);
                }
            }
        }

        // 古いプロフィール画像の保存先を記録する
        $oldAvatar = $user->avatar;

        // 基本情報を更新する
        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;

        // 新しい画像が保存されている場合は保存先を更新する
        if ($newPath) {
            $user->avatar = $newPath;
        }

        // プロフィール情報をデータベースに保存する
        $user->save();

        // 新しい画像の保存とプロフィール更新が成功した後に古い画像を削除する
        if (
            $newPath
            && $oldAvatar
            && $oldAvatar !== $newPath
        ) {
            Storage::disk('public')->delete($oldAvatar);
        }

        return $user;
    }
}