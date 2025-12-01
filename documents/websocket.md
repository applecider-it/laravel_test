# websocket連携

websocketはnodeで連携する。

Laravelと双方向APIで連携。

認証はJWTを使う。

## コネクション時のパラメーター

| 項目名 | 内容 | 型 | 詳細 |
|--------|--------|--------|--------|
| token | 認証情報を含むJWTトークン | string |  |
| channel | 接続するチャンネル | string | つまり、同時に複数のチャンネルには接続できない。ここはまだ適当なので後で変えるかも。 |

## token

| 項目名 | 内容 | 型 | 詳細 |
|--------|--------|--------|--------|
| sub | ID | string \| integer | idに相当する項目。laravel内部ではidとして管理し、送受信時はsubとして送受信する。 |
| name | 表示名 | string |  |
| iat | 現在日時 | integer |  |
| exp | 有効期限 | integer |  |

## メッセージ送信時

```
{
  data: hash,
}
```

| 項目名 | 内容 | 型 | 詳細 |
|--------|--------|--------|--------|
| data | チャンネルごとの情報ハッシュ | hash |  |

### チャットの場合のdata

```
{
  message: string,
  target_user_id: integer, <- 送信先を絞り込むとき
}
```

### Tweetの場合のdata

```
{
  content: string,
}
```


## メッセージ送信直後のレスポンス

```
{
  type: 'sended',
  ok: true,
}
```


## ブロードキャスト時

```
{
  type: 'sended以外の任意',
  ・
  ・他は任意
  ・
}
```

### チャットの場合

```
{
  type: string,
  info: {
    name: string,
  }
  id: number | string,
  data: {
    message: string,
  }
}
```

### Tweetの場合

```
{
  type: string,
  info: {
    name: string,
  }
  id: number | string,
  data: {
    content: string,
  }
}
```


