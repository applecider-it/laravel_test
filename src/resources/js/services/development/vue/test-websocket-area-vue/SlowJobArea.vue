<script setup lang="ts">
/** 遅いジョブ動作確認 */

import { ref, onMounted } from "vue";

import { showToast } from "@/services/ui/message";
import { startSlowJob } from "@/services/api/rpc/development-rpc";
import { setPushCallback } from "@/services/service-worker/service-worker";

import type ProgressClient from "@/services/ui/ProgressClient";

import ProgressBar from "@/services/ui/vue/message/ProgressBar.vue";

import type SampleJobClient from "../../SampleJobClient";

interface Props {
    progressClient: ProgressClient;
    sampleJobClient: SampleJobClient;
}

const props = defineProps<Props>();

const progress = ref<number>(0);

onMounted(() => {
    setPushCallback(onProgressPush);

    props.progressClient.callback = onProgressWs;
});

/** 遅いジョブの経過表示(WebSocket) */
const onProgressWs = (data) => {
    const info = data.data.info;

    const ret = props.sampleJobClient.getProgressWsInfo(info, progress.value);
    if (!ret) return;

    if (ret.toastMessage) showToast(ret.toastMessage);
    progress.value = ret.progress;
};

/** 遅いジョブの経過表示(Push通知) */
const onProgressPush = (data) => {
    const ret = props.sampleJobClient.getProgressPushInfo(data);
    if (!ret) return;

    showToast(ret.toastMessage, ret.toastType);
};

/** 遅いジョブの開始 */
const SlowJobTest = async () => {
    console.log("SlowJobTest");
    progress.value = 0;
    const data = await startSlowJob(123, { test3: 456 });
    console.log("SlowJobTest response data", data);
    showToast("送信しました。");
};
</script>

<template>
    <div>
        遅いジョブ動作確認

        <div class="mt-5 space-y-2">
            <button className="app-btn-orange" @click="SlowJobTest">
                遅いジョブ
            </button>

            <ProgressBar :progress="progress" />

            <button
                @click="() => (progress = progress + 10)"
                className="app-btn-secondary"
            >
                進める
            </button>
        </div>
    </div>
</template>
