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

    @if(auth()->check())
    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit">ログアウト</button>
    </form>
    @endif

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

    <h2>コメント</h2>

    <!-- コメント投稿フォーム -->
    @if(auth()->check())
    <form method="POST" action="{{ route('items.comment', $item->id) }}">
        @csrf
        <textarea name="content" rows="3" cols="40" required>{{ old('content') }}</textarea>
        @error('content')<div style="color:red;">{{ $message }}</div>@enderror
        <br>
        <button type="submit">コメントする</button>
    </form>
    @else
    <p>コメントするにはログインしてください。</p>
    @endif

    <!-- コメント一覧 -->
    <ul>
        @forelse($comments as $comment)
        <li>
            <strong>{{ $comment->user->name ?? '退会ユーザー' }}</strong>：
            {{ $comment->content }}
            <br>
            <small>{{ $comment->created_at->format('Y-m-d H:i') }}</small>
        </li>
        @empty
        <li>コメントはまだありません。</li>
        @endforelse
    </ul>

    @if(auth()->check())
    @if($item->sold_at)
    <p style="color:red;">Sold</p>
    @elseif($item->user_id === auth()->id())
    <p>※自分の商品は購入できません</p>
    @else
    <form method="POST" action="{{ route('purchase.store', $item->id) }}">
        @csrf
        <button type="submit">購入する</button>
    </form>
    @endif
    @else
    <p>購入するにはログインしてください。</p>
    @endif
</body>

</html>