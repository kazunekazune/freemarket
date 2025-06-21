@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px;">
    <div class="card">
        <div class="card-header">
            配送先の変更
        </div>
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('purchase.address.update', $item->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="postal_code" class="form-label">郵便番号</label>
                    <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">住所</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->address) }}" required>
                </div>

                <div class="mb-3">
                    <label for="building" class="form-label">建物名</label>
                    <input type="text" class="form-control" id="building" name="building" value="{{ old('building', $user->building) }}">
                </div>

                <button type="submit" class="btn btn-primary w-100">更新する</button>
            </form>
        </div>
    </div>
</div>
@endsection