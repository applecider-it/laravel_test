import { sendRpc } from "../rpc";

/** 投稿 */
export async function storeTweet(content: string) {
    return await sendRpc("tweet", "store_tweet", {
        content,
    });
}
