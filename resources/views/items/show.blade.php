<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>{{ $item->name }} | 商品詳細</title>
</head>

<body>
    <a href="{{ url('/') }}">
        <img src="{{ asset('images/logo.svg') }}" alt="ロゴ" style="height: 40px;">
    </a>

    <h1>{{ $item->name }}</h1>
    <p>価格: {{ number_format($item->price) }}円</p>
    <p>コンディション: {{ $item->condition }}</p>
    <p>説明: {{ $item->description }}</p>
    @if($item->image_path)
    <img src="{{ $item->image_path }}" alt="商品画像" style="width:200px;">
    @endif
    <br>
    <a href="{{ route('items.index') }}">一覧に戻る</a>

    @php
    $liked = false;
    if (auth()->check()) {
    $liked = \App\Models\Like::where('user_id', auth()->id())->where('item_id', $item->id)->exists();
    }
    $likeCount = \App\Models\Like::where('item_id', $item->id)->count();
    @endphp

    <!-- いいねボタン表示 -->
    @if(auth()->check())
    @if($liked)
    <form method="POST" action="{{ route('items.unlike', $item->id) }}">
        @csrf
        @method('DELETE')
        <button type="submit">♥ いいね解除（{{ $likeCount }}）</button>
    </form>
    @else
    <form method="POST" action="{{ route('items.like', $item->id) }}">
        @csrf
        <button type="submit">♡ いいね（{{ $likeCount }}）</button>
    </form>
    @endif
    @else
    <span>♥（{{ $likeCount }}）</span>
    <span>※ログインでいいねできます</span>
    @endif
</body>

</html>