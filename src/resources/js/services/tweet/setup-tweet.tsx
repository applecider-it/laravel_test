/**
 * ツイートのセットアップ
 */

import { createApp } from "vue";
import TweetArea from "./vue/TweetArea.vue";
import TweetClient from "./TweetClient";

const el = document.getElementById("tweet-app") as HTMLElement | null;

if (el) {
  const all = JSON.parse(el.dataset.all as string);

  console.log(all);

  const tweetClient = new TweetClient(
    all.token,
    all.wsHost,
    all.user
  );

  createApp(TweetArea, {
    initialTweets: all.tweets,
    tweetClient: tweetClient,
  }).mount(el);
}
