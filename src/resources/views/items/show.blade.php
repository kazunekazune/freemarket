@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
    .item-detail-container {
        background-color: #fff;
        padding: 2rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .item-image {
        width: 100%;
        max-width: 400px;
        height: auto;
        object-fit: cover;
        background-color: #f8f9fa;
    }

    .brand-name {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .item-name {
        font-size: 1.75rem;
        font-weight: bold;
    }

    .item-price {
        font-size: 1.5rem;
        margin-top: 0.5rem;
        margin-bottom: 1rem;
    }

    .actions-row {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 1rem;
        color: #6c757d;
    }

    .actions-row .action-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        color: inherit;
    }

    .btn-purchase {
        background-color: #dc3545;
        color: white;
        font-weight: bold;
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: bold;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .info-table .row {
        padding: 0.75rem 0;
    }

    .info-table .row .label {
        color: #6c757d;
    }

    .category-tag {
        display: inline-block;
        background-color: #e9ecef;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.9rem;
        margin-right: 0.5rem;
    }

    .comment-item {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .comment-item .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>
@endpush

@section('content')
<div class="container item-detail-container">
    <div class="row">
        <!-- Left: Image -->
        <div class="col-md-5">
            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="item-image">
        </div>

        <!-- Right: Details -->
        <div class="col-md-7">
            <p class="brand-name">{{ $item->brand->name ?? 'ノーブランド' }}</p>
            <h1 class="item-name">{{ $item->name }}</h1>
            <p class="item-price">¥{{ number_format($item->price) }} <small>(税込)</small></p>

            <div class="actions-row">
                <!-- Like Button -->
                <form action="{{ $item->isLikedBy(Auth::user()) ? route('items.unlike', $item->id) : route('items.like', $item->id) }}" method="POST" class="d-inline">
                    @csrf
                    @if($item->isLikedBy(Auth::user()))
                    @method('DELETE')
                    @endif
                    <button type="submit" class="btn btn-link p-0 action-item">
                        <i class="bi {{ $item->isLikedBy(Auth::user()) ? 'bi-star-fill text-warning' : 'bi-star' }}"></i>
                        <span>{{ $item->likes->count() }}</span>
                    </button>
                </form>
                <!-- Comment Icon -->
                <div class="action-item">
                    <i class="bi bi-chat-dots"></i>
                    <span>{{ $item->comments->count() }}</span>
                </div>
            </div>

            <a href="{{ route('purchase.show', $item->id) }}" class="btn btn-purchase w-100">購入手続きへ</a>

            <h2 class="section-title">商品説明</h2>
            <p>{{ $item->description }}</p>

            <h2 class="section-title">商品の情報</h2>
            <div class="info-table">
                <div class="row">
                    <div class="col-4 label">カテゴリー</div>
                    <div class="col-8">
                        @foreach($item->categories as $category)
                        <span class="category-tag">{{ $category->name }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 label">商品の状態</div>
                    <div class="col-8">{{ $item->condition }}</div>
                </div>
            </div>

        </div>
    </div>
    <hr class="my-4">
    <!-- Comment Section -->
    <div>
        <h2 class="section-title">コメント</h2>
        @foreach($item->comments as $comment)
        <div class="comment-item">
            <img src="{{ asset('storage/' . ($comment->user->profile_image ?? 'images/default_avatar.png')) }}" alt="{{ $comment->user->name }}" class="avatar">
            <div>
                <strong>{{ $comment->user->name }}</strong>
                <p>{{ $comment->comment }}</p>
            </div>
        </div>
        @endforeach

        @auth
        <form action="{{ route('items.comment', $item->id) }}" method="POST" class="mt-4">
            @csrf
            <div class="form-group">
                <label for="comment" class="form-label">商品へのコメント</label>
                <textarea name="comment" id="comment" rows="4" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-purchase w-100 mt-3">コメントを送信する</button>
        </form>
        @endauth
        @guest
        <p class="text-center mt-4">コメントを投稿するには<a href="{{ route('login') }}">ログイン</a>が必要です。</p>
        @endguest
    </div>
</div>
@endsection