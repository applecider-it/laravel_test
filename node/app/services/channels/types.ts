/** チャットのブロードキャスト時のデータ */
export type BroadcastDataChat = {
  message: string;
}

/** ツイートのブロードキャスト時のデータ */
export type BroadcastDataTweet = {
  tweet: string;
}

/** 経過表示のブロードキャスト時のデータ */
export type BroadcastDataProgress = {
  info: any;
}
