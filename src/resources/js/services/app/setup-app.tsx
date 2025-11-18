import "./bootstrap";

import Alpine from "alpinejs";

import { initServiceWorker } from "@/services/service-worker/service-worker";

import React from "react";
import { createRoot } from "react-dom/client";

import AppCommon from "./react/AppCommon";

window.Alpine = Alpine;

Alpine.start();

initServiceWorker();

const el: any = document.getElementById("app-container-common");
if (el) {
    const root = createRoot(el);
    root.render(<AppCommon />);
}
