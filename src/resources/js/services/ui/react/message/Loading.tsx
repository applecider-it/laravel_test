/** ローディングコンポーネント */
export default function Loading({ isLoading }: { isLoading: boolean }) {
    return (
        <>
            {isLoading ? (
                <div className="fixed inset-0 bg-black bg-opacity-10 flex justify-center items-center z-50 select-none">
                    <div
                        className="w-10 h-10 border-2 border-gray-500 border-t-transparent rounded-full animate-spin shadow-md"
                        style={{ animationDuration: '0.8s' }}
                    ></div>
                </div>
            ) : null}
        </>
    );
}
