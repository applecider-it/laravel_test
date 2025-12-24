/** WebSocketオブジェクトに追加するユーザー情報 */
export interface WebSocketUser {
  name: string;
  id: number | 'system';
  token: string;
  channel: string;
}

/** 送信されてくるデータ */
export type Incoming = {
  data: any;
};

/** ブロードキャスト用送信データ */
export type BroadcastSendData = {
  type: string;
  sender: {
    id: number | 'system';
    name: string;
  };
  data: any;
};
