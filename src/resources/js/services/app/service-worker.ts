import axios from "axios";

export async function initServiceWorker() {
    await navigator.serviceWorker.register("/service-worker.js");

    // SW が active になるのを待つ
    const readyRegistration = await navigator.serviceWorker.ready;

    // Push通知の権限リクエスト
    const permission = await Notification.requestPermission();
    console.log("Notification permission:", permission);

    const vapidPublicKey = (
        document.querySelector(
            'meta[name="vapid-public-key"]'
        ) as HTMLMetaElement
    )?.content;
    console.log(vapidPublicKey);

    if (permission === "granted") {
        let subscription =
            await readyRegistration.pushManager.getSubscription();

        console.log(subscription);

        // 登録済みの場合は処理しない
        if (subscription) {
            console.log("subscription登録済み");
            return;
        }

        console.log("subscriptionを作成");

        // PushManagerでSubscriptionを作成
        subscription = await readyRegistration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: vapidPublicKey,
        });
        //console.log('Push Subscription:', subscription);

        // subscription.endpoint などをサーバーに保存する必要あり
        const json = subscription.toJSON() as any;

        const subscriptionData = {
            endpoint: subscription.endpoint,
            p256dh: json.keys.p256dh,
            auth: json.keys.auth,
        };

        console.log(subscriptionData);

        const response = await axios.post(
            "/push_notification",
            subscriptionData
        );
        console.log("response.data", response.data);
    } else {
        console.log("Push通知が許可されていません");
    }
}
