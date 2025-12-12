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
  message: string, <- メッセージ Payloadではtitleになる部分
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
