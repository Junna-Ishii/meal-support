@extends('layouts.app')

@section('title', 'ホーム')

@section('content')

    <div class="row gx-5 justify-content-center">

        {{-- ==========================================
            投稿一覧
        ========================================== --}}
        <div class="col-12 col-md-8">

            @forelse ($home_posts as $post)
                <div class="card mb-4">

                    {{-- ユーザー情報 --}}
                    @include('users.posts.contents.title')

                    {{-- 食事記録 --}}
                    @include('users.posts.contents.body')

                </div>

            @empty

                {{-- まだ食事記録がない場合 --}}
                <div class="text-center">

                    <h2>
                        食事記録を投稿してみましょう
                    </h2>

                    <p class="text-secondary">

                        食事記録を投稿すると、
                        ここに表示されます。

                    </p>

                    <a href="{{ route('post.create') }}" class="text-decoration-none">

                        最初の食事記録を投稿する

                    </a>

                </div>
            @endforelse

        </div>

    </div>

@endsection
