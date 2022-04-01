<script setup>
import SearchPanel from "@/Components/SearchPanel.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import RateStars from '@/Components/RateStars.vue';
import Pagination from '@/Components/Pagination.vue';
import { Head } from "@inertiajs/inertia-vue3";

defineProps({
    products: Object,
})

</script>

<template>
    <Head title="Busqueda" />
    <div class="container py-3 flex flex-col md:flex-row">
        <aside class="w-full sm:max-w-xs shrink-0 mr-2 flex-1">
            <SearchPanel class="sticky overflow-auto top-4 rounded ml-0 z-0 pt-4" />
        </aside>
        <section id="results" class="flex-1">
            <div class="flex items-center justify-center py-3">
                <h1 class="uppercase font-bold text-2xl" v-if="$page.props.search.make && $page.props.search.model">{{ $page.props.search.make + ' ' + $page.props.search.model + ' ' + $page.props.search.year}}</h1>
            </div>
            <div
                class="bg-gray-300 uppercase flex justify-center items-center border border-gray-500 py-3"
            >
                Resultados de busqueda <span class="text-yellow-500 font-bold ml-2">{{ products.total }}</span>
            </div>

            <div
                id="item"
                class="border border-gray-500 shadow hover:shadow-md mt-3 flex flex-col md:flex-row" v-for="(item, index) in products.data" :key="index"
            >
                <div class="shrink-0">
                    <img
                        src="https://www.hjautopartes.com.mx/storage/uploads/2021-05-17/images/60-117_1621300607.jpg"
                        alt=""
                        srcset="https://www.hjautopartes.com.mx/storage/uploads/2021-05-17/images/60-117_1621300607.jpg"
                        class="h-auto w-full md:h-40 md:w-auto"
                    />
                </div>
                <div class="p-3 flex flex-col flex-1">
                    <div class="font-bold mb-2">
                        <h4>{{ item.sku }} | {{ item.name }}</h4>
                        <div class="flex items-center divide-x space-x-2">
                            <RateStars :rate="parseFloat(item.averageRating)" />
                            <span class="text-xs pl-1">Marca: {{ item.brand.name }}</span>
                            <span class="text-xs pl-1">Categorias:
                                <template v-for="(category, index) in item.categories" :key="index">
                                    {{ category.name }}{{ index < (item.categories.length - 1) ? ' | ' : '' }}
                                </template>
                            </span>
                        </div>
                    </div>
                    <div class="text-sm flex-1">
                        {{ item.description }}
                    </div>
                    <div class="flex items-center justify-between flex-1">
                        <h3 class="font-bold">$ {{ item.price }} <small>MXN</small>
                            <a class="hover:text-primary-900 text-secondary-500 cursor-pointer group" v-if="item.notes">
                                <i class="fal fa-sticky-note ml-1"></i>
                                <div class="bg-secondary-500 text-white p-3 absolute bg-opacity-90 max-w-xs invisible group-hover:visible rounded z-10 ml-32 -mt-6 text-xs" :id="`notes-${item.id}`" >
                                    <ul>
                                        <li v-for="(attribute, key, index) in item.notes" :key="index">{{ key }}: {{ attribute }}</li>
                                    </ul>
                                </div>
                            </a>

                        </h3>

                        <SecondaryButton>Ver Mas</SecondaryButton>
                    </div>
                </div>
            </div>
            <hr class="mt-3 mb-3">
            <div id="pagination" class="py-1 flex justify-end">
                <Pagination :links="products.links" v-if="products" />
            </div>
        </section>

    </div>
</template>
