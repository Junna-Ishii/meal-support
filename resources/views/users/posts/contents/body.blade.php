{{-- ==========================================
    投稿画像
========================================== --}}
<div class="container p-0">

    <a href="{{ route('post.show', $post->id) }}">

        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->id }}" class="grid-img">

    </a>

</div>


<div class="card-body">

    {{-- ==========================================
        カテゴリー
    ========================================== --}}
    <div class="text-end mb-2">

        @foreach ($post->categoryPost as $category_post)
            @if ($category_post->category->name === '朝食')
                <div class="badge bg-warning text-dark category-badge">
                    {{ $category_post->category->name }}
                </div>
            @elseif ($category_post->category->name === '昼食')
                <div class="badge bg-info text-dark category-badge">
                    {{ $category_post->category->name }}
                </div>
            @elseif ($category_post->category->name === '夕食')
                <div class="badge bg-primary category-badge">
                    {{ $category_post->category->name }}
                </div>
            @elseif ($category_post->category->name === '間食')
                <div class="badge bg-success text-dark category-badge">
                    {{ $category_post->category->name }}
                </div>
            @endif
        @endforeach

    </div>


    {{-- ==========================================
        食事内容
    ========================================== --}}
    @if ($post->meal_content)
        <div class="mt-2">

            <div class="fw-bold">
                食事内容
            </div>

            <div>
                {{ $post->meal_content }}
            </div>

        </div>
    @endif


    {{-- ==========================================
        コメント
    ========================================== --}}
    @if ($post->comment)
        <div class="mt-2">

            <div class="fw-bold">
                コメント
            </div>

            <div>
                {{ $post->comment }}
            </div>

        </div>
    @endif


    {{-- ==========================================
        栄養士からの評価
    ========================================== --}}
    @if ($post->evaluation)
        <div class="mt-2">

            <div class="fw-bold">
                栄養士からの評価
            </div>

            <div>
                ⭐ {{ $post->evaluation->rating }}
            </div>

        </div>
    @endif


    {{-- ==========================================
        投稿日
    ========================================== --}}
    <p class="text-muted xsmall mt-2">

        {{ $post->created_at->setTimezone('Asia/Tokyo')->format('Y年n月j日 H:i') }}

    </p>


    {{-- ==========================================
        コメント一覧
    ========================================== --}}
    @include('users.posts.contents.comments')

</div>
