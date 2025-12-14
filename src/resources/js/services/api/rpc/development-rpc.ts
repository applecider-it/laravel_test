import { sendRpc } from "../rpc";

/** スロージョブ開始 */
export async function startSlowJob(test: number, test2: any) {
    return await sendRpc("development", "start_slow_job", {
        test,
        test2,
    });
}

/** テストチャンネルにメッセージ送信 */
export async function sendTestChannel(message: string, user_id: number) {
    return await sendRpc("development", "send_test_channel", {
        message,
        user_id,
    });
}
