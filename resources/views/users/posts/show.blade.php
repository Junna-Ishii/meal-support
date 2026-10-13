@extends('layouts.app')

@section('title', '投稿詳細')

@section('content')

    {{-- ==========================================
        投稿全体
    ========================================== --}}

    <div class="row border shadow post-detail user-post-detail">


        {{-- ==========================================
            投稿画像
        ========================================== --}}

        <div class="col p-0 border-end post-image-area user-post-image-area">

            @if ($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="投稿画像 {{ $post->id }}">
            @endif

        </div>


        {{-- ==========================================
            投稿詳細
        ========================================== --}}

        <div class="col-4 px-0 bg-white post-detail-info">

            <div class="card border-0">

                <div class="card-body w-100 post-detail-content user-post-detail-content">


                    {{-- ==========================================
                        カテゴリー
                    ========================================== --}}

                    <div class="row align-items-center">

                        <div class="col text-end">

                            @foreach ($post->categoryPost as $category_post)
                                @php
                                    $categoryClass = match ($category_post->category->name) {
                                        '朝食' => 'bg-warning text-dark',
                                        '昼食' => 'bg-info text-dark',
                                        '夕食' => 'bg-primary text-white',
                                        '間食' => 'bg-success text-white',
                                        default => 'bg-secondary text-white',
                                    };
                                @endphp

                                <span class="badge {{ $categoryClass }}">
                                    {{ $category_post->category->name }}
                                </span>
                            @endforeach

                        </div>

                    </div>


                    {{-- ==========================================
                        食事内容
                    ========================================== --}}

                    @if ($post->meal_content)
                        <div class="mt-3">

                            <div class="fw-bold">
                                食事内容
                            </div>

                            <div>
                                {{ $post->meal_content }}
                            </div>

                        </div>
                    @endif


                    {{-- ==========================================
                        コメント
                    ========================================== --}}

                    @if ($post->comment)
                        <div class="mt-3">

                            <div class="fw-bold">
                                コメント
                            </div>

                            <div>
                                {{ $post->comment }}
                            </div>

                        </div>
                    @endif


                    {{-- ==========================================
                        投稿日
                    ========================================== --}}

                    <p class="text-muted xsmall mt-2">

                        投稿日：
                        {{ $post->created_at->setTimezone('Asia/Tokyo')->format('Y年n月j日 H:i') }}

                    </p>


                    {{-- ==========================================
                        栄養士からの評価
                    ========================================== --}}

                    @if ($post->evaluation)

                        <div class="mt-4 p-3 bg-light rounded">

                            <div class="fw-bold mb-2">
                                🥗 栄養士からの評価
                            </div>

                            {{-- 評価した栄養士のプロフィール --}}
                            <a href="{{ route('nutritionist.profile.public', $post->evaluation->nutritionist->id) }}"
                                class="d-flex align-items-center gap-2 text-decoration-none text-dark mb-3">

                                @if ($post->evaluation->nutritionist->avatar)
                                    <img src="{{ asset('storage/' . $post->evaluation->nutritionist->avatar) }}"
                                        alt="{{ $post->evaluation->nutritionist->name }}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif

                                <span class="fw-bold">
                                    {{ $post->evaluation->nutritionist->name }}

                                </span>

                            </a>

                            {{-- 栄養バランス --}}
                            <div>

                                栄養バランス：
                                {{ str_repeat('⭐', $post->evaluation->rating) }}

                            </div>

                            {{-- 栄養士からのコメント --}}
                            <div class="mt-2">

                                <div class="fw-bold">
                                    栄養士からのコメント
                                </div>

                                <div>
                                    {{ $post->evaluation->comment }}
                                </div>

                                {{-- 栄養士の場合のみ評価を編集できる --}}
                                @if (Auth::user()->role_id == 1)
                                    <a href="{{ route('nutritionist.evaluation.edit', $post->evaluation->id) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        評価を編集
                                    </a>
                                @endif

                            </div>

                            {{-- 評価日時 --}}
                            <div class="text-muted small mt-2">

                                評価日時：
                                {{ $post->evaluation->created_at->setTimezone('Asia/Tokyo')->format('Y年n月j日 H:i') }}

                            </div>

                        </div>

                    @endif


                    {{-- ==========================================
                        コメント一覧
                    ========================================== --}}

                    <div class="mt-4">

                        @if ($post->comments->isNotEmpty())

                            <ul class="list-group mt-2">

                                @foreach ($post->comments as $comment)
                                    <li class="list-group-item border-0 p-0 mb-2">

                                        {{-- コメント投稿者 --}}

                                        <a href="{{ $comment->user->role_id == 1
                                            ? route('nutritionist.profile.public', $comment->user->id)
                                            : route('profile.show', $comment->user->id) }}"
                                            class="text-decoration-none text-dark fw-bold">

                                            {{ $comment->user->name }}

                                        </a>

                                        &nbsp;

                                        {{-- コメント本文 --}}
                                        <p class="d-inline fw-light">
                                            {{ $comment->body }}
                                        </p>

                                        <form action="{{ route('comment.destroy', $comment->id) }}" method="post">

                                            @csrf
                                            @method('DELETE')

                                            {{-- コメント日時 --}}
                                            <span class="text-muted xsmall">

                                                {{ $comment->created_at->setTimezone('Asia/Tokyo')->format('Y年n月j日 H:i') }}

                                            </span>

                                            {{-- 自分のコメントの場合のみ削除できる --}}
                                            @if (Auth::user()->id === $comment->user->id)
                                                &middot;

                                                <button type="submit"
                                                    class="border-0 bg-transparent text-danger p-0 xsmall">
                                                    削除
                                                </button>
                                            @endif

                                        </form>

                                    </li>
                                @endforeach

                            </ul>

                        @endif


                        {{-- ==========================================
                            コメント投稿フォーム
                        ========================================== --}}

                        <form action="{{ route('comment.store', $post->id) }}" method="post">

                            @csrf

                            <div class="input-group">

                                <textarea name="comment_body{{ $post->id }}" cols="30" rows="1" class="form-control form-control-sm"
                                    placeholder="コメントを追加...">{{ old('comment_body' . $post->id) }}</textarea>

                                {{-- 投稿ボタン --}}
                                <button type="submit" class="btn btn-outline-secondary btn-sm" title="コメントを投稿">
                                    <i class="fa-regular fa-paper-plane"></i>
                                </button>

                            </div>

                            {{-- 入力エラー --}}
                            @error('comment_body' . $post->id)
                                <div class="text-danger small">
                                    {{ $message }}
                                </div>
                            @enderror

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
