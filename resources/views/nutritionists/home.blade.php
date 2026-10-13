@extends('layouts.nutritionist')

@section('title', '栄養士ダッシュボード')

@section('content')

    <div class="container">

        <h1 class="mb-4">栄養士ダッシュボード</h1>

        <p class="text-muted">
            ユーザーの食事記録を確認・評価します。
        </p>


        {{-- ==================================================
        件数
        ================================================== --}}
        <div class="mb-4">

            <span class="me-4">
                <span class="badge bg-danger">未評価</span>
                {{ $unevaluated_count }}件
            </span>

            <span>
                <span class="badge bg-success">評価済み</span>
                {{ $evaluated_count }}件
            </span>

        </div>


        {{-- ==================================================
        食事記録
        ================================================== --}}
        <h2 class="h4 mb-3">
            食事記録
        </h2>


        @foreach ($posts as $post)
            <div class="card mb-3">

                <div class="card-body">


                    {{-- ==================================================
                    ユーザー情報
                    評価済み・未評価どちらでも表示
                    ================================================== --}}
                    <div class="d-flex align-items-center mb-3">

                        {{-- ユーザーアイコン --}}
                        <a href="{{ route('nutritionist.user.profile.show', $post->user->id) }}"
                            class="text-decoration-none">

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

                                <h5 class="mb-0">
                                    {{ $post->user->name }}
                                </h5>

                            </a>

                        </div>

                    </div>


                    {{-- ==================================================
                        カテゴリー
                        朝食・昼食・夕食・間食
                        カテゴリーごとに色を変更
                        ================================================== --}}
                    @if ($post->categoryPost->isNotEmpty())
                        <div class="mb-3">

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
                                    <span class="badge bg-success text-dark me-1">
                                        {{ $category_post->category->name }}
                                    </span>
                                @endif
                            @endforeach

                        </div>
                    @endif


                    {{-- ==================================================
                    食事内容
                    ================================================== --}}
                    <p>
                        <strong>食事内容：</strong>
                        {{ $post->meal_content }}
                    </p>


                    {{-- ==================================================
                    投稿日時
                    ================================================== --}}
                    <p class="text-muted small">

                        投稿日時：
                        {{ $post->created_at->format('Y/m/d H:i') }}

                    </p>


                    {{-- ==================================================
                    評価済み
                    ================================================== --}}
                    @if ($post->evaluation)
                        <div class="mt-3 p-3 bg-light rounded">


                            {{-- 評価詳細へのリンク --}}
                            <a href="{{ route('nutritionist.post.show', $post->id) }}"
                                class="text-decoration-none text-dark">

                                {{-- 栄養士からの評価 --}}
                                <div class="fw-bold mb-2">

                                    🥗 栄養士からの評価

                                </div>


                                {{-- 星評価 --}}
                                <div>

                                    栄養バランス：
                                    {{ str_repeat('⭐', $post->evaluation->rating) }}

                                </div>


                                {{-- 評価コメント --}}
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
                                    {{ $post->evaluation->created_at->format('Y/m/d H:i') }}

                                </div>

                            </a>


                            {{-- 評価を編集 --}}
                            <div class="mt-2">

                                <a href="{{ route('nutritionist.evaluation.edit', $post->evaluation->id) }}"
                                    class="btn btn-outline-secondary btn-sm">
                                    評価を編集
                                </a>

                            </div>
                        </div>


                        {{-- ==================================================
                    未評価
                    ================================================== --}}
                    @else
                        <div class="mt-3">

                            <span class="badge bg-danger">
                                未評価
                            </span>


                            <div class="mt-2">

                                <a href="{{ route('nutritionist.evaluation.create', $post->id) }}" class="btn btn-primary">
                                    評価する
                                </a>

                            </div>
                        </div>
                    @endif


                </div>

            </div>
        @endforeach

    </div>

@endsection
