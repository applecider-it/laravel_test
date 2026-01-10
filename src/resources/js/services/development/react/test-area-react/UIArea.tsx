import React, { useEffect, useState, useRef } from "react";

import { showToast, setIsLoading } from "@/services/ui/message";

let cnt2 = 0;

/** UI動作確認 */
export default function UIArea() {
    const [cnt, setCnt] = useState(0);
    const refCnt = useRef(0);

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

    return (
        <>
            <div className="space-y-2">
                <div>UI動作確認（reactからvueを動かす）</div>

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
            </div>
        </>
    );
}
