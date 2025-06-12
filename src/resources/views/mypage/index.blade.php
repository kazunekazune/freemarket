<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>マイページ</title>
</head>

<body>
    <h1>{{ $user->name }}さんのマイページ</h1>

    <h2>購入した商品一覧</h2>
    <ul>
        @forelse($purchasedItems as $item)
        <li>
            <a href="{{ route('items.show', $item->id) }}">
                {{ $item->name }}
            </a>
            - {{ number_format($item->price) }}円
            @if($item->image_path)
            <img src="{{ $item->image_path }}" alt="商品画像" style="width:80px;">
            @endif
        </li>
        @empty
        <li>購入履歴はありません。</li>
        @endforelse
    </ul>

    <h2>出品した商品一覧</h2>
    <ul>
        @forelse($exhibitedItems as $item)
        <li>
            <a href="{{ route('items.show', $item->id) }}">
                {{ $item->name }}
            </a>
            - {{ number_format($item->price) }}円
            @if($item->image_path)
            <img src="{{ $item->image_path }}" alt="商品画像" style="width:80px;">
            @endif
        </li>
        @empty
        <li>出品履歴はありません。</li>
        @endforelse
    </ul>
</body>

</html>