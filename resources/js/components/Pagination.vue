<script setup>
import { Link } from "@inertiajs/inertia-vue3";
defineProps({
    links: Array
})
</script>

<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, p) in links" :key="p">
                <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                    v-html="link.label" />
                <Link v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:text-yellow-500 hover:bg-secondary-500 focus:border-transparent focus:text-yellow-500 focus:bg-secondary-500 hover:border-transparent"
                    :class="{ 'bg-secondary-700 text-yellow-500 border-transparent': link.active, 'text-secondary-500': !link.active }" :href="link.url" v-html="link.label" />
            </template>
        </div>
    </div>
</template>
