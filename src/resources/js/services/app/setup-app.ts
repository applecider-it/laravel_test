import "./bootstrap/axios";
import "./bootstrap/alpinejs";
import "./bootstrap/container";
import "./bootstrap/dirtycheck";
import "./bootstrap/window";
import "./bootstrap/app";

console.log("setup app");

// 動作確認
import { showToast, setIsLoading } from "@/services/ui/message";

import { getAuthUser } from "./application";

const user = getAuthUser();
console.log("auth user", user);

/*
setTimeout(() => {
    showToast("Test");
    setIsLoading(true);
}, 1000);
 */
