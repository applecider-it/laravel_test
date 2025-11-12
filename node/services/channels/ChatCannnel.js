import WebSocket from 'ws';

/**
 * 認証管理
 */
export default class ChatCannnel {
  newChat(wss, ws, incoming) {
    const data = {
      type: "newChat",
      user: ws.user.name,
      user_id: ws.user.id,
      message: incoming.message,
    };

    this.#broadcast(wss, data);  
  }

  #broadcast(wss, data) {
    const str = JSON.stringify(data);

    wss.clients.forEach((client) => {
      if (client.readyState === WebSocket.OPEN) {
        console.log(`broadcast: ${client.user?.name}`)
        if (client.user.id !== 'system') {
          console.log(`send: ${client.user?.name}`)
          client.send(str);
        }
      }
    });
  }
}
