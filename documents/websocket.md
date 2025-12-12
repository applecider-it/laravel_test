# websocket連携

websocketはnodeで連携する。

Laravelと双方向APIで連携。

認証はJWTを使う。

## チャンネル名の定義

`channelname:param1,param2...`

## コネクション時のパラメーター

| 項目名 | 内容 | 型 | 詳細 |
|--------|--------|--------|--------|
| token | 認証情報を含むJWTトークン | string |  |

## token

| 項目名 | 内容 | 型 | 詳細 |
|--------|--------|--------|--------|
| sub | ID | integer | idに相当する項目。laravel内部ではidとして管理し、送受信時はsubとして送受信する。 |
| name | 表示名 | string |  |
| channel | 接続するチャンネル | string | つまり、同時に複数のチャンネルには接続できない。 |
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
  name: string,
  target_user_id: integer, <- 送信先を絞り込むとき
}
```

### Tweetの場合のdata

```
{
  tweet: {
    id: integer,
    content: string,
    created_at: string,
    user: {
      id: integer,
      name: string,
    }
  },
}
```

### 経過表示の場合のdata

```
{
  info: any,
}
```

## Redis Pub/Sub連携

Pub/Subのチャンネル名: `[redis_prefix]broadcast`

```
{
  channel: string, <- WebSocketチャンネル名
  data: hash, <- 上記の、「メッセージ送信時」のdataの部分

}
```

## メッセージ送信直後のレスポンス

```
{
  type: 'sended',
  ok: true,
}
```

## ブロードキャスト時のレスポンス

```
{
  type: 'message',
  sender: {
    name: string,
    id: number | 'system',
  },
  data: hash, <- チャンネルごとに任意
}
```

### チャットの場合のdata

```
{
  message: string,
  name: string,
}
```

### Tweetの場合のdata

```
{
  tweet: {
    id: integer,
    content: string,
    created_at: string,
    user: {
      id: integer,
      name: string,
    }
  },
}
```

### 経過表示の場合のdata

```
{
  info: any,
}
```

