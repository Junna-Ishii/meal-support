@extends('layouts.nutritionist')

@section('title', '評価結果')

@section('content')

    <div class="container">

        <h1 class="mb-4">評価結果</h1>


        {{-- ユーザープロフィール --}}
        <div class="d-flex align-items-center mb-4">

            {{-- ユーザーアイコン --}}
            <a href="{{ route('nutritionist.user.profile.show', $evaluation->post->user->id) }}" class="text-decoration-none">

                @if ($evaluation->post->user->avatar)
                    <img src="{{ $evaluation->post->user->avatar }}" alt="{{ $evaluation->post->user->name }}"
                        class="rounded-circle avatar-md">
                @else
                    <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                @endif

            </a>


            {{-- ユーザー名 --}}
            <div class="ms-3">

                <a href="{{ route('nutritionist.user.profile.show', $evaluation->post->user->id) }}"
                    class="text-decoration-none text-dark">

                    <h4 class="mb-0">
                        {{ $evaluation->post->user->name }} さんの食事記録
                    </h4>

                </a>
            </div>
        </div>


        {{-- 食事内容 --}}
        <div class="card mb-4">

            <div class="card-body">

                <h5 class="fw-bold">
                    食事内容
                </h5>

                <p class="mb-0">
                    {{ $evaluation->post->meal_content }}
                </p>

            </div>
        </div>


        {{-- 栄養士からの評価 --}}
        <div class="card mb-4">

            <div class="card-body">

                <h5 class="fw-bold mb-3">
                    🥗 栄養士からの評価
                </h5>


                {{-- 星評価 --}}
                <div class="mb-3">
                    ⭐ {{ $evaluation->rating }}
                </div>


                {{-- コメント --}}
                <div class="mb-3">

                    <div class="fw-bold">
                        コメント
                    </div>

                    <p class="mt-2">
                        {{ $evaluation->comment }}
                    </p>

                </div>


                {{-- 評価日時 --}}
                <div class="text-muted small">

                    評価日時：
                    {{ $evaluation->created_at->format('Y/m/d H:i') }}

                </div>
            </div>
        </div>


        {{-- 編集 --}}
        <a href="{{ route('nutritionist.evaluation.edit', $evaluation->id) }}" class="btn btn-outline-secondary">
            評価を編集
        </a>


        {{-- 戻る --}}
        <a href="{{ route('nutritionist.home') }}" class="btn btn-secondary ms-2">
            ダッシュボードに戻る
        </a>

    </div>

@endsection
