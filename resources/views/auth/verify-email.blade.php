<!-- resources/views/auth/verify-email.blade.php -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <a href="{{ url('/') }}">
        <img src="{{ asset('images/logo.svg') }}" alt="ロゴ" style="height: 40px;">
    </a>

    <meta charset="UTF-8">
    <title>メール認証</title>
</head>

<body>
    <p>登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください。</p>
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">認証はこちらから</button>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" style="background:none;border:none;color:#007bff;text-decoration:underline;cursor:pointer;">
                認証メールを再送する
            </button>
        </form>
    </form>
</body>

</html>