import React, { useEffect, useState, useRef } from "react";

import { showToast, setIsLoading } from "@/services/ui/message";
import ProgressBar from "@/services/ui/react/message/ProgressBar";

import { setPushCallback } from "@/services/service-worker/service-worker";

import { startSlowJob } from "../development-rpc";

let cnt2 = 0;

/** テスト用コンポーネント */
export default function TestArea({ progressClient }) {
    const [cnt, setCnt] = useState(0);
    const refCnt = useRef(0);
    const [progress, setProgress] = useState(0); // 0〜100
    const refProgress = useRef(0);

    useEffect(() => {
        setPushCallback(onProgressPush);

        progressClient.callback = onProgressWs;

        return () => {
            setPushCallback(null);
        };
    }, []);

    /** 遅いジョブの経過表示(WebSocket) */
    const onProgressWs = (data) => {
        const info = data.data.info;

        if (info.type !== "sample_job_progress") return;

        const detail = info.detail;

        let message = info.title;

        message += ` (${detail.cursor} / ${detail.total})`;

        const p = (detail.cursor / detail.total) * 100;

        setProgress(p);

        console.log("progress", p, detail.cursor);

        // 要所要所でトースト
        for (const limit of [20, 40, 60, 80]) {
            if (refProgress.current < limit && p >= limit) {
                showToast(message);
                break;
            }
        }

        refProgress.current = p;
    };

    /** 遅いジョブの経過表示(Push通知) */
    const onProgressPush = (data) => {
        const options = data.options;

        console.log(data);

        if (options.type !== "sample_job_progress") return;

        const detail = options.detail;
        const detailType = detail.detailType;

        let message = data.title;

        showToast(message, detailType === "end" ? "alert" : "notice");
    };

    /** ロード画面の動作確認 */
    const loadingTest = () => {
        console.log("Loading");
        setIsLoading(true);
        setTimeout(() => {
            setIsLoading(false);
        }, 2000);
    };

    /** トーストの動作確認 */
    const toastTest = (type) => {
        refCnt.current++;
        setCnt(refCnt.current);
        cnt2++;

        const msg = `トーストテスト type:${type} cnt:${cnt} refCnt:${refCnt.current} cnt2:${cnt2}`;
        console.log(msg);
        showToast(msg, type);
    };

    /** 遅いジョブの開始 */
    const SlowJobTest = async () => {
        console.log("SlowJobTest");
        refProgress.current = 0;
        setProgress(0);
        const data = await startSlowJob(123, { test3: 456 });
        console.log("SlowJobTest response data", data);
        showToast("送信しました。");
    };

    return (
        <div className="py-6 border-gray-500 border-2 p-5 space-y-3">
            <div className="mb-6 text-lg">react動作確認</div>

            <div>
                <button
                    className="app-btn-secondary mr-2"
                    onClick={loadingTest}
                >
                    Loading
                </button>
            </div>

            <div>
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

            <div className="space-y-2">
                <button className="app-btn-orange" onClick={SlowJobTest}>
                    遅いジョブ
                </button>

                <ProgressBar progress={progress} />

                {/* ボタン */}
                <button
                    onClick={() => setProgress(progress + 10)}
                    className="app-btn-secondary"
                >
                    進める
                </button>
            </div>
        </div>
    );
}
