<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/inertia-vue3";
defineProps({
    image: {
        type: String,
        default: undefined,
    },
    rating: Number,
    description: String,
    name: String,
    sku: String,
    slug: String,
    price: Number,
});

const shortText = (text, length) =>
    text.slice(0, length) + (text.length > length ? "..." : "");
</script>

<template>
    <div class="flex flex-col px-4 space-y-4 items-stretch py-2">
        <div class="flex flex-grow w-full h-36 max-h-36 bg-white">
            <img :src="image" alt="" v-if="image !== undefined" />
            <ApplicationLogo
                v-else
                class="block h-36 w-auto mx-auto"
                :fill="'#000'"
            />
        </div>
        <span class="font-bold text-2xl"> $ {{ price }} </span>
        <div id="rate" class="flex flex-row space-x-1">
            <template v-for="(i, key) in 5" :key="key">
                <i v-if="i <= rating" class="fas fa-star text-yellow-500"></i>
                <i v-else class="fal fa-star text-secondary-500"></i>
            </template>
        </div>
        <h5 class="text-base font-bold">{{ name }}</h5>
        <p class="text-sm flex-1 text-justify">
            {{ shortText(description, 100) }}
        </p>
        <div class="self-end items-end w-full">
            <div class="grid grid-cols-2 gap-0 text-sm">
                <Link
                    :href="route('product.show', { slug: slug })"
                    class="col-span-2 btn btn_primary text-center py-2 text-lg transition ease-in delay-150"
                >
                    Ver mas
                </Link>
            </div>
        </div>
    </div>
</template>
