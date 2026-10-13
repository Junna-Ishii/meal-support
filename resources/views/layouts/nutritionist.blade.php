<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ブラウザのタブに表示するアイコン --}}
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    {{-- Custom css --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Fonts --}}
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css"
        integrity="sha512-ApSLB1Pd3/bZN8fWB/RG9YhN/7bd9Hkf3AGaE2mPfebjrxagjuBtx2GcgdqIlJkUzwylBo61r9Xa9NmgBI0swA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Scripts --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>

    <div id="app">

        {{-- ==============================
             栄養士専用ナビバー
        =============================== --}}
        <nav class="navbar navbar-expand-md navbar-light meal-support-navbar shadow-sm py-0">

            <div class="container-fluid">

                {{-- Meal Support ロゴ --}}
                <a class="navbar-brand" href="{{ route('nutritionist.home') }}">
                    <img src="{{ asset('images/meal-support-logo.png') }}" alt="Meal Support" class="navbar-logo">
                </a>


                <div class="navbar-collapse">

                    {{-- 右側 --}}
                    <ul class="navbar-nav ms-auto">

                        {{-- Home --}}
                        <li class="nav-item" title="Home">

                            <a href="{{ route('nutritionist.home') }}" class="nav-link">

                                <i class="fa-solid fa-house text-dark icon-sm"></i>

                            </a>

                        </li>


                        {{-- Account --}}
                        <li class="nav-item dropdown">

                            <button id="account-dropdown" class="btn shadow-none nav-link" data-bs-toggle="dropdown">

                                @if (Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                        alt="{{ Auth::user()->name }}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-dark icon-sm"></i>
                                @endif

                            </button>


                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="account-dropdown">

                                {{-- Profile --}}
                                <a href="{{ route('nutritionist.profile.show', Auth::user()->id) }}"
                                    class="dropdown-item">

                                    <i class="fa-solid fa-circle-user"></i>

                                    Profile

                                </a>


                                {{-- Logout --}}
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">

                                    <i class="fa-solid fa-right-from-bracket"></i>

                                    {{ __('Logout') }}

                                </a>


                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">

                                    @csrf

                                </form>

                            </div>

                        </li>

                    </ul>

                </div>

            </div>

        </nav>


        {{-- ==============================
             ページ本体
        =============================== --}}
        <main class="py-5">

            <div class="container-fluid">

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
