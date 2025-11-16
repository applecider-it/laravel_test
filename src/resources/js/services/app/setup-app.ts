import "./bootstrap";

import Alpine from "alpinejs";

import { initServiceWorker } from "@/services/service-worker/service-worker";

window.Alpine = Alpine;

Alpine.start();

initServiceWorker();
