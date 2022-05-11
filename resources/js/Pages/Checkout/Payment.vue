<template>
    <Head :title="$('Payment Method')" />
    <div class="container py-5">
        <div class="border border-gray-500 shadow-md rounded">
            <div class="bg-black text-yellow-500 px-5 py-4">
                <h4>{{ $("Payment Methods") }}</h4>
            </div>
        </div>
    </div>
</template>
<script setup>
import { Head } from "@inertiajs/inertia-vue3";

</script>
