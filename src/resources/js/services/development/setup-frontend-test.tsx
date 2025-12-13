/**
 * Reactテストのセットアップ
 */

import React from "react";
import { createRoot } from "react-dom/client";
import TestAreaReact from "./react/TestAreaReact";

import { createApp } from "vue";
import TestAreaVue from "./vue/TestAreaVue.vue";

import ProgressClient from "@/services/ui/ProgressClient";

import SampleJobClient from "./SampleJobClient";

let el: any;

el = document.getElementById("react-test-root");

if (el) {
    const all = JSON.parse(el.dataset.all);

    console.log(all);

    const sampleJobClient = new SampleJobClient();

    const progressClient = new ProgressClient(all.token, all.wsHost);

    const root = createRoot(el);
    root.render(<TestAreaReact progressClient={progressClient} sampleJobClient={sampleJobClient} />);
}

el = document.getElementById("vue-test-root");

if (el) {
    const all = JSON.parse(el.dataset.all);

    console.log(all);

    const app = createApp(TestAreaVue, all);
    app.mount("#vue-test-root");
}
