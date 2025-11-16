import axios from "axios";

const serviceWorkerUrl = "/service-worker.js";

/** サービスワーカーの初期化 */
export async function initServiceWorker() {
    setEvent();
    setupServiceWorker();
}

/** サービスワーカー用イベント追加 */
function setEvent() {
    navigator.serviceWorker.addEventListener("message", (event) => {
        console.log("Push received in window:", event.data);
        if (event.data.type === "push-received") {
            alert("Message from SW: " + event.data.payload.title);
        }
    });
}

/** サービスワーカーのセットアップ */
async function setupServiceWorker() {
    await navigator.serviceWorker.register(serviceWorkerUrl);

    // SW が active になるのを待つ
    const readyRegistration = await navigator.serviceWorker.ready;

    // Push通知の権限リクエスト
    const permission = await Notification.requestPermission();
    console.log("Notification permission:", permission);

    if (permission === "granted") {
        let subscription =
            await readyRegistration.pushManager.getSubscription();

        console.log(subscription);

        // 登録済みの場合は処理しない
        if (subscription) {
            console.log("subscription登録済み");
            return;
        }

        await registSubscription(readyRegistration);
    } else {
        console.log("Push通知が許可されていません");
    }
}

/** プッシュ通知登録 */
async function registSubscription(readyRegistration) {
    console.log("subscriptionを作成");

    // PushManagerでSubscriptionを作成
    const subscription = await readyRegistration.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: vapidPublicKey(),
    });

    const json = subscription.toJSON() as any;

    const subscriptionData = {
        endpoint: subscription.endpoint,
        p256dh: json.keys.p256dh,
        auth: json.keys.auth,
    };

    console.log(subscriptionData);

    // サーバーに保存
    const response = await axios.post("/push_notification", subscriptionData);
    console.log("response.data", response.data);
}

/** プッシュ通知用パブリックキー */
function vapidPublicKey() {
    const vapidPublicKey = (
        document.querySelector(
            'meta[name="vapid-public-key"]'
        ) as HTMLMetaElement
    )?.content;
    console.log(vapidPublicKey);

    return vapidPublicKey;
}
