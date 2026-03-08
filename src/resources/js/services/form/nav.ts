let isDirty = false;
let isInit = false;

/** 離脱チェックの初期化 */
function init() {
    if (!isInit) {
        window.addEventListener("beforeunload", function (e) {
            if (isDirty) {
                e.preventDefault();
                e.returnValue = "";
            }
        });

        isInit = true;
    }
}

/** 離脱チェック */
export function checkDirty(form) {
    init();
    form.addEventListener("change", () => {
        isDirty = true;
    });

    form.addEventListener("submit", () => {
        isDirty = false;
    });
}
