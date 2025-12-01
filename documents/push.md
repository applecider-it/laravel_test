# Push通知

# Payload

```
{
  title: string, <- メッセージ
  options: {
    type: string, <- 通知タイプ
    notice: boolean, <- trueの場合は、プッシュ通知
    message: boolean, <- trueの場合は、アプリケーション側に送信
    ・
    ・後は任意
    ・例：サンプルジョブではdetailが追加される
    ・
  }
}
```

# Redisへの格納

rpushでpush_queueに追加される

```
{
  message: string, <- メッセージ Payloadではtitleになる部分
  options: array, <- Payloadのoptionsと同じ値
  endpoint: string,
  p256dh: string,
  auth: string
}
```
