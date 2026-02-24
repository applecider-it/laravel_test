<template>
  <div
    :class="[
      'flex space-x-2 justify-center items-center my-28 opacity-0',
      styles.fadeInAccel
    ]"
  >
    <span class="w-3 h-3 bg-gray-500 rounded-full animate-bounce"></span>
    <span
      class="w-3 h-3 bg-gray-500 rounded-full animate-bounce"
      style="animation-delay: -0.2s"
    ></span>
    <span
      class="w-3 h-3 bg-gray-500 rounded-full animate-bounce"
      style="animation-delay: -0.4s"
    ></span>
  </div>
</template>

<script setup lang="ts">
import styles from './LoadingInline.module.css'
</script>