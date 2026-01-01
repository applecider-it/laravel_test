import React from "react";

type Props = {
    isOpen: boolean;
    onClose: () => void;
    children: React.ReactNode;
};

/**
 * モーダルウィンドウ
 */
export default function Modal({ isOpen, onClose, children }: Props) {
    return (
        <div
            className={`
                fixed inset-0
                bg-black/50
                flex
                justify-center
                items-center
                z-50
                transition-opacity duration-500 ease-in-out
                ${
                    isOpen
                        ? "opacity-100 pointer-events-auto"
                        : "opacity-0 pointer-events-none"
                }
            `}
            onClick={onClose}
        >
            <div
                className="bg-white rounded-xl p-6 shadow-xl"
                onClick={(e) => e.stopPropagation()}
            >
                {children}
            </div>
        </div>
    );
}
