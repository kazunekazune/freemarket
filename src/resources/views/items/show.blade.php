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

    <div class="item-detail">
        <!-- 商品画像 -->
        @if($item->image_path)
        <img src="{{ asset('storage/' . $item->image_path) }}" alt="商品画像" style="width:300px;">
        @endif

        <!-- 商品基本情報 -->
        <h1>{{ $item->name }}</h1>
        <p>ブランド名: {{ $item->brand_name ?? '未設定' }}</p>
        <p>価格: {{ number_format($item->price) }}円</p>

        <!-- いいね数 -->
        @php
        $liked = false;
        if (auth()->check()) {
        $liked = \App\Models\Like::where('user_id', auth()->id())->where('item_id', $item->id)->exists();
        }
        $likeCount = \App\Models\Like::where('item_id', $item->id)->count();
        @endphp

        <!-- いいねボタン -->
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

        <!-- 商品情報 -->
        <div class="item-info">
            <h2>商品情報</h2>
            <p>商品の説明: {{ $item->description }}</p>
            <p>カテゴリー:
                @if($item->categories->isNotEmpty())
                @foreach($item->categories as $category)
                {{ $category->name }}{{ !$loop->last ? ', ' : '' }}
                @endforeach
                @else
                未設定
                @endif
            </p>
            <p>商品の状態: {{ $item->condition }}</p>
        </div>

        <!-- コメント -->
        <div class="comments">
            <h2>コメント（{{ $comments->count() }}）</h2>

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
        </div>

        <!-- 購入ボタン -->
        @if(auth()->check())
        @if($item->sold_at)
        <p style="color:red;">Sold</p>
        @elseif($item->user_id === auth()->id())
        <p>※自分の商品は購入できません</p>
        @else
        <form method="GET" action="{{ route('purchase.show', $item->id) }}">
            @csrf
            <button type="submit">購入する</button>
        </form>
        @endif
        @else
        <p>購入するにはログインしてください。</p>
        @endif

        <!-- 編集・削除ボタン -->
        @if(auth()->check() && auth()->id() === $item->user_id)
        <div class="item-actions">
            <a href="{{ route('items.edit', $item) }}">編集する</a>
            <form action="{{ route('items.destroy', $item) }}" method="POST" style="display:inline;" onsubmit="return confirm('本当に削除しますか？');">
                @csrf
                @method('DELETE')
                <button type="submit">削除する</button>
            </form>
        </div>
        @endif

        <a href="{{ route('items.index') }}">一覧に戻る</a>
    </div>
</body>

</html>