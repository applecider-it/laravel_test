/**
 * ツイートのエントリーポイント
 */

import React from 'react';
import { createRoot } from 'react-dom/client';
import TweetApp from './TweetApp';

const el = document.getElementById('tweet-app');

if (el) {
    const initialTweets = JSON.parse(el.dataset.tweets);
    const currentUser = JSON.parse(el.dataset.user);

    const root = createRoot(el);
    root.render(<TweetApp initialTweets={initialTweets} currentUser={currentUser} />);
}
