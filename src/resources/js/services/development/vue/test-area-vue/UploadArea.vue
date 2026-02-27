<script setup lang="ts">
/** アップロード動作確認 */

import { ref } from "vue";
import axios from "axios";

import { showToast, setIsLoading } from "@/services/ui/message";

const selectedFile = ref(null);

const handleFileChange = (event) => {
    selectedFile.value = event.target.files[0];
};

const upload = async () => {
    if (!selectedFile.value) return;

    const formData = new FormData();
    formData.append("file", selectedFile.value);

    setIsLoading(true);

    const result = await axios.post("/development/upload_test", formData, {
        headers: {
            "Content-Type": "multipart/form-data",
        },
    });

    console.log('result', result);
    console.log('result.data', result.data);

    setIsLoading(false);

    showToast("アップロード完了");
};
</script>

<template>
    <div>
        アップロード動作確認

        <div class="mt-5">
            <input type="file" @change="handleFileChange" />
            <button class="app-btn-secondary mr-2" @click="upload">
                アップロード
            </button>
        </div>
    </div>
</template>
