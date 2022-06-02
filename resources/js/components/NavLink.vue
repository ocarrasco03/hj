<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['href', 'active']);

const classes = computed(() => props.active
    ? 'inline-flex items-center px-1 pt-1 border-b-2 border-black text-sm font-medium leading-5 text-black focus:outline-none focus:border-black transition duration-150 ease-in-out hover:text-black'
    : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-secondary-400 hover:text-black hover:border-black focus:outline-none focus:text-black focus:border-black transition duration-150 ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>

