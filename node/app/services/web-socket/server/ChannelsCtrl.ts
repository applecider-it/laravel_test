import ChatCannnel from '@/services/channels/ChatCannnel.js';
import BaseCannnel from '@/services/channels/BaseCannnel.js';

type Channels = {
  chat: ChatCannnel;
  base: BaseCannnel;
};

/**
 * WebSocket サーバーのチャンネル管理
 */
export default class ChannelsCtrl {
  /** 全てのチャンネルクラスを集めたハッシュ */
  channels: Channels;

  constructor() {
    this.channels = {
      chat: new ChatCannnel(),
      base: new BaseCannnel(),
    };
  }

  /** チャンネルごとのインスタンス */
  getChannel(channelStr: string) {
    const [channel, paramsStr] = channelStr.split(':');

    if (channel in this.channels) {
      return this.channels[channel as keyof Channels];
    }

    return this.channels.base;
  }
}
