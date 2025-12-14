import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

import "./echo";

window.Echo.private('chat').listen("MessageSent", (e) => {
    console.log(e.message);
});
