<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>プロフィール設定</title>
    <style>
        .container {
            max-width: 400px;
            margin: 40px auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
        }

        .btn {
            background: #ff5f5f;
            color: #fff;
            border: none;
            padding: 10px 0;
            width: 100%;
            font-size: 16px;
        }

        .error {
            color: red;
        }
    </style>
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
    
    <div class="container">
        <h1>プロフィール設定</h1>
        @if(session('success'))
        <div style="color:green;">{{ session('success') }}</div>
        @endif
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>プロフィール画像</label><br>
                @if($user->profile_image)
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像" style="width:80px;height:80px;border-radius:50%;">
                @endif
                <input type="file" name="profile_image" class="form-control">
                @error('profile_image')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>ユーザー名</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                @error('name')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>郵便番号</label>
                <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" class="form-control">
                @error('postal_code')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>住所</label>
                <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form-control">
                @error('address')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>建物名</label>
                <input type="text" name="building" value="{{ old('building', $user->building) }}" class="form-control">
                @error('building')<div class="error">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn">更新する</button>
        </form>
    </div>
</body>

</html>