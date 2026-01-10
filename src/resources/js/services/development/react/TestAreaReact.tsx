import React from "react";

import UIArea from "./test-area-react/UIArea";

/** テスト用コンポーネント */
export default function TestAreaReact() {
    return (
        <>
            <div className="py-6 border-gray-500 border-2 p-5 space-y-3">
                <div className="mb-6 text-lg">react動作確認</div>

                <div className="space-y-3">
                    <div>
                        <UIArea />
                    </div>
                </div>
            </div>
        </>
    );
}
