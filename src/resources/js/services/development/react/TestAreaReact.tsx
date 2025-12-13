import React, { useEffect, useState, useRef } from "react";

import { showToast, setIsLoading } from "@/services/ui/message";
import ProgressBar from "@/services/ui/react/message/ProgressBar";
import Modal from "@/services/ui/react/popup/Modal";

import { setPushCallback } from "@/services/service-worker/service-worker";

import { startSlowJob } from "@/services/api/rpc/development-rpc";

import type ProgressClient from "@/services/ui/ProgressClient";
import type SampleJobClient from "../SampleJobClient";

let cnt2 = 0;

type Props = {
    progressClient: ProgressClient;
    sampleJobClient: SampleJobClient;
};

/** テスト用コンポーネント */
export default function TestAreaReact({
    progressClient,
    sampleJobClient,
}: Props) {
    const [cnt, setCnt] = useState(0);
    const refCnt = useRef(0);
    const [progress, setProgress] = useState(0); // 0〜100
    const refProgress = useRef(0);
    const [open, setOpen] = useState(false);
    const [modalValue, setModalValue] = useState("");

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

        const ret = sampleJobClient.getProgressWsInfo(info, refProgress.current);
        if (!ret) return;

        if (ret.toastMessage) showToast(ret.toastMessage);
        setProgress(ret.progress);
        refProgress.current = ret.progress;
    };

    /** 遅いジョブの経過表示(Push通知) */
    const onProgressPush = (data) => {
        const ret = sampleJobClient.getProgressPushInfo(data);
        if (!ret) return;

        showToast(ret.toastMessage, ret.toastType);
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

    /** モーダルウィンドウの値の確認 */
    const confirmModalValue = () => {
        alert(modalValue);
    };

    return (
        <>
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

                <div className="space-y-2">
                    <div className="space-x-2">
                        <button
                            className="app-btn-orange"
                            onClick={() => setOpen(true)}
                        >
                            モーダルウィンドウ
                        </button>
                        <button
                            onClick={confirmModalValue}
                            className="app-btn-secondary"
                        >
                            確認
                        </button>
                    </div>
                    <div>modalValue: {modalValue}</div>
                </div>
            </div>

            <Modal isOpen={open} onClose={() => setOpen(false)}>
                <h2 className="text-xl font-bold mb-2">モーダルタイトル</h2>

                <div className="my-4">
                    <textarea
                        rows={3}
                        cols={40}
                        className="w-full border rounded p-2"
                        placeholder="What's happening?"
                        value={modalValue}
                        onChange={(e) => setModalValue(e.target.value)}
                    />
                </div>

                <button
                    onClick={() => setOpen(false)}
                    className="app-btn-secondary"
                >
                    閉じる
                </button>
            </Modal>
        </>
    );
}
