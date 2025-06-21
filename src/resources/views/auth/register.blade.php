<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
        }

        .header {
            background-color: #000;
            padding: 1rem 0;
        }

        .header img {
            height: 30px;
        }

        .card {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .btn-register {
            background-color: #ff6b6b;
            color: white;
        }

        .btn-register:hover {
            background-color: #ff5252;
            color: white;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="container">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo.svg') }}" alt="ロゴ">
            </a>
        </div>
    </header>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-5">
                        <h1 class="card-title text-center mb-5">会員登録</h1>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label text-muted">ユーザー名</label>
                                <input type="text" name="name" value="{{ old('name') }}" required class="form-control form-control-lg">
                                @error('name')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-muted">メールアドレス</label>
                                <input type="email" name="email" value="{{ old('email') }}" required class="form-control form-control-lg">
                                @error('email')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-muted">パスワード</label>
                                <input type="password" name="password" required class="form-control form-control-lg">
                                @error('password')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-muted">確認用パスワード</label>
                                <input type="password" name="password_confirmation" required class="form-control form-control-lg">
                            </div>
                            <div class="d-grid mt-5">
                                <button type="submit" class="btn btn-register btn-lg">登録する</button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <a href="{{ route('login') }}" class="text-decoration-none">ログインはこちら</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>