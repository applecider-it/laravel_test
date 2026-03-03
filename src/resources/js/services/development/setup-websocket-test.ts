/**
 * WebSocketテストのセットアップ
 */

import { createApp } from "vue";
import TestWebSocketAreaVue from "./vue/TestWebSocketAreaVue.vue";

import ProgressClient from "@/services/ui/ProgressClient";

import SampleJobClient from "./SampleJobClient";

let el: any;

el = document.getElementById("vue-test-root");

if (el) {
    const all = JSON.parse(el.dataset.all);

    console.log('vue all', all);

    const progressClient = new ProgressClient(all.token, all.wsHost);
    const sampleJobClient = new SampleJobClient();

    const app = createApp(TestWebSocketAreaVue, {
        progressClient,
        sampleJobClient,
    });
    app.mount("#vue-test-root");
}
