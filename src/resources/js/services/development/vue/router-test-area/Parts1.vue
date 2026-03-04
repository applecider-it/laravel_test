<script setup lang="ts">
import { ref, onMounted } from "vue";
import { type useRouter } from "@/services/nav/vue-hook/useRouter";

interface Props {
    router: ReturnType<typeof useRouter>;
}

const props = defineProps<Props>();

const commonCnt = defineModel<number>("commonCnt");

const cnt = ref<number>(0);

const onClickCommon = () => {
    console.log("onClickCommon");

    commonCnt.value++;
};

// 初期化時
onMounted(() => {
    console.log("parts1 mounted");
});
</script>

<template>
    <h3 class="text-xl font-bold">Parts1</h3>

    <div class="space-y-2 mt-5">
        <div>
            <button @click="commonCnt++" class="app-btn-primary">
                Add Common
            </button>
        </div>
        <div>
            <button @click="onClickCommon" class="app-btn-primary">
                Add Common2
            </button>
        </div>
        <div>
            <span>cnt: {{ cnt }}</span>
        </div>
        <div>
            <button @click="cnt++" class="app-btn-primary">Add</button>
        </div>
        <div>
            <button
                @click="router.setCurrent('Parts2')"
                class="app-btn-secondary"
            >
                To Parts2
            </button>
        </div>
    </div>
</template>
