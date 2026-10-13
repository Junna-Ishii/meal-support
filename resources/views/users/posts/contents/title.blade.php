<div class="card-header bg-white py-3">
    <div class="row align-items-center">

        <div class="col-auto">

            <a href="{{ route('profile.show', $post->user->id) }}">

                @if ($post->user->avatar)
                    <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="{{ $post->user->name }}"
                        class="rounded-circle avatar-sm">
                @else
                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                @endif

            </a>

        </div>

        <div class="col ps-0">

            <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark">

                {{ $post->user->name }}
            </a>

        </div>

        <div class="col-auto">

            {{-- 自分の投稿の場合、編集・削除を表示 --}}
            @if (Auth::user()->id == $post->user->id)
                <div class="dropdown">

                    <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-ellipsis"></i>
                    </button>


                    <div class="dropdown-menu">

                        <a href="{{ route('post.edit', $post->id) }}" class="dropdown-item">

                            <i class="fa-regular fa-pen-to-square"></i>
                            編集
                        </a>


                        <button class="dropdown-item text-danger" data-bs-toggle="modal"
                            data-bs-target="#delete-post-{{ $post->id }}">

                            <i class="fa-solid fa-trash-can"></i>
                            削除
                        </button>

                    </div>


                    {{-- 削除確認モーダル --}}
                    @include('users.posts.contents.modals.delete')

                </div>
            @endif

        </div>

    </div>
</div>
