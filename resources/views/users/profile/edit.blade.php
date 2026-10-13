@extends('layouts.app')

@section('title', 'プロフィール編集')

@section('content')

    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <form action="{{ route('profile.update') }}" method="post" class="bg-white shadow rounded-3 p-3 p-md-5"
                enctype="multipart/form-data">

                @csrf
                @method('PATCH')

                <h2 class="hr mb-3 fw-light text-muted">
                    プロフィール編集
                </h2>

                {{-- プロフィール画像 --}}
                <div class="row mb-3">
                    <div class="col-4">
                        @if ($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                                class="img-thumbnail rounded-circle d-block mx-auto avatar-lg">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-lg"></i>
                        @endif
                    </div>

                    <div class="col-auto align-self-end">
                        <input type="file" name="avatar" id="avatar" class="form-control form-control-sm mt-1"
                            accept="image/jpeg,image/png,image/gif,image/heic,image/heif,.heic,.heif"
                            aria-describedby="avatar-info">

                        <div id="avatar-info" class="form-text">
                            JPEG、JPG、PNG、GIF、HEIC、HEIF形式に対応しています。
                            <br>
                            ファイルサイズ：最大5MB

                        </div>

                        @error('avatar')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- 名前 --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">
                        名前
                    </label>

                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ old('name', $user->name) }}" autofocus>

                    @error('name')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- メールアドレス --}}
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">
                        メールアドレス
                    </label>

                    <input type="email" name="email" id="email" class="form-control"
                        value="{{ old('email', $user->email) }}">

                    @error('email')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- 自己紹介 --}}
                <div class="mb-3">
                    <label for="introduction" class="form-label fw-bold">
                        自己紹介
                    </label>

                    <textarea name="introduction" id="introduction" rows="5" class="form-control" placeholder="自己紹介を入力してください">{{ old('introduction', $user->introduction) }}</textarea>

                    @error('introduction')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- 保存 --}}
                <button type="submit" class="btn btn-warning px-5">
                    保存
                </button>
            </form>
        </div>
    </div>

@endsection
