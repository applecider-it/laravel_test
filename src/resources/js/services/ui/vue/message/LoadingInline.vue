<template>
    <div
        class="flex space-x-2 justify-center items-center my-28 opacity-0 fadeInAccel"
    >
        <span class="w-3 h-3 bg-gray-500 rounded-full animate-bounce"></span>
        <span
            class="w-3 h-3 bg-gray-500 rounded-full animate-bounce"
            style="animation-delay: -0.2s"
        ></span>
        <span
            class="w-3 h-3 bg-gray-500 rounded-full animate-bounce"
            style="animation-delay: -0.4s"
        ></span>
    </div>
</template>

<script setup lang="ts"></script>

<style scoped>
.fadeInAccel {
    animation: fade-in-accel 3s cubic-bezier(0.16, 1, 0.3, 1) 1s forwards;
}

@keyframes fade-in-accel {
    0% {
        opacity: 0;
        transform: scale(0.5);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}
</style>
