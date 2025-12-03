# プッシュ通知登録情報モデル

## DB

論理削除付き

edgeの情報だとstringでは小さいのでtextにしている。

| 項目名 | 内容 | 型 | 詳細 |
|--------|--------|--------|--------|
| endpoint | エンドポイント | text |  |
| p256dh | p256dh | text |  |
| auth | auth | text |  |
| failure_count | 失敗カウント | tinyInteger |  |
| user_id | ユーザーID | foreignId | [ユーザー](./User.md) |

