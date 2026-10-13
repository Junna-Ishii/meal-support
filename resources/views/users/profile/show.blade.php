@extends('layouts.app')

@section('title', 'プロフィール')

@section('content')

    {{-- ==========================================
        プロフィール
    ========================================== --}}
    @include('users.profile.header')


    {{-- ==========================================
        過去の食事記録
    ========================================== --}}
    <div class="profile-posts">

        <h3 class="mb-4">
            過去の食事記録
        </h3>


        @if ($user->posts->isNotEmpty())

            <div class="row g-3">

                @foreach ($user->posts as $post)
                    <div class="col-4">

                        <a href="{{ route('post.show', $post->id) }}" class="d-block">

                            {{-- 食事写真 --}}
                            <img src="{{ asset('storage/' . $post->image) }}" alt="投稿画像{{ $post->id }}" class="grid-img">

                        </a>

                    </div>
                @endforeach

            </div>
        @else
            <div class="text-center text-secondary py-5">

                <p>
                    まだ食事記録がありません。
                </p>

            </div>

        @endif

    </div>

@endsection
