import React, { useEffect, useState } from "react";

import Toasts from "@/services/ui/react/message/Toasts";
import Loading from "@/services/ui/react/message/Loading";
import useToast from "@/services/ui/react-hook/useToast";
import {
    setupMessage
} from "@/services/ui/message";

/** アプリケーションの共通部分 */
export default function AppCommon({}) {
    const [toasts, showToast] = useToast();
    const [isLoading, setIsLoading] = useState(false);

    useEffect(() => {
        setupMessage(showToast, setIsLoading);
    }, []);

    return (
        <div>
            <Toasts toasts={toasts} />
            <Loading isLoading={isLoading} />
        </div>
    );
}
