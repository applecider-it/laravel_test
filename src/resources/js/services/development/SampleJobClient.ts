/**
 * サンプルジョブクライアント
 */
export default class SampleJobClient {
    /** 対象のプログレスタイプ */
    static TARGET_PROGRESS_TYPE = 'sample_job_progress';

    /** 遅いジョブの経過表示(WebSocket)用のデータ生成 */
    getProgressWsInfo(info, currentProgress) {
        if (info.type !== SampleJobClient.TARGET_PROGRESS_TYPE) return;

        const detail = info.detail;

        let message = info.title;

        message += ` (${detail.cursor} / ${detail.total})`;

        const nextProgress = (detail.cursor / detail.total) * 100;

        console.log("progress", nextProgress, detail.cursor);

        // 要所要所でトースト
        let toastMessage = null;
        for (const limit of [20, 40, 60, 80]) {
            if (currentProgress < limit && nextProgress >= limit) {
                toastMessage = message;
                break;
            }
        }

        return {
          toastMessage,
          progress: nextProgress,
        }
    }

    /** 遅いジョブの経過表示(Push通知)用のデータ生成 */
    getProgressPushInfo(data) {
        const options = data.options;

        console.log(data);

        if (options.type !== SampleJobClient.TARGET_PROGRESS_TYPE) return;

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
