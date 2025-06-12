<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>会員登録</title>
</head>

<body>
    <a href="{{ url('/') }}">
        <img src="{{ asset('images/logo.svg') }}" alt="ロゴ" style="height: 40px;">
    </a>
    <h1>会員登録</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <label>ユーザ名</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
            @error('name')<div style="color:red;">{{ $message }}</div>@enderror
        </div>
        <div>
            <label>メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email')<div style="color:red;">{{ $message }}</div>@enderror
        </div>
        <div>
            <label>パスワード</label>
            <input type="password" name="password" required>
            @error('password')<div style="color:red;">{{ $message }}</div>@enderror
        </div>
        <div>
            <label>確認用パスワード</label>
            <input type="password" name="password_confirmation" required>
        </div>
        <button type="submit">登録</button>
    </form>
    <a href="{{ route('login') }}">ログインはこちら</a>
</body>

</html>