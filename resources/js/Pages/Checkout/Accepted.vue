<template>
    <Head :title="$t('Payment Method')" />
    <div class="container py-5">
        <div class="border border-gray-500 shadow-md rounded">
            <div class="bg-black text-yellow-500 px-5 py-4">
                <h4>{{ $t("Payment Methods") }}</h4>
            </div>
            <div>
                <ThanksShop />
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import ThanksShop from '@/icons/ThanksShop'

const props = defineProps({
    order: Object,
});

</script>
