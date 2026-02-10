import { sendRpc } from "../rpc";

/** Laravel Echoでメッセージ送信 */
export async function sendMessage(message: string, room: string, options: any) {
    return await sendRpc("chat-echo", "send_message", {
        message,
        room,
        options,
    });
}
