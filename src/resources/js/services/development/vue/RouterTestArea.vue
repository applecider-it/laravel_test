<script setup lang="ts">
import { ref, computed, onMounted } from "vue";
import { useRouter } from "@/services/nav/vue-hook/useRouter";

import Parts1 from "../vue/router-test-area/Parts1.vue";
import Parts2 from "../vue/router-test-area/Parts2.vue";

const components = { Parts1, Parts2 };

interface Props {
    name: string;
}

const props = defineProps<Props>();

const router = useRouter(components, "Parts1");

const currentComponent = computed(() => router.currentComponent());

const commonCnt = ref<number>(0);

const navLinkClass = (name: string) => {
    return [router.isCurrent(name) ? "app-link-active" : "app-link-normal"];
};

// 初期化時
onMounted(() => {
    console.log("router test mounted");
});
</script>

<template>
    <div class="mt-5 space-y-2">
        <div>タグからの値: {{ name }}</div>
        <div>
            <span>commonCnt: {{ commonCnt }}</span>
        </div>
    </div>

    <div class="mt-5 space-x-2">
        <button
            @click="router.setCurrent('Parts1')"
            :class="navLinkClass('Parts1')"
        >
            Parts1
        </button>
        <button
            @click="router.setCurrent('Parts2')"
            :class="navLinkClass('Parts2')"
        >
            Parts2
        </button>
    </div>

    <div class="mt-3 p-5 border-gray-500 border-2">
        <keep-alive>
            <component :is="currentComponent" v-model:commonCnt="commonCnt" :router="router" />
        </keep-alive>
    </div>
</template>
