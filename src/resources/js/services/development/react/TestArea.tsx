import React, { useEffect, useState } from "react";

import { showToast, setIsLoading } from "@/services/ui/message";

/** テスト用コンポーネント */
export default function TestArea({}) {
    const [cnt, setCnt] = useState(0);

    useEffect(() => {}, []);

    const loadingTest = () => {
        console.log("Loading");
        setIsLoading(true);
        setTimeout(() => {
            setIsLoading(false);
        }, 2000);
    };

    const toastTest = (type) => {
        showToast(`トーストテスト ${type} ${cnt}`, type);
        setCnt(cnt + 1);
    };

    return (
        <div className="max-w-2xl mx-auto py-6">
            <button className="app-btn-primary mr-2" onClick={loadingTest}>
                Loading
            </button>

            <button
                className="app-btn-primary mr-2"
                onClick={() => toastTest("notice")}
            >
                Toast notice
            </button>
            <button
                className="app-btn-primary mr-2"
                onClick={() => toastTest("alert")}
            >
                Toast alert
            </button>
        </div>
    );
}
