@extends('layouts.app')

@section('title', 'ログイン')

@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-7 col-lg-6">

            {{-- Meal Support --}}
            <div class="text-center mb-2">

                <img src="{{ asset('images/image.png') }}"
                    alt="Meal Support"
                    style="width: 180px; height: auto;">

                <p class="text-muted mt-3 mb-0">
                    毎日の食事を記録して、<br>
                    栄養士からアドバイスをもらおう。
                </p>

            </div>


            {{-- Login Card --}}
            <div class="card shadow-sm">

                <div class="card-header text-center bg-white py-3">

                    <h2 class="h5 mb-0">
                        ログイン
                    </h2>

                </div>


                <div class="card-body p-4">

                    {{-- Login Form --}}
                    <form method="POST" action="{{ route('login') }}">

                        @csrf


                        {{-- Email --}}
                        <div class="mb-3">

                            <label for="email" class="form-label">
                                メールアドレス
                            </label>

                            <input id="email"
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                autofocus>

                            @error('email')

                                <span class="invalid-feedback" role="alert">

                                    <strong>{{ $message }}</strong>

                                </span>

                            @enderror

                        </div>


                        {{-- Password --}}
                        <div class="mb-3">

                            <label for="password" class="form-label">
                                パスワード
                            </label>

                            <input id="password"
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password"
                                required
                                autocomplete="current-password">

                            @error('password')

                                <span class="invalid-feedback" role="alert">

                                    <strong>{{ $message }}</strong>

                                </span>

                            @enderror

                        </div>


                        {{-- Login Button --}}
                        <div class="d-grid mt-4">

                            <button type="submit" class="btn btn-success">

                                ログイン

                            </button>

                        </div>

                    </form>


                    {{-- Register --}}
                    @if (Route::has('register'))

                        <div class="text-center mt-4">

                            <p class="text-muted mb-2">
                                アカウントをお持ちでない方
                            </p>

                            <a href="{{ route('register') }}"
                                class="btn btn-outline-secondary">

                                新規登録

                            </a>

                        </div>

                    @endif


                    {{-- Divider --}}
                    <div class="d-flex align-items-center my-4">

                        <hr class="flex-grow-1">

                        <span class="mx-3 text-muted small">
                            または
                        </span>

                        <hr class="flex-grow-1">

                    </div>


                    {{-- Trial Login --}}
                    <div class="text-center">

                        <p class="mb-2">
                            🌱 まずはお試しで使ってみる
                        </p>

                        <p class="text-muted small mb-3">
                            アカウント登録なしでMeal Supportを体験できます。
                        </p>


                        {{-- 一般ユーザーとして試す --}}
                        <div class="d-grid mb-2">

                            <a href="{{ route('trial.user') }}"
                                class="btn btn-outline-success">

                                一般ユーザーとして試す

                            </a>

                        </div>


                        {{-- 栄養士として試す --}}
                        <div class="d-grid">

                            <a href="{{ route('trial.nutritionist') }}"
                                class="btn btn-outline-success">

                                栄養士として試す

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection