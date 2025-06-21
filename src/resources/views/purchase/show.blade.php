@extends('layouts.app')

@push('styles')
<style>
    /* 2カラムレイアウトのための基本スタイル */
    .purchase-container .left-column {
        padding-right: 2rem;
    }

    /* 左カラムの各セクション */
    .item-info-block {
        display: flex;
        align-items: center;
        padding-bottom: 1.5rem;
    }

    .item-info-block img {
        width: 90px;
        height: 90px;
        object-fit: cover;
        margin-right: 1.5rem;
        background-color: #f8f9fa;
    }

    .item-info-block .details .name {
        font-size: 1.1rem;
        font-weight: bold;
    }

    .item-info-block .details .price {
        font-size: 1.1rem;
    }

    .section-block {
        padding: 1.5rem 0;
    }

    .section-title {
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .address-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .address-header .section-title {
        margin-bottom: 0;
    }

    .address-body {
        margin-top: 1rem;
    }

    /* 右カラムのサマリーカード */
    .summary-card {
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        background-color: #fff;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 1rem;
        align-items: center;
    }

    .summary-row:first-child {
        border-bottom: 1px solid #dee2e6;
    }

    .summary-row .label {
        color: #333;
    }

    .summary-row .value {
        font-weight: bold;
    }

    .btn-purchase {
        background-color: #dc3545;
        color: white;
        font-weight: bold;
        padding: 0.75rem;
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
    <form action="{{ route('purchase.store', $item->id) }}" method="POST">
        @csrf
        <div class="row purchase-container">

            <!-- === 左カラム === -->
            <div class="col-md-7 left-column">
                <!-- 商品情報 -->
                <div class="item-info-block">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" onerror="this.style.display='none'">
                    <div class="details">
                        <p class="name mb-1">{{ $item->name }}</p>
                        <p class="price mb-0">¥{{ number_format($item->price) }}</p>
                    </div>
                </div>
                <hr>
                <!-- 支払い方法 -->
                <div class="section-block">
                    <h5 class="section-title">支払い方法</h5>
                    <div class="form-group">
                        <select name="payment_method" class="form-control" style="max-width: 300px;">
                            <option value="">選択してください</option>
                            <option value="credit_card">クレジットカード</option>
                            <option value="convenience_store">コンビニ払い</option>
                        </select>
                    </div>
                </div>
                <hr>
                <!-- 配送先 -->
                <div class="section-block">
                    <div class="address-header">
                        <h5 class="section-title">配送先</h5>
                        <a href="{{ route('purchase.address.edit', $item->id) }}">変更する</a>
                    </div>
                    <div class="address-body">
                        @if($user->postal_code && $user->address)
                        <p class="mb-0">〒{{ $user->postal_code }}</p>
                        <p class="mb-0">{{ $user->address }} {{ $user->building }}</p>
                        @else
                        <p>配送先が登録されていません。<a href="{{ route('profile.edit') }}">こちら</a>から登録してください。</p>
                        @endif
                    </div>
                </div>
                <hr>
            </div>

            <!-- === 右カラム === -->
            <div class="col-md-5">
                <div class="summary-card">
                    <div class="summary-row">
                        <span class="label">商品代金</span>
                        <span class="value">¥{{ number_format($item->price) }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="label">支払い方法</span>
                        <span class="value" id="payment-method-display">-</span>
                    </div>
                </div>
                <button type="submit" class="btn btn-purchase w-100 mt-3">購入する</button>
            </div>

        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentSelect = document.querySelector('select[name="payment_method"]');
        if (paymentSelect) {
            const paymentDisplay = document.getElementById('payment-method-display');
            paymentSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                paymentDisplay.textContent = selectedOption.value ? selectedOption.text : '-';
            });
        }
    });
</script>
@endsection