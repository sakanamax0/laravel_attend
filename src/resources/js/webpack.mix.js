const mix = require('laravel-mix');

// JavaScriptとCSSのビルド設定
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')  // 必要に応じてscssも設定
    .styles([
        'resources/css/attendance.css',  // 新しいCSSファイルの追加
    ], 'public/css/attendance.css');
