import {
  BroadcastDataTweet,
  BroadcastDataChat,
  BroadcastDataProgress,
} from '@/services/channels/types';

/** WebSocketオブジェクトに追加するユーザー情報 */
export interface WebSocketUser {
  id: number | 'system';
  info: {
    name: string;
  };
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
  info: any;
  id: number | 'system';
  data: BroadcastDataTweet | BroadcastDataChat | BroadcastDataProgress;
};
