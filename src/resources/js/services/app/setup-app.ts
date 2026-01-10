import "./bootstrap";

import Alpine from "alpinejs";
import { createApp } from "vue";

import { initServiceWorker } from "@/services/service-worker/service-worker";
import { getAuthUser } from "./application";

import AppCommon from "./vue/AppCommon.vue";

window.Alpine = Alpine;
Alpine.start();

const user = getAuthUser();
console.log("auth user", user);

if (user) {
    initServiceWorker(user);
}

const el = document.getElementById("app-container-common");

if (el) {
    createApp(AppCommon).mount(el);
}
