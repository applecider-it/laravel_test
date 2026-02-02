<script lang="ts">
import { defineComponent } from "vue";
import { vuePropModel } from "@/services/data/html";

export default defineComponent({
    name: "MyForm",

    props: ["propTitle", "propContent"],
    emits: ["update:propTitle", "update:propContent"],

    computed: {
        title: vuePropModel<string>("propTitle"),
        content: vuePropModel<string>("propContent"),
    },

    methods: {
        addText() {
            this.content += "[add text]";
        },
    },
});
</script>

<template>
    <div class="border-2 border-gray-300 p-2">
        <div>MyForm: title</div>
        <input v-model="title" class="app-form-input" />

        <div class="mt-2">MyForm: content</div>
        <textarea v-model="content" class="app-form-input"></textarea>

        <div class="mt-5 space-x-2">
            <button class="app-btn-primary" @click="addText">addText</button>
        </div>
    </div>
</template>
