
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

console.log(import.meta.env);

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  wsHost: import.meta.env.VITE_PUSHER_HOST,
  wsPort: import.meta.env.VITE_PUSHER_PORT,
  forceTLS: false,
  cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,   // ← ★必須（Pusher互換だから、実際には使われない）
  disableStats: true,
});

