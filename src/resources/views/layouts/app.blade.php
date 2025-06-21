<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フリマアプリ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
    <style>
        body {
            background-color: #f0f2f5;
        }

        .navbar.bg-dark {
            background-color: #000 !important;
        }

        .navbar-brand img {
            height: 30px;
        }

        .search-form {
            flex: 1;
            max-width: 500px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-sell {
            background-color: white;
            color: white;
            border: none;
            text-decoration: none;
        }

        .btn-sell:hover {
            background-color: #ff5252;
            color: black;
            ;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
            <div class="container">
                <a href="{{ route('items.index') }}" class="navbar-brand">
                    <img src="{{ asset('images/logo.svg') }}" alt="ロゴ">
                </a>

                <form action="{{ route('items.search') }}" method="GET" class="search-form d-flex mx-auto">
                    <input type="text" name="keyword" placeholder="なにをお探しですか？" class="form-control" value="{{ request('keyword') }}">
                </form>

                <div class="nav-links">
                    @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">ログイン</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">会員登録</a>
                    @endguest

                    @auth
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link text-white py-1 px-2">ログアウト</button>
                    </form>
                    <a href="{{ route('mypage') }}" class="nav-link text-white py-1 px-2">マイページ</a>
                    <a href="{{ route('items.create') }}" class="btn btn-light btn-sm">出品</a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-5">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>