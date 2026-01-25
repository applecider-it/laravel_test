# websocket連携

## 独自実装

websocketはnodeで連携する。

Laravelと双方向APIで連携。

認証はJWTを使う。

## Laravel Echo

一部、Laravel Echoでも実装している。

- [ドキュメント](./websocket-echo.md)

## チャンネル名の定義

`channelname:param1,param2...`

## コネクション時のパラメーター

| 項目名 | 内容 | 型 | 詳細 |
|--------|--------|--------|--------|
| token | 認証情報を含むJWTトークン | string |  |

## token

| 項目名 | 内容 | 型 | 詳細 |
|--------|--------|--------|--------|
| id | ID | integer | ユーザーID |
| name | 表示名 | string |  |
| channel | 接続するチャンネル | string | つまり、同時に複数のチャンネルには接続できない。 |
| iat | 現在日時 | integer |  |
| exp | 有効期限 | integer |  |

## WebSocketへのメッセージ送信時

```
{
  data: hash,
}
```

| 項目名 | 内容 | 型 | 詳細 |
|--------|--------|--------|--------|
| data | チャンネルごとの情報ハッシュ | hash |  |


## Redis Pub/Sub連携メッセージ送信時

Pub/Subのチャンネル名: `[redis_prefix]broadcast`

```
{
  channel: string, <- WebSocketチャンネル名
  data: hash, <- 上記の、「メッセージ送信時」のdataの部分と同じ
  type: 'message',
}
```

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
  info: {
    type: string,
    title: string,
    detail: hash, <- 機能ごとの詳細データ
  },
}
```

#### サンプルジョブの経過表示

`App\Services\Jobs\SampleJobService`

```
type: 'sample_job_progress'

detaul: {
  cursor: integer,
  total: integer,
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
    id: number,
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

メッセージ送信時と同じ

### 経過表示の場合のdata

メッセージ送信時と同じ


## 接続時に自分に送信

```
{
  type: 'connected',
  users: [
    {
      id: number,
      name: string,
    },
    .
    .
  ],
}
```

## 接続時にブロードキャスト

```
{
  type: 'connectOther',
  sender: {
    name: string,
    id: number,
  },
  data: {
    user: {
      name: string,
      id: number,
    }
  }
}
```

## 切断時にブロードキャスト

```
{
  type: 'disconnectOther',
  sender: {
    name: string,
    id: number,
  },
  data: {
    user: {
      name: string,
      id: number,
    }
  }
}
```





