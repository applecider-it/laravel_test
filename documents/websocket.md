# websocket連携

websocketはnodeで連携する。

Laravelと双方向APIで連携。

認証はJWTを使う。

## コネクション時のパラメーター

### token

認証情報を含むJWTトークン

### channel

接続するチャンネル。

つまり、同時に複数のチャンネルには接続できない。

ここはまだ適当なので後で変えるかも。


## token

### sub

idに相当するlaravel内部ではidとして管理し、送受信時はsubとして送受信する。

### name

表示名。

### iat

現在日時

### exp

有効期限

## メッセージ送信時

### channel

送信対象のチャンネル

### その他

任意



