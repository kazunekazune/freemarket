<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン - {{ config('app.name', 'COACHTECH') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            background-color: #000;
            padding: 1rem 2rem;
        }

        .header-logo img {
            height: 24px;
            /* ロゴの高さを調整 */
        }

        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 450px;
            padding: 2rem;
            background-color: #fff;
        }

        .footer {
            text-align: center;
            padding: 1rem;
            background-color: #000;
            color: #fff;
        }

        .btn-custom-red {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
            padding: 0.5rem 1rem;
            font-weight: bold;
        }

        .register-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
        }
    </style>
</head>

<body>

    <header class="header">
        <a href="/" class="header-logo">
            <img src="{{ asset('images/logo.svg') }}" alt="COACHTECH">
        </a>
    </header>

    <main class="main-content">
        <div class="login-card">
            <h2 class="text-center mb-4">ログイン</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">メールアドレス</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">パスワード</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-custom-red">
                        ログインする
                    </button>
                </div>

                <a class="register-link" href="{{ route('register') }}">
                    会員登録はこちら
                </a>
            </form>
        </div>
    </main>

    <footer class="footer">
        <small>COACHTECH</small>
    </footer>

</body>

</html>