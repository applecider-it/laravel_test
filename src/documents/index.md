# Laravelモノリス

- [設計](./design.md)

## 実装内容

- [ツイート機能](./features/tweet.md)
- [チャット](./features/chat.md)

## モデル

`id`, `created_at`, `updated_at`, `deleted_at`の説明は省略しています。

カラムごとのvalidationは再利用しやすいようにモデルにまとめています。

- [ユーザー](./Models/User.md)
  - [ユーザーツイート](./Models/User/Tweet.md)
- [管理者](./Models/AdminUser.md)
- [プッシュ通知登録情報](./Models/PushNotification.md)