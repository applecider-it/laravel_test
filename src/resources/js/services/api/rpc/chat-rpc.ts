import { sendRpc } from "../rpc";

/** メッセージ送信 */
export async function sendMessage(message: string, room: string) {
    return await sendRpc("chat", "send_message", {
        message,
        room,
    });
}
