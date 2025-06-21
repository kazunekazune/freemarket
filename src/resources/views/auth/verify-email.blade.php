<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メール認証 - {{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8fafc;
        }

        .header {
            background-color: #000;
            padding: 15px 30px;
        }

        .header-logo {
            color: #fff;
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
        }

        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 70px);
            /* header height */
        }

        .card {
            width: 100%;
            max-width: 500px;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 40px;
        }

        .btn-custom {
            background-color: #8c8c8c;
            color: white;
            border: none;
            padding: 10px 40px;
        }

        .resend-link {
            font-size: 14px;
            color: #007bff;
            margin-top: 20px;
            display: inline-block;
        }
    </style>
</head>

<body>
    <header class="header">
        <a href="/" class="header-logo">COACHTECH</a>
    </header>

    <div class="card-container">
        <div class="card">
            <div class="card-body text-center">
                @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('ご登録のメールアドレスに新しい確認リンクを送信しました。') }}
                </div>
                @endif

                <p class="mb-4">{{ __('登録していただいたメールアドレスに認証メールを送信しました。') }}<br>{{ __('メール認証を完了してください。') }}</p>

                @if(config('app.env') === 'local')
                <a href="http://localhost:8025" target="_blank" class="btn btn-custom my-3">{{ __('認証はこちらから') }}</a>
                @endif

                <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline resend-link">{{ __('認証メールを再送する') }}</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>