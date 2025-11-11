require('dotenv').config({ path: __dirname + '/.env' });

const WebSocketServerApp = require('./services/WebSocketServerApp');

new WebSocketServerApp({
    host: '0.0.0.0',
    port: 8080,
});
