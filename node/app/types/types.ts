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

/** 何らかのJsonを表す型 */
export type AnyJson = Record<string, any>;
