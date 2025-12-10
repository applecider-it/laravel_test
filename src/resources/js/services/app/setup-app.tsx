import "./bootstrap";

import Alpine from "alpinejs";

import { initServiceWorker } from "@/services/service-worker/service-worker";

import React from "react";
import { createRoot } from "react-dom/client";
import { getAuthUser } from "./application";

import AppCommon from "./react/AppCommon";

window.Alpine = Alpine;

Alpine.start();

const user = getAuthUser();
console.log('auth user', user);
if (user) {
    initServiceWorker(user);
}

const el: any = document.getElementById("app-container-common");
if (el) {
    const root = createRoot(el);
    root.render(<AppCommon />);
}
