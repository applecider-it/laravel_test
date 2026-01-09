<script setup lang="ts">
import { TweetContainer } from "../../types";

defineProps<{
    tweetContainers: TweetContainer[];
}>();
</script>

<template>
    <div class="space-y-4">
        <div
            v-for="tweetContainer in tweetContainers"
            :key="tweetContainer.tweet.id"
            class="border rounded p-4"
        >
            <p v-if="tweetContainer.isNew" class="text-blue-500">new</p>

            <p class="text-gray-800">
                {{ tweetContainer.tweet.content }}
            </p>

            <p class="text-gray-500 text-sm">
                by {{ tweetContainer.tweet.user.name }} -
                {{ new Date(tweetContainer.tweet.created_at).toLocaleString() }}
            </p>
        </div>
    </div>
</template>
