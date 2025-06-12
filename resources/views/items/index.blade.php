<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>商品一覧</title>
</head>

<body>
    <a href="{{ url('/') }}">
        <img src="{{ asset('images/logo.svg') }}" alt="ロゴ" style="height: 40px;">
    </a>

    @if(auth()->check())
    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit">ログアウト</button>
    </form>
    @endif

    <h1>商品一覧</h1>
    <ul>
        @foreach($items as $item)
        <li>
            <a href="{{ route('items.show', $item->id) }}">
                <strong>{{ $item->name }}</strong>
            </a><br>
            {{ number_format($item->price) }}円<br>
            @if($item->image_path)
            <img src="{{ $item->image_path }}" alt="商品画像" style="width:100px;">
            @endif
            @if($item->sold_at)
            <span style="color:red; font-weight:bold;">Sold</span>
            @endif
            @endforeach

    </ul>
</body>

</html>