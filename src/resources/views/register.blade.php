<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="register-container" style="display: flex; justify-content: center; align-items: center; min-height: 80vh;">
        <div style="width: 300px; padding: 20px; background-color: #f3f3f3; text-align: center; border-radius: 8px;">
            <h2>会員登録</h2>

            @if ($errors->any())
                <div style="color: red; margin-bottom: 15px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}">
                @csrf
                <div style="margin-bottom: 15px;">
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}" 
                        placeholder="名前"
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="メールアドレス"
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="パスワード" 
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        placeholder="確認用パスワード" 
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <button 
                    type="submit" 
                    style="width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px;">
                    会員登録
                </button>
            </form>

            <p style="margin-top: 15px;">
                アカウントをお持ちの方はこちらから<br> 
                <a href="{{ route('login') }}">ログイン</a>
            </p>
        </div>
    </div>
</body>
</html>