@extends('layouts.nutritionist')

@section('title', 'ユーザープロフィール')

@section('content')

    <div class="container">

        {{-- ==========================================
            プロフィール
        ========================================== --}}
        <div class="row mb-5">

            {{-- プロフィール画像 --}}
            <div class="col-4">

                @if ($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                        class="thumbnail rounded-circle d-block mx-auto avatar-lg">
                @else
                    <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-lg"></i>
                @endif

            </div>


            {{-- プロフィール情報 --}}
            <div class="col-8">

                <h2 class="display-6 mb-1">
                    {{ $user->name }}
                </h2>

                <p class="text-muted mb-3">
                    ユーザー
                </p>


                <div class="row mb-3">

                    <div class="col-auto">
                        食事記録
                        <strong>
                            {{ $user->posts->count() }}
                        </strong>
                        件
                    </div>

                </div>


                {{-- 自己紹介 --}}
                @if ($user->introduction)
                    <p class="fw-bold">
                        {{ $user->introduction }}
                    </p>
                @endif

            </div>

        </div>


        {{-- ==========================================
            過去の食事記録
        ========================================== --}}
        <h2 class="h4 mb-4">
            過去の食事記録
        </h2>


        @if ($user->posts->isNotEmpty())

            <div class="row">

                @foreach ($user->posts as $post)
                    <div class="col-4 mb-4">

                        <a href="{{ route('nutritionist.post.show', $post->id) }}">

                            @if ($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="食事写真{{ $post->id }}"
                                    class="grid-img">
                            @endif

                        </a>

                    </div>
                @endforeach

            </div>
        @else
            <h3 class="text-muted text-center">
                まだ食事記録がありません
            </h3>

        @endif

    </div>

@endsection
