import "./bootstrap";

import Alpine from "alpinejs";

import { initServiceWorker } from "./service-worker";

window.Alpine = Alpine;

Alpine.start();

initServiceWorker();
