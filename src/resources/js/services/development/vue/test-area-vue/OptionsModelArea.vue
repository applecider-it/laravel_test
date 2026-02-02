<script lang="ts">
import { defineComponent } from "vue";
import MyForm from "./options-model-area/MyForm.vue";

export default defineComponent({
    name: "OptionsModelTest",

    components: {
        MyForm,
    },

    data() {
        return {
            title: "" as string,
            content: "" as string,
        };
    },
});
</script>

<template>
    <div>
        OptionsAPI Model動作確認

        <div class="mt-5">
            <p>title: {{ title }}</p>
            <p>content: {{ content }}</p>

            <MyForm
                v-model:propTitle="title"
                v-model:propContent="content"
            />
        </div>
    </div>
</template>
