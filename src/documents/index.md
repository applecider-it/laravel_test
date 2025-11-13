# Laravelモノリス

# 実装内容

- ツイート機能
- チャット

# 構成

MVCS(サービスクラス)

## 通常のLaravel以外の構成

```
app/
  Filament/ 管理画面管理Filamentパッケージの実体
  Services/ ビジネスロジックなど
    カテゴリーごとのディレクトリ/
      サービスラス実体

resources/
  js/
    jsルートはエントリーポイント
    services/
      カテゴリーごとのディレクトリ/
        サービスラス実体
    types/
  views/
    filament/ 管理画面管理Filamentパッケージのテンプレート
```
