@extends('layouts.app')

@section('title', '食事を記録する')

@section('content')

    {{-- 食事記録をPOSTで送信する --}}
    <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">

        @csrf

        {{-- ページタイトル --}}
        <h1 class="mb-5">🍽️ 新しい食事を記録</h1>


        {{-- ==========================================
            食事カテゴリー
            必須項目
        ========================================== --}}
        <div class="mb-3">

            <label for="category_id" class="form-label">
                食事の種類 <span class="text-danger">*</span>
            </label>

            <select name="category_id" id="category_id" class="form-select" required>

                <option value="">選択してください</option>

                <option value="1" {{ old('category_id') == 1 ? 'selected' : '' }}>
                    朝食
                </option>

                <option value="2" {{ old('category_id') == 2 ? 'selected' : '' }}>
                    昼食
                </option>

                <option value="3" {{ old('category_id') == 3 ? 'selected' : '' }}>
                    夕食
                </option>

                <option value="4" {{ old('category_id') == 4 ? 'selected' : '' }}>
                    間食
                </option>

            </select>


            {{-- 入力エラー --}}
            @error('category_id')
                <div class="text-danger small">
                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- ==========================================
            食事内容
            任意項目
        ========================================== --}}
        <div class="mb-3">

            <label for="meal_content" class="form-label">
                食事内容
            </label>


            <textarea name="meal_content" id="meal_content" class="form-control" rows="3"
                placeholder="食べたものを入力してください（例：白米、焼き鮭、サラダ、味噌汁）">{{ old('meal_content') }}</textarea>


            {{-- 入力エラー --}}
            @error('meal_content')
                <div class="text-danger small">
                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- ==========================================
            コメント
            任意項目
        ========================================== --}}
        <div class="mb-3">

            <label for="comment" class="form-label">
                食事についてのコメント
            </label>


            <textarea name="comment" id="comment" class="form-control" rows="3"
                placeholder="食事について気になったことや、今日の体調・気分などを自由に入力してください">{{ old('comment') }}</textarea>


            {{-- 入力エラー --}}
            @error('comment')
                <div class="text-danger small">
                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- ==========================================
            食事の写真
            必須項目
        ========================================== --}}
        <div class="mb-4">

            <label for="image" class="form-label">
                食事の写真 <span class="text-danger">*</span>
            </label>


            <input type="file" name="image" id="image" class="form-control"
                accept="image/jpeg,image/png,image/gif,image/heic,image/heif" aria-describedby="image-info" required>


            {{-- 写真についての説明 --}}
            <div id="image-info" class="form-text">

                JPEG、JPG、PNG、GIF、HEIC、HEIF形式に対応しています。<br>
                最大ファイルサイズ：5MB

            </div>


            {{-- 入力エラー --}}
            @error('image')
                <div class="text-danger small">
                    写真を選択してください。

                </div>
            @enderror

        </div>


        {{-- ==========================================
            記録ボタン
        ========================================== --}}
        <button type="submit" class="btn btn-primary px-5">

            食事を記録する

        </button>

    </form>

@endsection
