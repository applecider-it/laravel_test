// インストール時
self.addEventListener("install", function (event) {
    console.log("Service Worker installing.");
});

// 通知があった時
self.addEventListener("push", async (event) => {
    console.log("Service Worker push.", event);

    const data = await event.data.json();

    console.log("Service Worker push data.", data);

    event.waitUntil(
        Promise.all([
            // 1. 通知を表示
            self.registration.showNotification(data.title),

            // 2. クライアント（window）にメッセージ送信
            sendClient("push-received", data),
        ])
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
