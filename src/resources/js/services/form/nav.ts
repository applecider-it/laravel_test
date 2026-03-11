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

        console.log("checkDirty init");

        isInit = true;
    }
}

/** 離脱チェック */
export function checkDirty(form) {
    console.log("checkDirty setup");

    init();
    form.addEventListener("change", () => {
        console.log("checkDirty on");
        isDirty = true;
    });

    form.addEventListener("submit", () => {
        console.log("checkDirty off");
        isDirty = false;
    });
}
