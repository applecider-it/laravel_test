<script setup lang="ts">
import { ref, onMounted } from "vue";
import TweetForm from "./tweet-area/TweetForm.vue";
import TweetList from "./tweet-area/TweetList.vue";
import type TweetClient from "../TweetClient";
import { setIsLoading } from "@/services/ui/message";
import { TweetContainer } from "../types";

const props = defineProps<{
    initialTweets: any[];
    tweetClient: TweetClient;
}>();

const tweetContainers = ref<TweetContainer[]>([]);
const content = ref("");
const errors = ref<Record<string, any>>({});

/** ツイート一覧から、ツイートコンテナー一覧を作成 */
const makeTweetContainers = (tweets: any[]): TweetContainer[] => {
    return tweets.map((tweet) => ({
        tweet,
        isNew: false,
    }));
};

/* handleSubmit も親で管理 */
const handleSubmit = async (e: Event) => {
    e.preventDefault();

    setIsLoading(true);
    try {
        await props.tweetClient.sendTweet(content.value);

        content.value = "";
        errors.value = {};
    } catch (error: any) {
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors;
        }
    } finally {
        setIsLoading(false);
    }
};

onMounted(() => {
    props.tweetClient.addTweet = (tweet: any) => {
        tweetContainers.value = [
            { tweet, isNew: true },
            ...tweetContainers.value,
        ];
    };

    tweetContainers.value = makeTweetContainers(props.initialTweets);
});
</script>

<template>
    <div>
        <TweetForm
            v-model:content="content"
            :errors="errors"
            @submit="handleSubmit"
        />
        <TweetList :tweetContainers="tweetContainers" />
    </div>
</template>
