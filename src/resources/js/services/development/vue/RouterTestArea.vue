<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useRouter } from "@/services/nav/vue-hook/useRouter";

import Parts1 from "../vue/router-test-area/Parts1.vue";
import Parts2 from "../vue/router-test-area/Parts2.vue";

console.log("router test code");

const components = { Parts1, Parts2 };

interface Props {
    name: string;
}

const props = defineProps<Props>();

const router = useRouter(components, "Parts1");

const commonCnt = ref<number>(0);

const direction = ref<string>("right");

const navLinkClass = (name: string) => {
    return [router.isCurrent(name) ? "app-link-active" : "app-link-normal"];
};

const setCurrent = (name: string) => {
    direction.value = name === "Parts1" ? "left" : "right";
    router.setCurrent(name);
};

// 初期化時
onMounted(() => {
    console.log("router test mounted");
});
</script>

<template>
    <div>
        <div class="mt-5 space-y-2">
            <div>タグからの値: {{ name }}</div>
            <div>
                <span>commonCnt: {{ commonCnt }}</span>
            </div>
        </div>

        <div class="mt-5 space-x-2">
            <button
                @click="setCurrent('Parts1')"
                :class="navLinkClass('Parts1')"
            >
                Parts1
            </button>
            <button
                @click="setCurrent('Parts2')"
                :class="navLinkClass('Parts2')"
            >
                Parts2
            </button>
        </div>

        <div class="mt-3 p-5 border-gray-500 border-2 overflow-hidden">
            <transition
                :name="
                    direction === 'right' ? 'app-slide-right' : 'app-slide-left'
                "
                mode="out-in"
            >
                <keep-alive>
                    <component
                        :is="router.currentComponent.value"
                        v-model:commonCnt="commonCnt"
                        :router="router"
                        :setCurrent="setCurrent"
                    />
                </keep-alive>
            </transition>
        </div>
    </div>
</template>
