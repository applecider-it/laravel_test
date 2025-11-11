require('dotenv').config();
const WebSocket = require('ws');
const jwt = require('jsonwebtoken');

const wss = new WebSocket.Server({ host: '0.0.0.0', port: 8080 });

wss.on('connection', (ws, req) => {
    const params = new URLSearchParams(req.url.replace('/?', ''));
    const token = params.get('token');

    if (!token) {
        ws.close();
        return;
    }

    try {
        const payload = jwt.verify(token, process.env.WS_JWT_SECRET);
        ws.user = { id: payload.sub, name: payload.name };
        console.log('Authenticated:', ws.user.name);
    } catch (e) {
        ws.close();
        return;
    }

    ws.on('message', (msg) => {
        const incoming = JSON.parse(msg);

        const data = {
            user: ws.user.name,
            user_id: ws.user.id,
            message: incoming.message,
        };

        wss.clients.forEach(client => {
            if (client.readyState === WebSocket.OPEN) {
                client.send(JSON.stringify(data));
            }
        });
    });

    ws.on('close', () => console.log('Disconnected:', ws.user?.name));
});
