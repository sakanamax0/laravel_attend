<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="login-container" style="display: flex; justify-content: center; align-items: center; min-height: 80vh;">
        <div style="width: 300px; padding: 20px; background-color: #f3f3f3; text-align: center; border-radius: 8px;">
            <h2>ログイン</h2>

            
            @if ($errors->any())
                <div class="alert alert-danger" style="margin-bottom: 15px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            
            @if (session('status'))
                <div class="alert alert-success" style="margin-bottom: 15px;">
                    {{ session('status') }}
                </div>
            @endif

            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div style="margin-bottom: 15px;">
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="メールアドレス" 
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" 
                        required>
                </div>
                <div style="margin-bottom: 15px;">
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="パスワード" 
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" 
                        required>
                </div>
                <button type="submit" style="width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px;">
                    ログイン
                </button>
            </form>

            <p style="margin-top: 15px;">
                アカウントをお持ちでない方はこちらから<br> 
                <a href="{{ route('register.form') }}">会員登録</a>
            </p>

            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="width: 100%; padding: 10px; background-color: #dc3545; color: white; border: none; border-radius: 4px;">
                    ログアウト
                </button>
            </form>
        </div>
    </div>
</body>
</html>
