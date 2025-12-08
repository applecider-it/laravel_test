import { sendRpc } from "../rpc";

/** スロージョブ開始 */
export async function startSlowJob(test: number, test2: any) {
    return await sendRpc("development", "start_slow_job", {
        test,
        test2,
    });
}
