<script setup>
import { computed } from 'vue';

const props = defineProps(['primary']);

const classes = computed(() =>
    props.primary ? "bg-black" : "bg-yellow-500"
);
const classesText = computed(() =>
    props.primary ? "text-yellow-500" : "text-black"
);
</script>

<template>
    <div :class="classes">
        <div :class="classesText" class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 font-bold">
            <slot></slot>
        </div>
    </div>
</template>
