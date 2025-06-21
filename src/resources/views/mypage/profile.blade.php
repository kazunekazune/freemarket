@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center mt-5">
    <div class="w-100" style="max-width: 600px;">
        <h2 class="text-center mb-4">プロフィール設定</h2>

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="d-flex align-items-center mb-4">
                <img src="{{ asset('storage/' . ($user->profile_image ?? 'images/default_avatar.png')) }}" alt="User Avatar" class="rounded-circle mr-4" style="width: 100px; height: 100px; object-fit: cover;">
                <div>
                    <input type="file" name="profile_image" id="profile_image" class="d-none">
                    <label for="profile_image" class="btn btn-outline-danger">画像を選択する</label>
                </div>
            </div>

            <div class="form-group">
                <label for="name">ユーザー名</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group">
                <label for="postal_code">郵便番号</label>
                <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code ?? '') }}">
            </div>

            <div class="form-group">
                <label for="address">住所</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->address ?? '') }}">
            </div>

            <div class="form-group">
                <label for="building">建物名</label>
                <input type="text" class="form-control" id="building" name="building" value="{{ old('building', $user->building ?? '') }}">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-danger w-100" style="background-color: #f54242;">更新する</button>
            </div>
        </form>
    </div>
</div>
@endsection