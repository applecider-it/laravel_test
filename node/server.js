// server.js
const WebSocket = require('ws');

const wss = new WebSocket.Server({ host: '0.0.0.0', port: 8080 });

wss.on('connection', (ws) => {
    console.log('Client connected');

    ws.on('message', (msg) => {
        // msgはJSON文字列
        const data = JSON.parse(msg);
        console.log('Received:', data);

        // 全クライアントに送信
        wss.clients.forEach(client => {
            if (client.readyState === WebSocket.OPEN) {
                client.send(JSON.stringify(data));
            }
        });
    });

    ws.on('close', () => console.log('Client disconnected'));
});
