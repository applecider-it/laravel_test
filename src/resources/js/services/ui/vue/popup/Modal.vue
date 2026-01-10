<script setup lang="ts">
defineProps<{
    isOpen: boolean;
    onClose: () => void;
}>();
</script>

<template>
    <div
        class="fixed inset-0 bg-black/50 flex justify-center items-center z-50 transition-opacity duration-500 ease-in-out"
        :class="
            isOpen
                ? 'opacity-100 pointer-events-auto'
                : 'opacity-0 pointer-events-none'
        "
        @click="onClose"
    >
        <div class="bg-white rounded-xl p-6 shadow-xl" @click.stop>
            <slot />
        </div>
    </div>
</template>
