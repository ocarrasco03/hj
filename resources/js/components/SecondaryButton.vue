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
        class="inline-flex justify-center items-center px-4 py-2 bg-yellow-500 border border-transparent font-semibold text-sm text-black uppercase tracking-widest hover:bg-secondary-700 hover:border-secondary-500 hover:text-yellow-700 active:bg-secondary-900 focus:outline-none focus:border-secondary-900 focus:shadow-outline-secondary transition ease-in-out duration-150"
    >
        <slot />
    </button>
</template>
