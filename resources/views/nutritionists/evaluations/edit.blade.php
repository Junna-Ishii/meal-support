@extends('layouts.nutritionist')

@section('title', '評価を編集')

@section('content')

    <div class="container">

        <h1 class="mb-4">栄養士評価を編集</h1>

        {{-- 評価対象の食事写真 --}}
        @if ($evaluation->post && $evaluation->post->image)
            <div class="evaluation-image-area mb-4">
                <img src="{{ asset('storage/' . $evaluation->post->image) }}" alt="食事写真">
            </div>
        @endif

        <form action="{{ route('nutritionist.evaluation.update', $evaluation->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- 評価 --}}
            <div class="mb-3">
                <label class="form-label">評価</label>

                <select name="rating" class="form-select">
                    <option value="1" {{ $evaluation->rating == 1 ? 'selected' : '' }}>⭐</option>
                    <option value="2" {{ $evaluation->rating == 2 ? 'selected' : '' }}>⭐⭐</option>
                    <option value="3" {{ $evaluation->rating == 3 ? 'selected' : '' }}>⭐⭐⭐</option>
                    <option value="4" {{ $evaluation->rating == 4 ? 'selected' : '' }}>⭐⭐⭐⭐</option>
                    <option value="5" {{ $evaluation->rating == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐</option>
                </select>
            </div>

            {{-- コメント --}}
            <div class="mb-3">
                <label class="form-label">コメント</label>

                <textarea name="comment" class="form-control" rows="5">{{ $evaluation->comment }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                更新する
            </button>

        </form>

    </div>

@endsection
