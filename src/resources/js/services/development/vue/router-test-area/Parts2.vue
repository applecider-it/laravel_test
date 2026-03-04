<script setup lang="ts">
import { ref, onMounted, onActivated } from "vue";
import { showToast } from "@/services/ui/message";
import { RouterPartsProps } from "../../types"

const props = defineProps<RouterPartsProps>();

const commonCnt = defineModel<number>("commonCnt");

const cnt = ref<number>(0);

const execToast = () => {
    showToast("トーストテスト");
};

// 初期化時
onMounted(() => {
    console.log("parts2 mounted");
});

// 遷移時
onActivated(() => {
  console.log('parts2 activated')
})
</script>

<template>
    <div>
        <h3 class="text-xl font-bold">Parts2</h3>

        <div class="space-y-2 mt-5">
            <div>
                <span>commonCnt: {{ commonCnt }}</span>
            </div>
            <div>
                <button @click="commonCnt++" class="app-btn-primary">
                    Add Common
                </button>
            </div>
            <div>
                <span>cnt: {{ cnt }}</span>
            </div>
            <div>
                <button @click="cnt++" class="app-btn-primary">Add</button>
            </div>
            <div>
                <button @click="execToast" class="app-btn-primary">
                    Toast
                </button>
            </div>
            <div>
                <button @click="setCurrent('Parts1')" class="app-btn-secondary">
                    <- To Parts1
                </button>
            </div>
        </div>
    </div>
</template>
