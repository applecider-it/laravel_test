import { initServiceWorker } from "@/services/service-worker/service-worker";
import { getAuthUser } from "../application";

const user = getAuthUser();
console.log("auth user", user);

if (user) {
    initServiceWorker(user);
}
