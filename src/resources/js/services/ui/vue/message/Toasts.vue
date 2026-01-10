<script setup lang="ts">
import type { Toasts, Toast } from "../../types";

defineProps<{
    toasts: Toasts;
}>();

function computedClass(toast: Toast) {
    const color = toast.type === "alert" ? "red-200" : "blue-200";

    const bgClass = `bg-${color}`;

    return [
        "text-sm",
        bgClass,
        "border-2",
        "border-gray-400",
        "text-black",
        "px-3",
        "py-1",
        "rounded-lg",
        "shadow-lg",
        "toast-slide-in",
    ];
}
</script>

<template>
    <div class="fixed top-4 right-4 space-y-2 z-50">
        <div
            v-for="toast in toasts"
            :key="toast.id"
            :class="computedClass(toast)"
        >
            {{ toast.message }}
        </div>
    </div>
</template>

<style scoped>
.toast-slide-in {
    animation: toast-slide-in 0.5s ease-out;
}

@keyframes toast-slide-in {
    from {
        transform: translateX(20px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>
