/**
 * Javascriptテストのセットアップ
 */

import React from "react";
import { createRoot } from "react-dom/client";
import TestAreaReact from "./react/TestAreaReact";

import { createApp } from "vue";
import TestAreaVue from "./vue/TestAreaVue.vue";

let el: any;

el = document.getElementById("vue-test-root");

if (el) {
    const all = JSON.parse(el.dataset.all);

    console.log('vue all', all);

    const app = createApp(TestAreaVue, {
        testValue: all.testValue,
        formData: all.formData,
    });
    app.mount("#vue-test-root");
}

el = document.getElementById("react-test-root");

if (el) {
    const all = JSON.parse(el.dataset.all);

    console.log('react all', all);

    const root = createRoot(el);
    root.render(<TestAreaReact />);
}
