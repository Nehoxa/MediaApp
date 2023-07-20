<template>
  <div class="w-full h-full pb-6">
    <div class="text-white text-3xl flex justify-center mt-32">
      {{ statusMessage }}
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  statusMessage: String,
});
</script>