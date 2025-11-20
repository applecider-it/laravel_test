# ユーザーモデル

論理削除前に、関連テーブルも論理削除している。

## DB

論理削除付き

| 項目名 | 内容 | 型 | 詳細 |
|--------|--------|--------|--------|
| name | 名前 | string | Laravel標準 |
| email | メールアドレス | string | Laravel標準 |
| email_verified_at | メールアドレス有効日時 | timestamp | Laravel標準 |
| password | パスワード | string | Laravel標準 |
| remember_token | リメンバートークン | rememberToken | Laravel標準 |

