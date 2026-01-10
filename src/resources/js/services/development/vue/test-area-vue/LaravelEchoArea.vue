<script setup lang="ts">
/** Laravel Echo動作確認 */

import { onMounted } from "vue";

import { showToast } from "@/services/ui/message";
import { MyEcho } from "@/services/app/echo";
import { getAuthUser } from "@/services/app/application";
import { sendTestChannel } from "@/services/api/rpc/development-rpc";

onMounted(() => {
    const user = getAuthUser();
    console.log("auth user", user);
    MyEcho.private(`TestChannel.${user.id}`).listen("MessageSent", (e) => {
        console.log(e.message);

        showToast(e.message);
    });
});

/** Laravel Echoの動作確認 */
const echoTest = async (message, isMe) => {
    const user = getAuthUser();
    console.log("echoTest", message, isMe);

    const result = await sendTestChannel(message, isMe ? user.id : user.id + 1);
    console.log("result", result);
};
</script>

<template>
    <div>
        Laravel Echo動作確認

        <div class="mt-5 space-x-2">
            <button
                class="app-btn-primary"
                @click="() => echoTest('自分のIDのチャンネルに送信', true)"
            >
                自分のIDのチャンネルに送信
            </button>
            <button
                class="app-btn-primary"
                @click="() => echoTest('自分のID+1のチャンネルに送信', false)"
            >
                自分のID+1のチャンネルに送信（届かない）
            </button>
        </div>
    </div>
</template>
