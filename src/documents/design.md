# 設計

MVCSにして、ビジネスロジックはサービスクラスにまとめている。

試験的に、filament, 独自管理画面の両方を試している。

## 通常のLaravel以外の構成

```
app/
  Filament/ 管理画面管理Filamentパッケージの実体
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
  views/
    filament/ 管理画面管理Filamentパッケージのテンプレート
```
