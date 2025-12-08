import { rpc } from "@/services/api/rpc";

/** スロージョブ開始 */
export async function startSlowJob(test: number, test2: any) {
    return await rpc("development.frontend.start_slow_job", {
        test,
        test2,
    });
}
