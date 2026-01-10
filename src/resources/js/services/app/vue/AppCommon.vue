<template>
    <div>
        <Toasts :toasts="toasts" />
        <Loading :isLoading="isLoading" />
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";

import Toasts from "@/services/ui/vue/message/Toasts.vue";
import Loading from "@/services/ui/vue/message/Loading.vue";
import { useToast } from "@/services/ui/vue-hook/useToast";
import { setupMessage } from "@/services/ui/message";

const { toasts, showToast } = useToast();

const isLoading = ref(false);

onMounted(() => {
    setupMessage(showToast, (value: boolean) => {
        isLoading.value = value;
    });
});
</script>
