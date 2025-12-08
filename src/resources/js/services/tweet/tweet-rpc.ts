import { rpc } from "@/services/api/rpc";

/** 投稿 */
export async function storeTweet(content: string) {
    return await rpc("tweet.api.store_api", {
        content,
    });
}
