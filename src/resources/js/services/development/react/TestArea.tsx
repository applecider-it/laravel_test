import axios from "axios";

import React, { useEffect, useState, useRef } from "react";

import { showToast, setIsLoading } from "@/services/ui/message";

import { setPushCallback } from "@/services/service-worker/service-worker";

let cnt2 = 0;

/** テスト用コンポーネント */
export default function TestArea({}) {
    const [cnt, setCnt] = useState(0);
    const refCnt = useRef(0);

    useEffect(() => {
        setPushCallback(progress);

        return () => {
            setPushCallback(null);
        };
    }, []);

    /** 遅いジョブの経過表示 */
    const progress = (data) => {
        const options = data.options;

        console.log(data);

        if (options.type !== "sample_job_progress") return;

        const detail = options.detail;
        const detailType = detail.detailType;

        let message = data.title;

        if (detailType === "progress") {
            message += ` (${detail.cursor} / ${detail.total})`;
        }

        showToast(message, detailType === "end" ? "alert" : "notice");
    };

    const loadingTest = () => {
        console.log("Loading");
        setIsLoading(true);
        setTimeout(() => {
            setIsLoading(false);
        }, 2000);
    };

    const toastTest = (type) => {
        refCnt.current++;
        setCnt(refCnt.current);
        cnt2++;

        const msg = `トーストテスト type:${type} cnt:${cnt} refCnt:${refCnt.current} cnt2:${cnt2}`;
        console.log(msg);
        showToast(msg, type);
    };

    const SlowJobTest = async () => {
        console.log("SlowJobTest");
        const response = await axios.post("/development/slow_job_test", {});
        console.log("response.data", response.data);
        showToast('送信しました。');
        return response.data.data;
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
                cnt: {cnt}
            </div>

            <div className="mt-5">
                <button className="app-btn-orange mr-2" onClick={SlowJobTest}>
                    遅いジョブ
                </button>
            </div>
        </div>
    );
}
