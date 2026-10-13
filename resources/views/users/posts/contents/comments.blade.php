<div class="mt-3">

    {{-- コメントを表示 --}}
    @if ($post->comments->isNotEmpty())

        <hr>

        <ul class="list-group">

            @foreach ($post->comments->take(3) as $comment)
                <li class="list-group-item border-0 p-0 mb-2">

                    {{-- コメント投稿者のプロフィール --}}
                    <a href="{{ $comment->user->role_id == 1
                        ? route('nutritionist.profile.public', $comment->user->id)
                        : route('profile.show', $comment->user->id) }}"
                        class="text-decoration-none text-dark fw-bold">
                        {{ $comment->user->name }}
                    </a>

                    &nbsp;

                    <p class="d-inline fw-light">
                        {{ $comment->body }}
                    </p>


                    <form action="{{ route('comment.destroy', $comment->id) }}" method="post">

                        @csrf
                        @method('DELETE')

                        <span class="text-uppercase text-muted xsmall">
                            {{ date('Y年m月d日', strtotime($comment->created_at)) }}
                        </span>


                        {{-- 自分が投稿したコメントの場合、削除ボタンを表示 --}}
                        @if (Auth::user()->id === $comment->user->id)
                            &middot;

                            <button type="submit" class="border-0 bg-transparent text-danger p-0 xsmall">
                                削除
                            </button>
                        @endif

                    </form>

                </li>
            @endforeach


            @if ($post->comments->count() > 3)
                <li class="list-group-item border-0 px-0 pt-0">

                    <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none small">

                        コメントをすべて見る
                        （{{ $post->comments->count() }}件）

                    </a>

                </li>
            @endif

        </ul>

    @endif


    {{-- コメント入力欄 --}}
    <form action="{{ route('comment.store', $post->id) }}" method="post">

        @csrf

        <div class="input-group">

            <textarea name="comment_body{{ $post->id }}" id="" cols="30" rows="1"
                class="form-control form-control-sm" placeholder="コメントを入力してください">{{ old('comment_body' . $post->id) }}</textarea>


            <button type="submit" class="btn btn-outline-secondary btn-sm" title="コメントを投稿">

                <i class="fa-regular fa-paper-plane"></i>

            </button>

        </div>


        {{-- エラーメッセージ --}}
        @error('comment_body' . $post->id)
            <div class="text-danger small">
                {{ $message }}
            </div>
        @enderror

    </form>

</div>
