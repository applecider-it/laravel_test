import axios from "axios";

/** RPC送信 */
export async function sendRpc(category: string, method: string, params = {}) {
    const response = await axios.post(`/rpc/${category}/${method}`, params);
    //console.log("response.data", response.data);
    return response.data;
}
