@extends('layouts.app')

@push('styles')
<style>
    .profile-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 1.5rem;
        padding-bottom: 1rem;
    }

    .profile-info {
        display: flex;
        align-items: center;
    }

    .profile-info .avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 1rem;
    }

    .profile-info .username {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .profile-edit-btn {
        flex-shrink: 0;
        /* ボタンが縮まないようにする */
    }

    .mypage-tabs {
        border-bottom: 1px solid #e0e0e0;
        margin-top: 1rem;
    }

    .mypage-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        color: #6c757d;
        font-weight: bold;
        padding: 0.75rem 0;
        margin-right: 2rem;
    }

    .mypage-tabs .nav-link.active {
        border-bottom-color: #dc3545;
        color: #dc3545;
    }

    .item-grid-container {
        padding-top: 1.5rem;
    }

    .item-grid-container a {
        display: block;
        text-decoration: none;
    }

    .item-grid-container .img-wrap {
        position: relative;
        width: 100%;
        padding-top: 100%;
        background-color: #f5f5f5;
        overflow: hidden;
    }

    .item-grid-container .img-wrap img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="profile-section">
        <div class="profile-info">
            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="User Avatar" class="avatar" onerror="this.onerror=null;this.src='{{ asset('images/default_avatar.png') }}';">
            <span class="username">{{ $user->name }}</span>
        </div>
        <a href="{{ route('profile.edit') }}" class="btn btn-outline-danger profile-edit-btn">プロフィールを編集</a>
    </div>

    <ul class="nav mypage-tabs">
        <li class="nav-item">
            <a class="nav-link {{ $page === 'sell' ? 'active' : '' }}" href="{{ route('mypage', ['page' => 'sell']) }}">出品した商品</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $page !== 'sell' ? 'active' : '' }}" href="{{ route('mypage', ['page' => 'buy']) }}">購入した商品</a>
        </li>
    </ul>

    <div class="item-grid-container">
        @php
        $items = ($page === 'sell') ? $exhibitedItems : $purchasedItems;
        $empty_message = ($page === 'sell') ? '出品した商品はありません。' : '購入した商品はありません。';
        @endphp
        <div class="row">
            @forelse($items as $item)
            <div class="col-4 col-md-3 col-lg-2 mb-4">
                <a href="{{ route('items.show', $item->id) }}">
                    <div class="img-wrap">
                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" onerror="this.style.display='none'">
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12">
                <p class="text-center text-muted mt-5">{{ $empty_message }}</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection