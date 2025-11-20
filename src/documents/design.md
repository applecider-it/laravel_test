# 設計

MVCSにして、ビジネスロジックは、カテゴリーごとにフォルダを分けたサービスクラスにまとめている。

javascriptを使わないでtypescriptだけ利用している。

## 通常のLaravel以外の構成

```
app/
  Http/
    Controllers/
      Admin/ <- 独自実装の管理画面
      TweetController.php <- UserTweetController.phpにしないで、Tweetというドメインを表すようにしている。
      .
      .
      .
  Models/
    User/
      Tweet.php <- サブテーブルは、階層的に配置
    User.php
      .
      .
      .
  Services/ <- ビジネスロジックなど
    (カテゴリーごとにディレクトリを分けて、そのなかにサービスクラスを配置している)
    Admin/ <- 管理画面関連
    Channels/ <- WebSocketチャンネル関連
    Sample/ <- サービスクラス実装例
    .
    .
    .

config/
  myapp.php <- アプリケーション独自の設定ファイル

documents/ <- Laravelモノリス固有のドキュメント

public/
  manifest.json <- pwa用ファイル
  service-worker.js <- サービスワーカー

lang/
  ja/
    app.php <- アプリケーション独自の言語ファイル

resources/
  js/
    entrypoints/ <- app.js以外のエントリーポイント
    services/ <- ビジネスロジックなど
      (カテゴリーごとにディレクトリを分けて、そのなかにサービスクラスを配置している)
    types/ <- グローバルな型情報置き場
    app.ts
  views/
    admin/ <- 独自実装の管理画面
    .
    .
    .
routes/
  admin_auth.php <- 独自実装の管理画面。web.phpから呼んでいる。
  admin.php <- 独自実装の管理画面。web.phpから呼んでいる。
    .
    .
    .
```
