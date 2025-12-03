import { useState } from "react";

import { clamp } from "@/services/data/number";

type Prop = {
    progress: number;
};

/** プログレスバーコンポーネント */
export default function ProgressBar({ progress }: Prop) {
    const clamped = clamp(progress, 0, 100);

    return (
        <div className="w-72 space-y-1">
            {/* プログレスバー */}
            <div className="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                <div
                    className="h-full bg-green-500 transition-all duration-300"
                    style={{ width: `${clamped}%` }}
                />
            </div>

            {/* 数値表示 */}
            <p className="text-gray-700 font-medium">{clamped}%</p>
        </div>
    );
}
