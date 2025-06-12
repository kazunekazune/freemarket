<!-- resources/views/address/edit.blade.php -->
<h1>配送先住所の変更</h1>
<form method="POST" action="{{ route('address.update') }}">
    @csrf
    <div>
        <label>郵便番号</label>
        <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
    </div>
    <div>
        <label>住所</label>
        <input type="text" name="address" value="{{ old('address', $user->address) }}">
    </div>
    <div>
        <label>建物名</label>
        <input type="text" name="building" value="{{ old('building', $user->building) }}">
    </div>
    <button type="submit">保存</button>

    <input type="hidden" name="item_id" value="{{ request('item_id') ?? $item_id ?? '' }}">
</form>