/**
 * サンプルジョブクライアント
 */
export default class SampleJobClient {
    /** 遅いジョブの経過表示(WebSocket) */
    onProgressWs(info, currentProgress) {
        if (info.type !== "sample_job_progress") return;

        const detail = info.detail;

        let message = info.title;

        message += ` (${detail.cursor} / ${detail.total})`;

        const p = (detail.cursor / detail.total) * 100;

        console.log("progress", p, detail.cursor);

        // 要所要所でトースト
        let toastMessage = null;
        for (const limit of [20, 40, 60, 80]) {
            if (currentProgress < limit && p >= limit) {
                toastMessage = message;
                break;
            }
        }

        return {
          toastMessage,
          progress: p,
        }
    }

    /** 遅いジョブの経過表示(Push通知) */
    onProgressPush(data) {
        const options = data.options;

        console.log(data);

        if (options.type !== "sample_job_progress") return;

        const detail = options.detail;
        const detailType = detail.detailType;

        let message = data.title;

        if (detailType === "end") message += ` (${detail.resultTotal})`

        return {
          toastMessage: message,
          toastType: detailType === "end" ? "alert" : "notice",
        }
    }
}
