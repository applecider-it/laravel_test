import { useState, useCallback } from "react";

import { Toast } from "../types";

let cnt = 0;

/** トースト用フック */
export default function useToast(): [Toast[], Function] {
    const [toasts, setToasts] = useState<Toast[]>([]);

    /** トースト追加 */
    const showToast = useCallback(
        (message: string, type: string = "notice") => {
            const id = cnt++;
            setToasts((prev) => [...prev, { id, message, type }]);
            setTimeout(() => {
                setToasts((prev) => prev.filter((toast) => toast.id !== id));
            }, 3000); // 3秒で自動削除
        },
        []
    );

    return [toasts, showToast];
}
