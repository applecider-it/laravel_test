/**
 * Reactテストのセットアップ
 */

import React from "react";
import { createRoot } from "react-dom/client";
import TestArea from "./react/TestArea";

const el: any = document.getElementById("test-root");

if (el) {
    const all = JSON.parse(el.dataset.all);

    console.log(all);

    const root = createRoot(el);
    root.render(<TestArea />);
}
