<script setup>
import BreezeApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/inertia-vue3";
</script>

<template>
    <div class="min-h-screen full-layout">
        <div class="bg-yellow-500 bg-opacity-70 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 min-h-screen">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <div class="flex flex-col sm:justify-center items-center">
                    <Link href="/">
                        <BreezeApplicationLogo class="w-28 h-28 fill-current text-gray-500" :fill="'#000'" />
                    </Link>
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>
