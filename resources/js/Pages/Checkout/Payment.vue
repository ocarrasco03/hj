<template>
    <Head :title="$t('Payment Method')" />
    <div class="container py-5">
        <div class="border border-gray-500 shadow-md rounded">
            <div class="bg-black text-yellow-500 px-5 py-4">
                <h4>{{ $t("Payment Methods") }}</h4>
            </div>
            <div class="pb-10 pt-6 px-10 lg:flex">
                <div class="lg:w-1/2 lg:pr-4">
                    <div>
                        <label for="name" class="label"
                            >{{ $t("Full Name") }}
                            <small class="text-sm text-red-500">*</small></label
                        >
                    </div>
                    <div class="mt-5">
                        <label for="company" class="label">{{
                            $t("Company")
                        }}</label>
                    </div>
                    <div class="mt-5">
                        <label for="address_line_1" class="label"
                            >{{ $t("Street & House No.") }}
                            <small class="text-sm text-red-500">*</small></label
                        >
                    </div>
                    <div class="mt-5">
                        <label for="country" class="label"
                            >{{ $t("Country") }}
                            <small class="text-sm text-red-500">*</small></label
                        >
                    </div>
                    <div class="mt-5">
                        <label for="state" class="label"
                            >{{ $t("State") }}
                            <small class="text-sm text-red-500">*</small></label
                        >
                    </div>
                    <div class="mt-5">
                        <label for="city" class="label"
                            >{{ $t("City") }}
                            <small class="text-sm text-red-500">*</small></label
                        >
                    </div>
                    <div class="mt-5">
                        <label for="zip_code" class="label"
                            >{{ $t("Zip Code") }}
                            <small class="text-sm text-red-500">*</small></label
                        >
                    </div>
                    <div class="mt-5">
                        <label for="neighborhood" class="label"
                            >{{ $t("Neighborhood") }}
                            <small class="text-sm text-red-500">*</small></label
                        >
                    </div>
                    <div class="mt-5">
                        <label for="phone" class="label"
                            >{{ $t("Phone") }}
                            <small class="text-sm text-red-500">*</small></label
                        >
                    </div>
                    <div class="mt-5">
                        <label for="email" class="label"
                            >{{ $t("E-Mail Address") }}
                            <small class="text-sm text-red-500">*</small></label
                        >
                    </div>
                    <hr class="divider mt-5" />
                    <h4 class="font-medium text-lg mt-5">
                        {{ $t("Aditional Information") }}
                    </h4>
                    <div>
                        <label for="notes" class="label">{{
                            $t("Order Notes")
                        }}</label>
                    </div>
                </div>
                <div class="lg:w-1/2 w_ticket lg:h-full">
                    <div class="heading">
                        <h4>{{ $t("Your Order") }}</h4>
                    </div>
                    <div class="detail">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th
                                        class="text-left uppercase text-lg text-secondary-500"
                                    >
                                        {{ $t("Product") }}
                                    </th>
                                    <th
                                        class="w-px uppercase text-lg text-secondary-500"
                                    >
                                        {{ $t("Total") }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(item, key) in order.data.items"
                                    :key="key"
                                >
                                    <td>
                                        <div>
                                            <span class="font-bold"
                                                >{{ item.quantity }}x</span
                                            >
                                            <p>{{ item.name }}</p>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        ${{ item.discount }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="uppercase font-bold">
                                        {{ $t("Subtotal") }}
                                    </td>
                                    <td class="text-red-500 text-right">
                                        {{ $formatPrice(order.data.subtotal) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="uppercase font-bold">
                                        {{ $t("Tax") }}
                                    </td>
                                    <td class="text-red-500 text-right">
                                        {{ $formatPrice(order.data.tax) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="uppercase font-bold">
                                        {{ $t("Shipping") }}
                                    </td>
                                    <td class="text-red-500 text-right">
                                        {{ $formatPrice(order.data.shipping) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="uppercase font-bold text-lg">
                                        {{ $t("Total") }}
                                    </td>
                                    <td class="text-red-500 text-right">
                                        {{ $formatPrice(order.data.total) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5">
                        <p class="text-justify">
                            Tus datos personales se usarán para procesar tu
                            pedido, ofrecerte soporte y atención sobre tu
                            actividad en nuestro sitio y para los propósitos
                            descritos en nuestro
                            <Link
                                class="font-bold text-secondary-500"
                                :href="route('policy')"
                                v-text="'aviso de privacidad'"
                            />.
                        </p>
                    </div>
                    <div class="mt-5 flex flex-col">
                        <Link class="flex-1 mb-3 btn btn-primary bbva-button-row rounded py-4 sm:py-5 md:py-6 lg:py-7" :href="route('checkout.pay.bbva', {order: order.data.id})">
                            <Bbva class="h-4 md:h-5 lg:h-6 text-white" />
                        </Link>
                        <div
                            id="paypal-button-container"
                            class="paypal-button-container ring-0 ring-transparent focus:ring-0 focus:ring-transparent"
                        ></div>
                        <Link
                            class="btn btn-danger mt-6 px-20 capitalize w-full md:w-auto"
                            v-text="trans('cancel')"
                        />
                    </div>
                </div>
            </div>
            <div
                class="pb-4 pl-4 pt-4 pr-4 lg:pr-0 flex flex-col-reverse md:flex-row"
            >
                <div class="w-full md:w-1/4 text-center">
                    <h5 class="font-bold text-lg">
                        Aclaraciones o comentarios
                    </h5>
                    <span class="text-blue-500 font-bold text-xl mt-1">
                        <i class="fas fa-phone-alt mr-2"></i> 631 101 1300
                    </span>
                    <br />
                    <span class="text-blue-500 text-sm mt-1">
                        De Lunes a Viernes de 09:00 am a 06:00pm y
                        S&aacute;bados de 09:00 am a 01:00 pm
                    </span>
                </div>
                <div class="w-full md:w-3/4">
                    <div class="bg-green-500 rounded-bl-2xl w-full p-4 text-center font-bold">
                        <span
                            >Usted ha seleccionado como metodo de pago tarjeta
                            de debito VISA</span
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { trans } from "laravel-vue-i18n";
import DebitCard from "@/Icons/DebitCard";
import CreditCard from "@/Icons/CreditCard";
import Cash from "@/Icons/Cash";
import Bbva from "@/Icons/Bbva";
import PayPal from "@/Icons/PayPal";
import SecondaryButton from "@/Components/SecondaryButton";

const props = defineProps({
    order: Object,
})

const mountPayPalButtons = () => {
    paypal
        .Buttons({
            style: {
                shape: "rect",
                color: "gold",
                layout: "vertical",
                label: "paypal",
                size: "medium",
            },
        })
        .render("#paypal-button-container");
};

onMounted(() => {
    mountPayPalButtons();
});
</script>
