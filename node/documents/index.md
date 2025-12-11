# Nodeマイクロサービス

websocket連携の仲介。

push通知一斉送信。

# 構成

```
app/
  entrypoints/ エントリーポイント
  services/ 実体
    カテゴリーごとのディレクトリ/
      サービスクラス実体
```

# その他

## Typescriptなのに、.jsを拡張子にしている理由

ビルドしたときに、こうしないと動かないから。

