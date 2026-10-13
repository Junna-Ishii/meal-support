<div class="modal fade" id="delete-post-{{ $post->id }}">

    <div class="modal-dialog">

        <div class="modal-content border-danger">

            <div class="modal-header border-danger">

                <h5 class="modal-title text-danger">

                    <i class="fa-solid fa-circle-exclamation"></i>
                    投稿を削除
                </h5>

            </div>


            <div class="modal-body">

                <p>
                    この投稿を削除してもよろしいですか？
                </p>

                <div class="mt-3">

                    {{-- ==========================================
                        投稿画像
                        storage/app/public/posts に保存しているため
                        storage/ を付けて表示する
                    ========================================== --}}
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="post id {{ $post->id }}"
                            class="image-lg">
                    @endif


                    <p class="mt-1 text-muted">
                        {{ $post->description }}
                    </p>

                </div>
            </div>


            <div class="modal-footer border-0">

                <form action="{{ route('post.destroy', $post->id) }}" method="post">

                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                        キャンセル
                    </button>


                    <button type="submit" class="btn btn-danger btn-sm">
                        削除
                    </button>

                </form>

            </div>
        </div>
    </div>
</div>
