@extends('layouts.app')

@push('styles')
<style>
    .sell-container {
        max-width: 700px;
        margin: 2rem auto;
        background-color: #fff;
        padding: 2.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .page-title {
        text-align: center;
        margin-bottom: 2rem;
        font-weight: bold;
    }

    .section {
        margin-bottom: 2rem;
    }

    .section-title {
        font-weight: bold;
        font-size: 1.1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #eee;
        margin-bottom: 1rem;
    }

    .image-drop-zone {
        border: 2px dashed #ddd;
        border-radius: 4px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        background-color: #f8f9fa;
        min-height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-drop-zone .btn-select-image {
        border: 1px solid #dc3545;
        color: #dc3545;
        background-color: #fff;
    }

    .image-preview {
        max-width: 100%;
        max-height: 200px;
        margin-top: 1rem;
    }

    .category-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        /* ボタン同士の間隔を調整 */
    }

    .category-tags input[type="checkbox"] {
        display: none;
    }

    .category-tags .btn {
        border-radius: 999px;
        /* 角を完全に丸くする */
        border: 1px solid #ddd;
        background-color: #f8f9fa;
        color: #333;
        padding: .375rem 1rem;
        /* ボタンのパディングを調整 */
    }

    .category-tags input[type="checkbox"]:checked+.btn {
        background-color: #dc3545;
        color: white;
        border-color: #dc3545;
    }

    .price-input {
        display: flex;
        align-items: center;
    }

    .price-input span {
        font-size: 1.2rem;
        margin-right: 0.5rem;
    }

    .btn-submit {
        background-color: #dc3545;
        color: white;
        font-weight: bold;
        padding: 0.75rem;
    }
</style>
@endpush

@section('content')
<div class="sell-container">
    <h1 class="page-title">商品の出品</h1>
    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 商品画像 -->
        <div class="section">
            <h2 class="section-title">商品画像</h2>
            <div id="image-drop-zone" class="image-drop-zone">
                <input type="file" name="image" id="image" class="d-none" accept="image/*">
                <div id="image-placeholder">
                    <button type="button" class="btn btn-select-image" onclick="document.getElementById('image').click();">画像を選択する</button>
                </div>
                <img id="image-preview" class="image-preview d-none" src="" alt="Image preview">
            </div>
        </div>

        <!-- 商品の詳細 -->
        <div class="section">
            <h2 class="section-title">商品の詳細</h2>
            <!-- カテゴリー -->
            <div class="mb-3">
                <label class="form-label fw-bold">カテゴリー</label>
                <div class="category-tags">
                    @foreach ($categories as $category)
                    <input type="checkbox" class="btn-check" id="category-{{ $category->id }}" name="categories[]" value="{{ $category->id }}" autocomplete="off">
                    <label class="btn" for="category-{{ $category->id }}">{{ $category->name }}</label>
                    @endforeach
                </div>
            </div>
            <!-- 商品の状態 -->
            <div class="mb-3">
                <label for="condition" class="form-label fw-bold">商品の状態</label>
                <select name="condition" id="condition" class="form-select" required>
                    <option value="" disabled selected>選択してください</option>
                    <option value="新品、未使用">新品、未使用</option>
                    <option value="未使用に近い">未使用に近い</option>
                    <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                    <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                    <option value="傷や汚れあり">傷や汚れあり</option>
                    <option value="全体的に状態が悪い">全体的に状態が悪い</option>
                </select>
            </div>
        </div>

        <!-- 商品名と説明 -->
        <div class="section">
            <h2 class="section-title">商品名と説明</h2>
            <div class="mb-3">
                <label for="name" class="form-label fw-bold">商品名</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label for="brand" class="form-label fw-bold">ブランド名</label>
                <input type="text" name="brand" id="brand" class="form-control" value="{{ old('brand') }}">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label fw-bold">商品の説明</label>
                <textarea name="description" id="description" rows="5" class="form-control" required>{{ old('description') }}</textarea>
            </div>
        </div>

        <!-- 販売価格 -->
        <div class="section">
            <h2 class="section-title">販売価格</h2>
            <div class="price-input">
                <span>¥</span>
                <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" required placeholder="例）300">
            </div>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-submit">出品する</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('image');
        const dropZone = document.getElementById('image-drop-zone');
        const placeholder = document.getElementById('image-placeholder');
        const preview = document.getElementById('image-preview');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    placeholder.classList.add('d-none');
                }
                reader.readAsDataURL(file);
            }
        });

        dropZone.addEventListener('click', () => imageInput.click());

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = '#dc3545';
        });

        dropZone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = '#ddd';
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = '#ddd';
            if (e.dataTransfer.files.length > 0) {
                imageInput.files = e.dataTransfer.files;
                imageInput.dispatchEvent(new Event('change'));
            }
        });
    });
</script>
@endsection