import "htmx.org";

document.body.addEventListener("htmx:configRequest", (event: Event) => {
    const e = event as CustomEvent<{
        headers: Record<string, string>;
    }>;

    // htmxでPOST送信できるようにトークンを追加する
    const token = document.querySelector<HTMLMetaElement>(
        'meta[name="csrf-token"]',
    )?.content;

    if (token) {
        e.detail.headers["X-CSRF-TOKEN"] = token;
    }
});
