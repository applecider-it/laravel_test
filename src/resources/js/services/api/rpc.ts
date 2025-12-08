import axios from "axios";

/** RPC送信 */
export async function sendRpc(method, params = {}) {
    const response = await axios.post("/rpc/" + method, params);
    //console.log("response.data", response.data);
    return response.data;
}

