@extends('layouts.app')

@section('title', '栄養士プロフィール')

@section('content')

    <div class="row profile-header align-items-start">

        {{-- プロフィール画像 --}}
        <div class="col-12 col-md-4 profile-header-image">

            @if ($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                    class="thumbnail rounded-circle d-block mx-auto avatar-lg">
            @else
                <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-lg"></i>
            @endif

        </div>

        {{-- プロフィール情報 --}}
        <div class="col-12 col-md-8 profile-header-info">

            <h2 class="display-6 mb-2">
                {{ $user->name }}
            </h2>

            <p class="text-muted mb-3">
                栄養士
            </p>

            <p>
                評価した食事：
                <strong>{{ $user->evaluations->count() }}</strong> 件
            </p>

            @if ($user->introduction)
                <div class="fw-bold">
                    {{ $user->introduction }}
                </div>
            @endif

        </div>

    </div>

@endsection
