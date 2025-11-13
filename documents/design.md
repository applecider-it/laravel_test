# 設計

## 構成

Laravelをモノリスにする。

websocketはnodejsのマイクロサービス。

aiはpythonのマイクロサービス。

```
node/ <- nodeマイクロサービス
  documents/ <- nodeマイクロサービス固有のドキュメント
python/ <- pythonマイクロサービス
  documents/ <- pythonマイクロサービス固有のドキュメント
src/ <- Laravelモノリス
  documents/ <- Laravelモノリス固有のドキュメント
documents/ <- 全体のドキュメント
```
