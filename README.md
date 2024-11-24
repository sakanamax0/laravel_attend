# Atte(ある企業の勤怠管理システム)
<img src="img/date.png" alt="date">
<img src="img/stamp.png" alt="stamp">
<img src="img/register.png" alt="register">
<img src="img/login.png" alt="login">

## 作成した目的
人事評価のため

##　機能一覧
1.会員登録・ログイン・ログアウト
※Laravelの認証機能を利用
2.勤務開始・勤務終了
※日を跨いだ時点で翌日の出勤操作に切り替える
3.休憩開始・休憩終了
※１日で何度も休憩が可能
4.ページネーション
※５件ずつ取得
5.日付別勤怠情報取得
※日付検索機能あり

## 環境構築
**Dockerビルド**
1. `git clone git@github.com:estra-inc/confirmation-test-contact-form.git`
2. DockerDesktopアプリを立ち上げる
3. `docker-compose up -d --build`

> *MacのM1・M2チップのPCの場合、`no matching manifest for linux/arm64/v8 in the manifest list entries`のメッセージが表示されビルドができないことがあります。
エラーが発生する場合は、docker-compose.ymlファイルの「mysql」内に「platform」の項目を追加で記載してください*
``` bash
mysql:
    platform: linux/x86_64
    image: mysql:8.0.26
    environment:
```

**Laravel環境構築**
1. `docker-compose exec php bash`
2. `composer install`
3. 「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成
4. .envに以下の環境変数を追加
``` text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
5. アプリケーションキーの作成
``` bash
php artisan key:generate
```

6. マイグレーションの実行
``` bash
php artisan migrate
```

7. シーディングの実行
``` bash
php artisan db:seed
```

## 使用技術(実行環境)
- PHP8.3.0
- Laravel8.83.27
- MySQL8.0.26

##　テーブル設計
<img src="img/table.png" alt="table">

## ER図
![ER図](erd.png)

## URL
- 開発環境：http://localhost/
- phpMyAdmin:：http://localhost:8080/