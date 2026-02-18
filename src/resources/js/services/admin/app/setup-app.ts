import "@/services/app/bootstrap";

import Alpine from "alpinejs";
import { createApp } from "vue";

import { getAuthUser } from "@/services/app/application";

import AppCommon from "@/services/app/vue/AppCommon.vue";

window.Alpine = Alpine;
Alpine.start();

const adminUser = getAuthUser();
console.log("auth adminUser", adminUser);

const el = document.getElementById("app-container-common");

if (el) {
    createApp(AppCommon).mount(el);
}

/*
// UI動作確認
import { showToast, setIsLoading } from '@/services/ui/message';

setTimeout(() => {
  showToast('Test');
  setIsLoading(true);
}, 1000);
 */
