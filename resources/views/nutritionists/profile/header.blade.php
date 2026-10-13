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


        {{-- 栄養士 --}}
        <p class="profile-user-type">
            栄養士
        </p>


        {{-- 評価した食事の件数 --}}
        <p class="profile-post-count">
            評価した食事
            <strong>
                {{ $user->evaluations->count() }}
            </strong>
            件
        </p>


        {{-- 自己紹介 --}}
        @if ($user->introduction)
            <p class="profile-introduction">
                {{ $user->introduction }}
            </p>
        @endif

        {{-- プロフィール編集ボタン --}}
        @if (Auth::user()->id === $user->id)
            <a href="{{ route('nutritionist.profile.edit') }}" class="btn btn-outline-secondary btn-sm fw-bold mt-2">

                プロフィールを編集

            </a>
        @endif

    </div>

</div>
