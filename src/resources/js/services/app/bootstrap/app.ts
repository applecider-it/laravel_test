import { createApp } from "vue";

import { initServiceWorker } from "@/services/service-worker/service-worker";
import { getAuthUser } from "../application";

import AppCommon from "../vue/AppCommon.vue";

const user = getAuthUser();
console.log("auth user", user);

if (user) {
    initServiceWorker(user);
}

// 共通JSの初期化
const el = document.getElementById("app-container-common");
if (el) {
    createApp(AppCommon).mount(el);
}
