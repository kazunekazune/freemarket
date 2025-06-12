<h1>商品購入画面</h1>
<div>
    <img src="{{ asset('storage/' . $item->image_path) }}" alt="商品画像" style="width:120px;">
    <div>
        <strong>{{ $item->name }}</strong>
        <p>￥{{ number_format($item->price) }}</p>
    </div>
</div>

@if ($errors->any())
<div style="color:red;">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('purchase.store', $item->id) }}">
    @csrf

    <div>
        <label>支払い方法</label>
        <select name="payment_method">
            <option value="">選択してください</option>
            <option value="convenience_store">コンビニ払い</option>
            <option value="credit_card">カード払い</option>
        </select>
    </div>

    <div>
        <label>配送先</label>
        <p>
            〒{{ $user->postal_code }}<br>
            {{ $user->address }} {{ $user->building }}
            <a href="{{ route('address.edit', ['item_id' => $item->id]) }}">変更する</a>
        </p>
    </div>

    <div>
        <button type="submit">購入する</button>
    </div>
</form>