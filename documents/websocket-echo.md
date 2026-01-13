# Laravel Echo

## ブロードキャスト時

### チャット

```
{
  message: string,
  user: {
    id: integer,
    name: string,
  }
}
```

### サンプルチャンネル

```
{
  message: string,
  id: integer, <- ユーザーID
}
```