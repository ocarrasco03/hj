<script setup>
import { ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { Pagination, Navigation } from "swiper";
import { Swiper, SwiperSlide } from "swiper/vue";
import { trans } from "laravel-vue-i18n";
import Swal from "sweetalert2";
import axios from "axios";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/autoplay";
import Wizard from '@/Components/Cms/Wizard'

const calculatePriceWoTax = () => {
    form.price_wo_tax =
        Math.round((form.price / 1.16) * Math.pow(10, 10)) / Math.pow(10, 10);
};

const form = useForm({
    sku: "",
});

</script>

<script context="module">
import AdminLayout from "@/Layouts/Admin.vue";

export default {
    layout: AdminLayout,
};
</script>

<template>
    <Head :title="`${$t('New')} ${$t('Product')}`" />

    <!-- Breadcrumb -->
    <section class="breadcrumb lg:flex items-start">
        <div>
            <h1>{{ `${$t("New")} ${$t("Product")}` }}</h1>
            <ul>
                <li>
                    <Link :href="route('admin.dashboard')">
                        <span class="la la-home"></span>
                    </Link>
                </li>
                <li class="divider la la-arrow-right"></li>
                <li><Link v-text="'Catalogos'" /></li>
                <li class="divider la la-arrow-right"></li>
                <li><Link @click="back" v-text="$t('Products')" /></li>
                <li class="divider la la-arrow-right"></li>
                <li>{{ `${$t("New")} ${$t("Product")}` }}</li>
            </ul>
        </div>
        <div class="lg:flex items-center ml-auto mt-5 lg:mt-0">
            <div class="flex mt-5 lg:mt-0">
                <!-- Add New -->
                <Link
                    @click="back"
                    class="btn btn-admin btn-outlined rounded-full uppercase ml-2"
                >
                    <i class="las la-undo"></i>
                    <span class="hidden lg:block ml-2">Regresar</span>
                </Link>
            </div>
        </div>
    </section>
    <Wizard />
</template>
