@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">配送先住所の変更</h1>

                <form method="POST" action="{{ route('address.update') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">郵便番号</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">住所</label>
                        <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">建物名</label>
                        <input type="text" name="building" value="{{ old('building', $user->building) }}" class="form-control">
                    </div>

                    <input type="hidden" name="item_id" value="{{ request('item_id') ?? $item_id ?? '' }}">

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection