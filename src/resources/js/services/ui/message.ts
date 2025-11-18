/** トースト出力用ReactHook */
let showToastHook;
/** ローディング画面のオンオフ用ReactHook */
let setIsLoadingHook;

/** メッセージ管理のセットアップ */
export function setupMessage(showToastArg, setIsLoadingArg) {
    showToastHook = showToastArg;
    setIsLoadingHook = setIsLoadingArg;
}

/** トースト出力 */
export function showToast(message: string, type: string = "notice") {
    showToastHook(message, type);
}

/** ローディング画面のオンオフ */
export function setIsLoading(isLoading: boolean) {
    setIsLoadingHook(isLoading);
}
