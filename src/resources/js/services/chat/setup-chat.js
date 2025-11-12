/**
 * チャットのセットアップ
 */

import ChatWebSocketClient from './ChatWebSocketClient';

const chatClient = new ChatWebSocketClient(window.WS_TOKEN, 'chat-box', 'message', 'send-btn');

