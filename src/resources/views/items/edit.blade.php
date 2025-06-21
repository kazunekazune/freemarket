@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">商品編集</h1>

                <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">商品名</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $item->name) }}" required class="form-control">
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">商品の説明</label>
                        <textarea name="description" id="description" rows="4" required class="form-control">{{ old('description', $item->description) }}</textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">価格</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $item->price) }}" required min="300" max="9999999" class="form-control">
                        @error('price')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">カテゴリー</label>
                        <select name="category_id" id="category_id" required class="form-control">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">商品画像</label>
                        <input type="file" name="image" id="image" accept="image/*" class="form-control">
                        @error('image')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('items.show', $item) }}" class="btn btn-secondary">キャンセル</a>
                        <button type="submit" class="btn btn-primary">更新する</button>
                    </div>
                </form>

                <div class="mt-4 pt-3 border-top">
                    <form action="{{ route('items.destroy', $item) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">商品を削除する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection