<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>

<body>
    <a href="{{ url('/') }}">
        <img src="{{ asset('images/logo.svg') }}" alt="ロゴ" style="height: 40px;">
    </a>
    <h1>ログイン</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label>メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')<div style="color:red;">{{ $message }}</div>@enderror
        </div>
        <div>
            <label>パスワード</label>
            <input type="password" name="password" required>
            @error('password')<div style="color:red;">{{ $message }}</div>@enderror
        </div>
        <button type="submit">ログイン</button>
    </form>
    <a href="{{ route('register') }}">会員登録はこちら</a>
</body>

</html>