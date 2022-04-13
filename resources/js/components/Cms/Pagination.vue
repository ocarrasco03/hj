<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { onMounted } from "vue";
import tippy from 'tippy.js';
import Dropdown from '@/Components/Cms/Dropdown.vue';

defineProps({
    links: Array,
    total: Number,
    from: Number,
    to: Number,
    perPage: {
        type: Number,
        default: null
    },
});
</script>

<template>
        <div class="card lg:flex w-full">
            <nav class="flex flex-wrap p-5" v-if="links.length > 3">
                <template v-for="(link, p) in links" :key="p">
                    <div v-if="link.url === null" class="btn rounded-full mr-2 mb-2 lg:mb-0 text-gray-300 hover:text-gray-300 border-gray-300 bg-transparent cursor-default"
                    v-html="link.label" />
                    <Link v-else :href="link.url" class="btn rounded-full mr-2 mb-2 lg:mb-0" :class="{'btn-admin': link.active, 'btn-outlined btn-admin-secondary': !link.active}" v-html="link.label" />
                </template>
            </nav>
            <div
                class="flex items-center ml-auto p-5 border-t lg:border-t-0 border-gray-200 dark:border-gray-900"
            >
                Mostrando {{ from }} - {{ to }} de {{ total }} registros
            </div>
            <div class="flex items-center p-5 border-t lg:border-t-0 lg:border-l border-gray-200 dark:border-gray-900" v-if="perPage !== null">
                <span class="mr-2">Mostrar</span>
                <Dropdown buttonClasses="btn btn-outlined btn-admin-secondary rounded-full">
                    <template #trigger>
                        {{ perPage }}
                            <span class="ml-3 la la-caret-down text-xl leading-none"></span>
                    </template>
                    <template #menu>
                        <a href="#">5</a>
                        <a href="#">10</a>
                        <a href="#">15</a>
                    </template>
                </Dropdown>
                <span class="ml-2">por p&aacute;gina</span>
            </div>
        </div>
</template>
