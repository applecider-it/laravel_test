
import Echo from 'laravel-echo';
import 'pusher-js';

/** Laravel Echoインスタンス */
export const MyEcho = new Echo({
  broadcaster: 'pusher',
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  wsHost: import.meta.env.VITE_PUSHER_HOST,
  wsPort: import.meta.env.VITE_PUSHER_PORT,
  forceTLS: false,
  cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,   // ← ★必須（Pusher互換だから、実際には使われない）
  disableStats: true,
});

