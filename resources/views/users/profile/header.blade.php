<div class="row align-items-center profile-header">

    {{-- ==========================================
        プロフィール画像
    ========================================== --}}
    <div class="col-4 profile-avatar">

        @if ($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                class="thumbnail rounded-circle d-block mx-auto avatar-lg">
        @else
            <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-lg"></i>
        @endif

    </div>


    {{-- ==========================================
        プロフィール情報
    ========================================== --}}
    <div class="col-8 profile-info">

        {{-- 名前 --}}
        <h2 class="profile-user-name">
            {{ $user->name }}
        </h2>


        {{-- ユーザー --}}
        <p class="profile-user-type">
            ユーザー
        </p>


        {{-- ==========================================
            食事記録の件数
        ========================================== --}}
        <p class="profile-post-count">
            <strong>
                {{ $user->posts->count() }}
            </strong>
            件の食事記録
        </p>


        {{-- ==========================================
            自己紹介
        ========================================== --}}
        <p class="profile-introduction">
            {{ $user->introduction }}
        </p>


        {{-- ==========================================
            自分のプロフィールの場合だけ編集ボタン
        ========================================== --}}
        @if (Auth::user()->id === $user->id)
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-sm fw-bold">

                プロフィールの編集

            </a>
        @endif

    </div>

</div>
