@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        @if(isset($page) && $page === 'mylist')
        マイリスト
        @else
        商品一覧
        @endif
    </h1>

    @auth
    <div class="btn-group" role="group">
        <a href="{{ route('items.index', ['page' => 'all', 'keyword' => $keyword ?? '']) }}"
            class="btn btn-outline-primary {{ (!isset($page) || $page === 'all') ? 'active' : '' }}">
            全商品
        </a>
        <a href="{{ route('items.index', ['page' => 'mylist', 'keyword' => $keyword ?? '']) }}"
            class="btn btn-outline-primary {{ (isset($page) && $page === 'mylist') ? 'active' : '' }}">
            マイリスト
        </a>
    </div>
    @endauth
</div>

@if(isset($page) && $page === 'mylist' && !auth()->check())
<div class="alert alert-info">
    マイリストを表示するにはログインしてください。
</div>
@elseif(isset($page) && $page === 'mylist' && $items->isEmpty())
<div class="alert alert-info">
    マイリストに商品がありません。商品にいいねをしてマイリストに追加してください。
</div>
@elseif($items->isEmpty())
<div class="alert alert-info">
    商品が見つかりませんでした。
</div>
@else
<div class="row">
    @foreach($items as $item)
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            @if($item->image_path)
            <img src="{{ asset('storage/' . $item->image_path) }}"
                class="card-img-top" alt="商品画像"
                style="height: 200px; object-fit: cover;">
            @endif
            <div class="card-body">
                <h5 class="card-title">
                    <a href="{{ route('items.show', $item->id) }}" class="text-decoration-none">
                        {{ $item->name }}
                    </a>
                </h5>
                <p class="card-text text-primary fw-bold">{{ number_format($item->price) }}円</p>
                @if($item->sold_at)
                <span class="badge bg-danger">Sold</span>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection