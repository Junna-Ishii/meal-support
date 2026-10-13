@extends('layouts.nutritionist')

@section('title', '食事を評価する')

@section('content')

    <div class="container">

        <h1 class="mb-4">
            食事を評価する
        </h1>


        {{-- ==========================================
            ユーザープロフィール
        ========================================== --}}
        <div class="d-flex align-items-center mb-4">

            {{-- ユーザーアイコン --}}
            <a href="{{ route('nutritionist.user.profile.show', $post->user->id) }}" class="text-decoration-none">

                @if ($post->user->avatar)
                    <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="{{ $post->user->name }}"
                        class="rounded-circle avatar-md">
                @else
                    <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                @endif

            </a>


            {{-- ユーザー名 --}}
            <div class="ms-3">

                <a href="{{ route('nutritionist.user.profile.show', $post->user->id) }}"
                    class="text-decoration-none text-dark">

                    <h2 class="h5 mb-0">
                        {{ $post->user->name }}さんの食事
                    </h2>

                </a>

            </div>

        </div>


        {{-- ==========================================
            食事内容
        ========================================== --}}
        <div class="card mb-4">

            <div class="card-body">

                <h3 class="h6">
                    食事内容
                </h3>

                <p>
                    {{ $post->meal_content }}
                </p>


                {{-- ユーザーからのコメント --}}
                @if ($post->comment)
                    <h3 class="h6 mt-3">
                        ユーザーからのコメント
                    </h3>

                    <p>
                        {{ $post->comment }}
                    </p>
                @endif


                @if ($post->image)
                    <div class="evaluation-image-area">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="食事写真">
                    </div>
                @endif

            </div>

        </div>


        {{-- ==========================================
            評価フォーム
        ========================================== --}}
        <form action="{{ route('nutritionist.evaluation.store', $post->id) }}" method="post">

            @csrf


            {{-- 星評価 --}}
            <div class="mb-3">

                <label for="rating" class="form-label">
                    栄養バランス
                </label>


                <select name="rating" id="rating" class="form-select">

                    <option value="">
                        評価を選択してください
                    </option>

                    <option value="1">
                        ⭐ 1
                    </option>

                    <option value="2">
                        ⭐ 2
                    </option>

                    <option value="3">
                        ⭐ 3
                    </option>

                    <option value="4">
                        ⭐ 4
                    </option>

                    <option value="5">
                        ⭐ 5
                    </option>

                </select>


                @error('rating')
                    <div class="text-danger small">
                        評価を選択してください。
                    </div>
                @enderror

            </div>


            {{-- 栄養士からのコメント --}}
            <div class="mb-4">

                <label for="comment" class="form-label">
                    栄養士からのコメント
                </label>


                <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="食事についてアドバイスを入力してください">{{ old('comment') }}</textarea>


                @error('comment')
                    <div class="text-danger small">
                        コメントを入力してください。
                    </div>
                @enderror

            </div>


            {{-- 保存 --}}
            <button type="submit" class="btn btn-primary">

                評価を保存する

            </button>

        </form>

    </div>

@endsection
