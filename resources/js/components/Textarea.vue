<script setup>
import { onMounted, ref } from 'vue';

defineProps(['modelValue']);

defineEmits(['update:modelValue']);

const textarea = ref(null);

onMounted(() => {
    if (textarea.value.hasAttribute('autofocus')) {
        textarea.value.focus();
    }
});
</script>

<template>
    <textarea class="resize-none border-2 border-gray-500 focus:border-gray-900 focus:ring-0 rounded shadow-sm" ref="textarea" @textarea="$emit('update:modelValue', $event.target.value)"></textarea>
</template>
