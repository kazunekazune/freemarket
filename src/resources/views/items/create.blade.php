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

    @if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label>商品画像</label>
            <input type="file" name="image">
            @error('image')<div style="color:red;">{{ $message }}</div>@enderror
        </div>
        <h2>商品の詳細</h2>
        <div>
            <label for="categories">カテゴリ（複数選択可）</label><br>
            <select name="categories[]" id="categories" multiple style="width: 300px;">
                @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ (collect(old('categories'))->contains($category->id)) ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
            @if ($errors->has('categories'))
            <div style="color:red;">{{ $errors->first('categories') }}</div>
            @endif
            <br>
        </div>
        <div>
            <label for="condition">商品の状態</label>
            <select name="condition" id="condition">
                <option value="良好" {{ old('condition') == '良好' ? 'selected' : '' }}>良好</option>
                <option value="目立った傷や汚れなし" {{ old('condition') == '目立った傷や汚れなし' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり" {{ old('condition') == 'やや傷や汚れあり' ? 'selected' : '' }}>やや傷や汚れあり</option>
                <option value="状態が悪い" {{ old('condition') == '状態が悪い' ? 'selected' : '' }}>状態が悪い</option>
            </select>
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
            <textarea name="brand_name">{{ old('brand_name') }}</textarea>
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