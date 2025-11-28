/**
 * ツイートのエントリーポイント
 */

import React from "react";
import { createRoot } from "react-dom/client";
import TweetArea from "./react/TweetArea";

import TweetClient from "./TweetClient";

const el: any = document.getElementById("tweet-app");

if (el) {
    const all = JSON.parse(el.dataset.all);

    console.log(all);

    const tweetClient = new TweetClient(all.token, all.wsHost, all.user);

    const root = createRoot(el);
    root.render(
        <TweetArea initialTweets={all.tweets} tweetClient={tweetClient} />
    );
}
