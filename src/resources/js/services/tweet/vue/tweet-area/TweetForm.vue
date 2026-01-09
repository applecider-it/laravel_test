<script setup lang="ts">
import { Errors } from "@/services/form/types";

const content = defineModel<string>("content", {
    required: true,
});

defineProps<{
    errors: Errors;
}>();

defineEmits<{
    (e: "submit", event: Event): void;
}>();
</script>

<template>
    <form @submit="$emit('submit', $event)" class="mb-4">
        <textarea
            v-model="content"
            rows="3"
            class="w-full border rounded p-2"
            placeholder="What's happening?"
        />

        <p v-if="errors.content" class="app-error-text">
            {{ errors.content[0] }}
        </p>

        <button type="submit" class="mt-2 app-btn-primary">Tweet</button>
    </form>
</template>
