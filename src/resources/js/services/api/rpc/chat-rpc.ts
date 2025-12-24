import { sendRpc } from "../rpc";

/** メッセージ送信 */
export async function sendMessage(message: string) {
    return await sendRpc("chat", "send_message", {
        message,
    });
}

/** Laravel Echoでメッセージ送信 */
export async function sendMessageEcho(message: string, room: string, options: any) {
    return await sendRpc("chat", "send_message_echo", {
        message,
        room,
        options,
    });
}
