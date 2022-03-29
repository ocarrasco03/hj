<script setup>
defineProps({
    rate: Number,
})
</script>

<template>
    <div id="rate" class="flex flex-row space-x-1">
        <template v-for="(i, key) in 5" :key="key">
            <i v-if="i <= rate"
                class="fas fa-star text-yellow-500"
            ></i>
            <i v-else class="fal fa-star text-secondary-500"></i>
        </template>
    </div>
</template>
