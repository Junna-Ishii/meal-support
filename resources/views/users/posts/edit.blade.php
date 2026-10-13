@extends('layouts.app')

@section('title', '食事記録を編集')

@section('content')

    <form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">

        @csrf
        @method('PATCH')


        {{-- ==========================================
            ページタイトル
        ========================================== --}}
        <h1 class="mb-5">🌾 編集 🌾</h1>


        {{-- ==========================================
            食事カテゴリー
        ========================================== --}}
        <div class="mb-3">

            <label for="category_id" class="form-label fw-bold">

                食事の種類 <span class="text-danger">*</span>

            </label>


            <select name="category_id" id="category_id" class="form-select" required>

                <option value="">
                    選択してください
                </option>


                <option value="1"
                    {{ old('category_id', $post->categoryPost->first()->category_id ?? '') == 1 ? 'selected' : '' }}>
                    朝食
                </option>


                <option value="2"
                    {{ old('category_id', $post->categoryPost->first()->category_id ?? '') == 2 ? 'selected' : '' }}>
                    昼食
                </option>


                <option value="3"
                    {{ old('category_id', $post->categoryPost->first()->category_id ?? '') == 3 ? 'selected' : '' }}>
                    夕食
                </option>


                <option value="4"
                    {{ old('category_id', $post->categoryPost->first()->category_id ?? '') == 4 ? 'selected' : '' }}>
                    間食
                </option>
            </select>


            @error('category_id')
                <div class="text-danger small">

                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- ==========================================
            食事内容
        ========================================== --}}
        <div class="mb-3">

            <label for="meal_content" class="form-label fw-bold">
                食事内容
            </label>

            <textarea name="meal_content" id="meal_content" class="form-control" rows="4"
                placeholder="食べたものを入力してください（例：白米、焼き鮭、サラダ、味噌汁）">{{ old('meal_content', $post->meal_content) }}</textarea>


            @error('meal_content')
                <div class="text-danger small">

                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- ==========================================
            コメント
        ========================================== --}}
        <div class="mb-3">

            <label for="comment" class="form-label fw-bold">
                コメント
            </label>


            <textarea name="comment" id="comment" class="form-control" rows="4"
                placeholder="食事について気になったことや、今日の体調・気分などを自由に入力してください">{{ old('comment', $post->comment) }}</textarea>


            @error('comment')
                <div class="text-danger small">

                    {{ $message }}

                </div>
            @enderror

        </div>


        {{-- ==========================================
            写真
        ========================================== --}}
        <div class="row mb-4">

            <div class="col-12 col-md-6 edit-image-area">

                <label for="image" class="form-label fw-bold">
                    写真
                </label>


                {{-- ==========================================
                    現在の写真

                    DBには「posts/ファイル名」が保存されているため
                    storage/ を付けて表示する
                ========================================== --}}
                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="post id {{ $post->id }}"
                        class="img-thumbnail w-100">
                @endif


                {{-- 新しい写真を選択 --}}
                <input type="file" name="image" id="image" class="form-control mt-1" aria-describedby="image-info">


                <div id="image-info" class="form-text">
                    JPEG、JPG、PNG、GIF、HEIC、HEIF形式に対応しています。
                    <br>
                    ファイルサイズは最大5MB

                </div>


                @error('image')
                    <div class="text-danger small">

                        {{ $message }}

                    </div>
                @enderror

            </div>

        </div>


        {{-- ==========================================
            保存
        ========================================== --}}
        <button type="submit" class="btn btn-warning px-5">
            保存
        </button>

    </form>

@endsection
