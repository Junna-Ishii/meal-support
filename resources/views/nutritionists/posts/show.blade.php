@extends('layouts.nutritionist')

@section('title', '食事記録')

@section('content')

    <div class="row border shadow post-detail nutritionist-post-detail">

        {{-- ==========================================
            投稿画像
        ========================================== --}}

        <div class="col p-0 border-end post-image-area nutritionist-post-image-area">

            @if ($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="食事写真{{ $post->id }}">
            @endif

        </div>


        {{-- ==========================================
            投稿詳細
        ========================================== --}}

        <div class="col-4 px-0 bg-white post-detail-area nutritionist-post-detail-area">

            <div class="card border-0">

                {{-- ==========================================
                    ユーザー情報
                ========================================== --}}

                <div class="card-header bg-white py-3">

                    <div class="row align-items-center">

                        <div class="col-auto">

                            <a href="{{ route('nutritionist.user.profile.show', $post->user->id) }}">

                                @if ($post->user->avatar)
                                    <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="{{ $post->user->name }}"
                                        class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif

                            </a>

                        </div>

                        <div class="col ps-0">

                            <a href="{{ route('nutritionist.user.profile.show', $post->user->id) }}"
                                class="text-decoration-none text-dark">

                                {{ $post->user->name }}

                            </a>

                        </div>

                    </div>
                </div>


                {{-- ==========================================
                    投稿内容
                ========================================== --}}

                <div class="card-body w-100">

                    {{-- ==========================================
                        カテゴリー
                    ========================================== --}}

                    @if ($post->categoryPost->isNotEmpty())

                        <div class="row align-items-center mb-3">

                            <div class="col text-end">

                                @foreach ($post->categoryPost as $category_post)
                                    @if ($category_post->category->name === '朝食')
                                        <span class="badge bg-warning text-dark me-1">

                                            {{ $category_post->category->name }}

                                        </span>
                                    @elseif ($category_post->category->name === '昼食')
                                        <span class="badge bg-info text-dark me-1">

                                            {{ $category_post->category->name }}

                                        </span>
                                    @elseif ($category_post->category->name === '夕食')
                                        <span class="badge bg-primary me-1">

                                            {{ $category_post->category->name }}

                                        </span>
                                    @elseif ($category_post->category->name === '間食')
                                        <span class="badge bg-success me-1">

                                            {{ $category_post->category->name }}

                                        </span>
                                    @endif
                                @endforeach

                            </div>

                        </div>

                    @endif


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
                        投稿時のコメント
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


                            {{-- 星評価 --}}
                            <div>
                                栄養バランス：
                                {{ str_repeat('⭐', $post->evaluation->rating) }}
                            </div>


                            {{-- 栄養士コメント --}}
                            <div class="mt-2">

                                <div class="fw-bold">
                                    栄養士からのコメント
                                </div>

                                <div>
                                    {{ $post->evaluation->comment }}
                                </div>

                            </div>


                            {{-- 評価日時 --}}
                            <div class="text-muted small mt-2">
                                評価日時：
                                {{ $post->evaluation->created_at->setTimezone('Asia/Tokyo')->format('Y年n月j日 H:i') }}
                            </div>


                            {{-- 評価編集 --}}
                            <div class="mt-2">

                                <a href="{{ route('nutritionist.evaluation.edit', $post->evaluation->id) }}"
                                    class="btn btn-outline-primary btn-sm">
                                    評価を編集
                                </a>

                            </div>

                        </div>
                    @else
                        {{-- ==========================================
                            まだ評価していない場合
                        ========================================== --}}

                        <div class="mt-4">

                            <a href="{{ route('nutritionist.evaluation.create', $post->id) }}" class="btn btn-primary">
                                この食事を評価する
                            </a>

                        </div>
                    @endif


                    {{-- ==========================================
                        コメント一覧
                    ========================================== --}}

                    <div class="mt-4">

                        <div class="fw-bold mb-2">
                            コメント
                        </div>


                        @if ($post->comments->isNotEmpty())

                            <ul class="list-group mt-2">

                                @foreach ($post->comments as $comment)
                                    <li class="list-group-item border-0 p-0 mb-3">

                                        {{-- コメント投稿者の名前 --}}

                                        <span class="text-dark fw-bold">

                                            {{ $comment->user->name }}
                                        </span>
                                        &nbsp;

                                        {{-- コメント本文 --}}

                                        <p class="d-inline fw-light">

                                            {{ $comment->body }}

                                        </p>


                                        {{-- コメント日時・削除 --}}

                                        <div>

                                            <span class="text-muted xsmall">

                                                {{ $comment->created_at->setTimezone('Asia/Tokyo')->format('Y年n月j日 H:i') }}

                                            </span>


                                            {{-- 自分のコメントだけ削除できる --}}

                                            @if (Auth::user()->id === $comment->user->id)
                                                &middot;

                                                <form action="{{ route('comment.destroy', $comment->id) }}" method="post"
                                                    class="d-inline">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="border-0 bg-transparent text-danger p-0 xsmall">
                                                        削除
                                                    </button>

                                                </form>
                                            @endif

                                        </div>

                                    </li>
                                @endforeach

                            </ul>

                        @endif


                        {{-- ==========================================
                            コメント投稿フォーム
                        ========================================== --}}

                        <form action="{{ route('comment.store', $post->id) }}" method="post" class="mt-3">

                            @csrf

                            <div class="input-group">

                                <textarea name="comment_body{{ $post->id }}" cols="30" rows="1" class="form-control form-control-sm"
                                    placeholder="コメントを追加...">{{ old('comment_body' . $post->id) }}</textarea>


                                <button type="submit" class="btn btn-outline-secondary btn-sm" title="コメントを投稿">

                                    <i class="fa-regular fa-paper-plane"></i>

                                </button>

                            </div>


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
