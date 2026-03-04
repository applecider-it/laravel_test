<script setup lang="ts">
import { ref, onMounted, onActivated } from "vue";
import { RouterPartsProps } from "../../types"

const props = defineProps<RouterPartsProps>();

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

// 遷移時
onActivated(() => {
  console.log('parts1 activated')
})
</script>

<template>
    <div>
        <h3 class="text-xl font-bold">Parts1</h3>

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
                <button @click="setCurrent('Parts2')" class="app-btn-secondary">
                    To Parts2 ->
                </button>
            </div>
        </div>
    </div>
</template>
