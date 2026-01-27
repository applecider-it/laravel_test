import { WebSocketUser, Incoming } from '@/services/web-socket/types.js';

/**
 * ベースチャンネル
 */
export default class BaseCannnel {
  constructor() {}

  /** WebSocketへの直接送信を有効にするか返す */
  enableWebSocketSend(){
    return false;
  }

  /** ユーザー情報のクライアントへの送信を有効にするか返す */
  enableSendUsers(){
    return false;
  }

  /** メッセージ取得時のデータ生成 */
  async callbackCreateData(sender: WebSocketUser, incoming: Incoming) {
    return incoming.data;
  }

  /** メッセージをブロードキャストしていいか返す */
  async callbackCheckSend(
    sender: WebSocketUser,
    user: WebSocketUser,
    incoming: Incoming
  ) {
    return true;
  }
}
