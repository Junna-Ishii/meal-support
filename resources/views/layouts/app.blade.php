<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Fonts --}}
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer">

    {{-- Scripts --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>


<body>

    <div id="app">


        {{-- ==================================================
         ナビバー
    ================================================== --}}
        <nav class="navbar navbar-expand-md navbar-light shadow-sm py-0" style="background-color: #e8f5e0;">

            <div class="container-fluid">


                {{-- ==================================================
                 Meal Support ロゴ
            ================================================== --}}
                <a class="navbar-brand" href="{{ route('index') }}">

                    <img src="{{ asset('images/meal-support-logo.png') }}" alt="Meal Support" class="navbar-logo">

                </a>


                {{-- ==================================================
                 ナビゲーション
            ================================================== --}}
                <div class="navbar-collapse">

                    {{-- ==================================================
                     ログイン中
                ================================================== --}}
                    @auth

                        <ul class="navbar-nav ms-auto align-items-center">


                            {{-- Home --}}
                            <li class="nav-item">

                                <a href="{{ route('index') }}" class="nav-link" title="Home">

                                    <i class="fa-solid fa-house text-dark icon-sm"></i>

                                </a>

                            </li>


                            {{-- 新規作成 --}}
                            <li class="nav-item">

                                <a href="{{ route('post.create') }}" class="nav-link" title="Create Post">

                                    <i class="fa-solid fa-circle-plus text-dark icon-sm"></i>

                                </a>

                            </li>


                            {{-- ==================================================
                             アカウント
                        ================================================== --}}
                            <li class="nav-item dropdown">

                                <button id="account-dropdown" class="btn shadow-none nav-link" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">


                                    @if (Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                            alt="{{ Auth::user()->name }}" class="rounded-circle avatar-sm">
                                    @else
                                        <i class="fa-solid fa-circle-user text-dark icon-sm"></i>
                                    @endif

                                </button>


                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="account-dropdown">


                                    {{-- プロフィール --}}
                                    <a href="{{ route('profile.show', Auth::user()->id) }}" class="dropdown-item">

                                        <i class="fa-solid fa-circle-user"></i>

                                        プロフィール

                                    </a>


                                    {{-- ログアウト --}}
                                    <a href="{{ route('logout') }}" class="dropdown-item"
                                        onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">

                                        <i class="fa-solid fa-right-from-bracket"></i>

                                        ログアウト

                                    </a>


                                    {{-- ログアウト用フォーム --}}
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">

                                        @csrf

                                    </form>

                                </div>

                            </li>

                        </ul>


                        {{-- ==================================================
                     ログアウト中
                ================================================== --}}
                    @else
                        <ul class="navbar-nav ms-auto">


                            {{-- Login --}}
                            <li class="nav-item">

                                <a href="{{ route('login') }}" class="nav-link">
                                    Login
                                </a>

                            </li>


                            {{-- Register --}}
                            <li class="nav-item">

                                <a href="{{ route('register') }}" class="nav-link">
                                    Register
                                </a>
                            </li>
                        </ul>
                    @endauth
                </div>
            </div>
        </nav>


        {{-- ==================================================
         ページ本体
    ================================================== --}}
        <main class="py-5">

            <div class="container">

                <div class="row justify-content-center">

                    <div class="col-12 col-md-9">
                        @yield('content')
                    </div>

                </div>
            </div>
        </main>

    </div>

</body>

</html>
