<script setup>
defineProps({
    type: {
        type: String,
        default: "submit",
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center px-4 py-2 bg-secondary-800 border border-transparent font-semibold text-sm text-white uppercase tracking-widest hover:bg-secondary-700 hover:text-yellow-700 active:bg-secondary-900 focus:outline-none focus:border-secondary-900 focus:shadow-outline-secondary transition ease-in-out duration-150 justify-center"
    >
        <slot />
    </button>
</template>
