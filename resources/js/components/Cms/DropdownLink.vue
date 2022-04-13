<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Link class="flex items-center text-gray-700 dark:text-gray-500 hover:text-admin dark:hover:text-admin">
        <slot />
    </Link>
</template>
