import { initServiceWorker } from "@/services/service-worker/service-worker";
import { getAuthUser } from "../application";

const user = getAuthUser();

if (user) {
    initServiceWorker(user);
}
