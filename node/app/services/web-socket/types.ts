/** WebSocketオブジェクトに追加するユーザー情報 */
export interface WebSocketUser {
  id: any;
  info: {
    name: string;
  };
  token: string;
  channel: string;
  channelData: any;
}

/** 送信されてくるデータ */
export type Incoming = {
  data: any;
};

/** ブロードキャスト用送信データ */
export type SendData = {
  type: string;
  info: any;
  id: number | string;
  data: any;
};
