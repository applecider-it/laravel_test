import { createApp } from "vue";

import AppCommon from "../vue/AppCommon.vue";

// 共通JSの初期化
const el = document.getElementById("app-container-common");
if (el) {
    createApp(AppCommon).mount(el);
}
