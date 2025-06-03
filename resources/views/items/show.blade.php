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
</body>

</html>