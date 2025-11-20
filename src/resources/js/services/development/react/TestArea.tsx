import React, { useEffect, useState } from "react";

import { showToast, setIsLoading } from "@/services/ui/message";

let cnt2 = 0;

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
        showToast(`トーストテスト ${type} ${cnt} ${cnt2}`, type);
        setCnt(cnt + 1);
        cnt2++;
    };

    return (
        <div className="py-6 border-gray-500 border-2 p-5">
            <div className="mb-6 text-lg">react動作確認</div>

            <div>
                <button
                    className="app-btn-secondary mr-2"
                    onClick={loadingTest}
                >
                    Loading
                </button>
            </div>

            <div className="mt-5">
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
                <button
                    className="app-btn-primary mr-2"
                    onClick={() => {
                        toastTest("notice");
                        toastTest("alert");
                    }}
                >
                    Toast 2
                </button>
            </div>
        </div>
    );
}
