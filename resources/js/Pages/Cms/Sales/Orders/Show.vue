<script setup>
import { computed, onMounted, ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";
import axios from "axios";
import nprogress from "nprogress";

const props = defineProps({
    order: Object,
});

const confirmDelete = (event) => {
    Swal.fire({
        title: "&iquest;Estás seguro de querer eliminar la orden?",
        icon: "warning",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#145388",
        cancelButtonColor: "#df4759",
        confirmButtonText: "Si, eliminar!",
    }).then((result) => {
        if (result.isConfirmed) {
            nprogress.start();
            axios
                .delete(
                    route("admin.settings.advanced.users.delete", {
                        user: event.target.dataset.id,
                    })
                )
                .then((res) => {
                    if (res.data.success) {
                        props.users.data[
                            event.target.dataset.index
                        ].deleted_at = new Date(Date.now()).toISOString();
                        Swal.fire("Eliminado!", res.data.message, "success");
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops... Ocurrio un error!",
                            text: res.data.message,
                        });
                    }
                    nprogress.done();
                })
                .catch((err) => {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...!",
                        text: "Ocurrio un error crítico si el error persiste contacta al administrador",
                    });
                    nprogress.done();
                });
        }
    });
};

const formatedNumber = (number) => {
    const formatter = Intl.NumberFormat("es-MX", {
        style: "currency",
        currency: "MXN",
        minimumFractionDigits: 2,
    });
    return formatter.format(number);
};

const formatedDate = (date, options = { year: "numeric", month: "long", day: "numeric" }) => {
    // const options = { year: "numeric", month: "long", day: "numeric" };
    return new Date(date).toLocaleDateString("es-MX", options);
};
</script>

<script context="module">
import AdminLayout from "@/Layouts/Admin.vue";

export default {
    layout: AdminLayout,
};
</script>

<template>
    <Head title="Pedidos" />

    <!-- Breadcrumb -->
    <section class="breadcrumb lg:flex items-start">
        <div>
            <h1>Pedidos</h1>
            <ul>
                <li>
                    <Link :href="route('admin.dashboard')">
                        <span class="la la-home"></span>
                    </Link>
                </li>
                <li class="divider la la-arrow-right"></li>
                <li><Link v-text="'Ventas'" /></li>
                <li class="divider la la-arrow-right"></li>
                <li>
                    <Link
                        :href="route('admin.sales.orders.index')"
                        v-text="$t('Orders')"
                    />
                </li>
                <li class="divider la la-arrow-right"></li>
                <li>{{ $t("Details") }}</li>
            </ul>
        </div>
    </section>

    <div
        class="w-full pb-5 px-0 lg:flex space-y-4 lg:space-y-0 lg:space-x-4"
    >
        <div class="lg:w-1/4">
            <div class="card p-5">
                <h3>{{ $t("Actions") }}</h3>
                <div class="mt-5 leading-normal">
                    <Link
                        class="flex items-center text-gray-700 dark:text-gray-500 hover:text-admin"
                        href="#"
                    >
                        <span
                            class="la la-cloud-upload-alt text-gray-600 text-2xl mr-2"
                        ></span>
                        {{ $t("Load Invoice") }}
                    </Link>
                    <Link
                        class="flex items-center text-gray-700 dark:text-gray-500 hover:text-admin"
                        href="#"
                        v-if="order.status.prefix !== 'CANCELED' && order.status.prefix !== 'REFUND'"
                    >
                        <span
                            class="hj hj-product-return text-gray-600 text-2xl mr-2"
                        ></span>
                        {{ $t("Refund") }}
                    </Link>
                    <Link
                        class="flex items-center text-gray-700 dark:text-gray-500 hover:text-admin"
                        href="#"
                        v-if="order.status.prefix !== 'CANCELED' && order.status.prefix !== 'SHIPPED' && order.status.prefix !== 'DELIVERED'"
                    >
                        <span
                            class="la la-shipping-fast text-gray-600 text-2xl mr-2"
                        ></span>
                        {{ $t("Add tracking number") }}
                    </Link>
                    <hr class="my-2" />
                    <Link
                        class="flex items-center text-gray-700 dark:text-gray-500 hover:text-admin"
                        href="#"
                        v-if="order.status.prefix !== 'CANCELED'"
                    >
                        <span
                            class="la la-comments text-gray-600 text-2xl mr-2"
                        ></span>
                        {{ $t("Comments") }}
                    </Link>
                    <Link
                        class="flex items-center text-gray-700 dark:text-gray-500 hover:text-admin"
                        href="#"
                    >
                        <span
                            class="la la-comment text-gray-600 text-2xl mr-2"
                        ></span>
                        {{ $t("History") }}
                    </Link>
                    <hr class="my-2" />
                    <Link
                        class="flex items-center text-gray-700 dark:text-gray-500 hover:text-admin"
                        href="#"
                    >
                        <span
                            class="la la-print text-gray-600 text-2xl mr-2"
                        ></span>
                        {{ $t("Print order") }}
                    </Link>
                    <Link
                        class="flex items-center text-gray-700 dark:text-gray-500 hover:text-admin"
                        href="#"
                    >
                        <span
                            class="la la-file-export text-gray-600 text-2xl mr-2"
                        ></span>
                        {{ $t("Export to PDF") }}
                    </Link>
                    <hr class="my-2" />
                    <Link
                        class="flex items-center text-gray-700 dark:text-gray-500 hover:text-admin"
                        :href="route('admin.sales.orders.index')"
                    >
                        <span
                            class="las la-undo text-gray-600 text-2xl mr-2"
                        ></span>
                        {{ $t("Go back") }}
                    </Link>
                </div>
            </div>
        </div>
        <div class="card lg:w-3/4">
            <div class="p-10 flex justify-between">
                <h2 class="uppercase text-4xl text-admin">{{ $t("Order") }}</h2>
            </div>
            <hr />
            <div class="px-10 py-5 flex justify-between">
                <div>
                    <strong>{{ $t("Order") }} No.:</strong> {{ order.id }}
                </div>
                <div>
                    <strong>{{ $t("Created") }}:</strong>
                    {{ formatedDate(order.created_at) }}
                </div>
            </div>
            <hr />
            <div class="px-10 py-5 flex justify-between">
                <div>
                    <strong>{{ $t("Last updated") }}:</strong>
                    {{ formatedDate(order.updated_at, { year: "numeric", month: "long", day: "numeric", hour: "numeric", minute: "numeric" }) }}
                </div>
                <div>
                    <strong class="mr-2">{{ $t("Status") }}:</strong>
                    <span
                        class="badge uppercase"
                        :class="{
                            'badge-admin': order.status.level === 1,
                            'badge-success': order.status.level === 2,
                            'badge-danger': order.status.level === 3,
                        }"
                        >{{ order.status.name }}</span
                    >
                </div>
            </div>
            <hr />
            <div class="px-10 py-5 flex justify-between">
                <div>
                    <h4 class="mb-2 uppercase">{{ $t('Shipping Address') }}</h4>
                    <p class="leading-relaxed">
                        {{ order.user.name }}<br />
                        15 Hodges Mews, CA<br />
                        20205<br />
                        United States
                    </p>
                </div>
                <div class="text-right">
                    <h4 class="mb-2 uppercase">Shipping Info</h4>
                    <p class="leading-relaxed">
                        Tomato Johnes<br />
                        15 Hodges Mews, CA<br />
                        20205<br />
                        United States
                    </p>
                </div>
            </div>
            <hr />
            <div class="overflow-x-auto p-10 flex">
                <table class="table table-list flex-1 table-admin">
                    <thead>
                        <tr>
                            <th class="text-left uppercase">Concepto</th>
                            <th class="w-fit uppercase">Precio U.</th>
                            <th class="w-px uppercase">QTY</th>
                            <th class="w-fit uppercase">
                                {{ $t("Tax Rate") }}
                            </th>
                            <th class="w-px uppercase">{{ $t("Discount") }}</th>
                            <th class="w-px uppercase">{{ $t("Amount") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index, key) in order.products" :key="key">
                            <td>
                                <h5>{{ item.sku }}</h5>
                                <p>{{ item.name }}</p>
                            </td>
                            <td class="text-center">
                                {{ formatedNumber(item.pivot.total / item.pivot.quantity) }}
                            </td>
                            <td class="text-center">{{ item.pivot.quantity }}</td>
                            <td class="text-center">
                                {{ formatedNumber(item.pivot.tax) }}
                            </td>
                            <td class="text-center">
                                {{ formatedNumber(item.pivot.discount) }}
                            </td>
                            <td class="text-center font-bold">
                                {{ formatedNumber(item.pivot.total) }}
                            </td>
                        </tr>
                        <tr class="text-right font-bold">
                            <td colspan="6">
                                <table
                                    class="ml-auto table table-borderless table-condensed"
                                >
                                    <tbody>
                                        <tr class="py-1">
                                            <td>Subtotal:</td>
                                            <td>
                                                {{
                                                    formatedNumber(
                                                        order.subtotal
                                                    )
                                                }}
                                            </td>
                                        </tr>
                                        <tr class="py-1">
                                            <td>{{ $t("Discount") }}:</td>
                                            <td>
                                                {{
                                                    formatedNumber(
                                                        order.discount
                                                    )
                                                }}
                                            </td>
                                        </tr>
                                        <tr class="py-1">
                                            <td>IVA:</td>
                                            <td>
                                                {{ formatedNumber(order.tax) }}
                                            </td>
                                        </tr>
                                        <tr class="py-1">
                                            <td>Total:</td>
                                            <td>
                                                {{
                                                    formatedNumber(order.total)
                                                }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- <hr />
            <div class="p-10 text-right">
                <h4 class="uppercase">Total</h4>
                <p class="text-4xl my-4">$45</p>
                <p>Forty Five Dollars Only</p>
            </div> -->
        </div>
    </div>
</template>
