# 設計

MVCSにして、ビジネスロジックはサービスクラスにまとめている。

## 通常のLaravel以外の構成

```
app/
  Services/ ビジネスロジックなど
    カテゴリーごとのディレクトリ/
      サービスラス実体

resources/
  js/
    entrypoints/ app.js以外のエントリーポイント
    services/
      カテゴリーごとのディレクトリ/
        サービスラス実体
    types/
```
