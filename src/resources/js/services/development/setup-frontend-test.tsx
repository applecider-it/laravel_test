/**
 * Reactテストのセットアップ
 */

import React from "react";
import { createRoot } from "react-dom/client";
import TestArea from "./react/TestArea";

import { createApp } from "vue";
import TestAreaVue from "./vue/TestAreaVue.vue";

let el: any;

el = document.getElementById("react-test-root");

if (el) {
    const all = JSON.parse(el.dataset.all);

    console.log(all);

    const root = createRoot(el);
    root.render(<TestArea />);
}

el = document.getElementById("vue-test-root");

if (el) {
    const all = JSON.parse(el.dataset.all);

    console.log(all);

    const app = createApp(TestAreaVue, all);
    app.mount("#vue-test-root");
}
