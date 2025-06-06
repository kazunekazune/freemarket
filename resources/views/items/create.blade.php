<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>商品出品</title>
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

    <h1>商品の出品</h1>
    <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label>商品画像</label>
            <input type="file" name="image">
            @error('image')<div style="color:red;">{{ $message }}</div>@enderror
        </div>
        <h2>商品の詳細</h2>
        <div>
            <label>カテゴリー</label>
            <select name="category" required>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
        </div>
        <div>
            <label>商品の状態</label>
            <input type="text" name="condition" value="{{ old('condition') }}" required>
            @error('condition')<div style="color:red;">{{ $message }}</div>@enderror
        </div>
        <h2>商品名と説明</h2>
        <div>
            <label>商品名</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
            @error('name')<div style="color:red;">{{ $message }}</div>@enderror
        </div>
        <div>
            <label>ブランド名</label>
            <textarea name="description">{{ old('description') }}</textarea>
            @error('description')<div style="color:red;">{{ $message }}</div>@enderror
        </div>
        <div>
            <label>商品の説明</label>
            <textarea name="description">{{ old('description') }}</textarea>
            @error('description')<div style="color:red;">{{ $message }}</div>@enderror
        </div>
        <div>
            <label>販売価格</label>
            <input type="number" name="price" value="{{ old('price') }}" required>
            @error('price')<div style="color:red;">{{ $message }}</div>@enderror
        </div>


        <button type="submit">出品する</button>
    </form>
</body>

</html>