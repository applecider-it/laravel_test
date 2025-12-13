# Push通知

## Payload

```
{
  title: string, <- メッセージ
  options: {
    type: string, <- 通知タイプ
    notice: boolean, <- trueの場合は、プッシュ通知
    message: boolean, <- trueの場合は、アプリケーション側に送信
    detail: hash <- 機能ごとの詳細データ
  }
}
```

### サンプルジョブの経過表示

`App\Services\Jobs\SampleJobService`

```
type: 'sample_job_progress'

detaul: {}
```

## Redisへの格納

rpushで`[redis_prefix]push_queue`に追加される

```
{
  title: string, <- Payloadのtitleと同じ値
  options: array, <- Payloadのoptionsと同じ値
  endpoint: string,
  p256dh: string,
  auth: string,
  id: integer <- PushNotification.id,
}
```

## 送信結果のRedisへの格納

rpushで`[redis_prefix]push_queue_result`に追加される

```
{
  status: boolean,
  id: integer <- PushNotification.id,
}
```

## 送信結果後処理

PushNotificationモデルのデータは、古くなっている場合があるため、自動削除処理をしています。

ただし、一時的に送信が失敗することもあるため、その場合の対応もしています。

### 実行タイミングは２パターン

- Laravelからの送信の場合は、すぐに後処理。
- Nodeで一括送信の場合は、Redisに蓄積しているデータを使い、バッチ処理。

### 後処理のフロー

1. 失敗したPushNotificationモデルのレコードは失敗カウントを加算。
1. 一定回数失敗したら、論理削除。
1. カウントアップされているレコードでも、論理削除される前に、成功したら、カウントは０になる。

