// インストール時
self.addEventListener("install", function (event) {
    console.log("Service Worker installing.");
});

// 通知があった時
self.addEventListener("push", async (event) => {
    console.log("Service Worker push.", event);

    const data = await event.data.json();

    console.log("Service Worker push data.", data);

    const options = data.options;

    const notice = options.notice ?? null;
    const message = options.message ?? null;

    const list = [];

    // 通知を表示
    if (notice) list.push(self.registration.showNotification(data.title));

    // クライアント（window）にメッセージ送信
    if (message) list.push(sendClient("push-received", data));

    event.waitUntil(
        Promise.all(list)
    );
});

/** クライアントへのMessage送信 */
function sendClient(type, data) {
    return self.clients
        .matchAll({ includeUncontrolled: true })
        .then((clients) => {
            clients.forEach((client) => {
                client.postMessage({
                    type: type,
                    payload: data,
                });
            });
        });
}
