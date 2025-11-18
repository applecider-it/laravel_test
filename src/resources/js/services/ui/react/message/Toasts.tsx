import { Toasts, Toast } from "../../types";

type Props = {
    toasts: Toasts;
};

/** トーストリストコンポーネント */
export default function ToastsComponent({ toasts }: Props) {
    const computedClass = (toast: Toast) => {
        const color = toast.type === "alert" ? "red-200" : "blue-200";
        return `text-sm bg-${color} border-2 border-gray-400 text-black px-3 py-1 rounded-lg shadow-lg animate-slide-in`;
    };

    return (
        <div className="fixed top-4 right-4 space-y-2 z-50">
            {toasts.map((toast) => {
                return (
                    <div key={toast.id} className={computedClass(toast)}>
                        {toast.message}
                    </div>
                );
            })}
        </div>
    );
}
