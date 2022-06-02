<script setup>
import { ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Dropdown from "@/Components/Dropdown";
import DropdownLink from "@/Components/DropdownLink";
import moment from "moment";
import LineChart from "@/Components/Cms/LineChart";
import Pagination from "@/Components/Cms/Pagination";

moment.locale("es-mx");

const props = defineProps({
    customer: Object,
    orders: Object,
});
</script>

<script context="module">
import AdminLayout from "@/Layouts/Admin.vue";

export default {
    layout: AdminLayout,
};
</script>

<template>
    <Head :title="$t('Customers')" />

    <!-- Breadcrumb -->
    <section class="breadcrumb lg:flex items-start">
        <div>
            <h1>{{ $t("Customer") }}</h1>
            <ul>
                <li>
                    <Link :href="route('admin.dashboard')">
                        <span class="la la-home"></span>
                    </Link>
                </li>
                <li class="divider la la-arrow-right"></li>
                <li>
                    <Link
                        :href="route('admin.customers.customer.index')"
                        v-text="$t('Customers')"
                    />
                </li>
                <li class="divider la la-arrow-right"></li>
                <li>
                    {{ `${customer.data.firstname} ${customer.data.lastname}` }}
                </li>
            </ul>
        </div>
    </section>

    <div class="w-full pb-5 lg:flex px-0 space-y-4 lg:space-y-0 lg:space-x-4">
        <aside class="lg:w-1/4">
            <div class="card p-3">
                <div class="flex items-end flex-wrap">
                    <div class="flex flex-wrap items-center">
                        <div class="avatar w-16 h-16 mr-2">
                            <img src="https://picsum.photos/200?blur=5" />
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <h5 class="text-sm">{{ customer.data.firstname }}</h5>
                        <h5 class="text-sm">{{ customer.data.lastname }}</h5>
                        <small>{{ customer.data.email }}</small>
                        <small>{{ customer.data.phone }}</small>
                    </div>
                </div>
                <hr class="my-4" />
                <div class="flex flex-col mt-4">
                    <div class="flex mt-2 justify-between">
                        <span class="font-bold mr-2"
                            >{{ $t("Registered") }}:</span
                        >
                        {{ moment(customer.data.created_at).format("LL") }}
                    </div>
                    <div class="flex mt-2 justify-between items-center">
                        <span class="font-bold mr-2"
                            >{{ $t("Verified") }}:</span
                        >
                        <span
                            v-if="customer.data.email_verified_at"
                            class="text-success-700 text-2xl las la-user-check"
                        >
                        </span>
                        <span
                            v-else
                            class="text-danger-500 text-2xl las la-times-circle"
                        >
                        </span>
                    </div>
                    <div class="flex mt-2 justify-between items-center">
                        <span class="font-bold mr-2"
                            >{{ $t("Suscribed") }}:</span
                        >
                        <span
                            v-if="customer.data.suscribed"
                            class="text-success-700 text-2xl las la-user-check"
                        >
                        </span>
                        <span
                            v-else
                            class="text-danger-500 text-2xl las la-times-circle"
                        >
                        </span>
                    </div>
                    <div class="flex mt-2 justify-between">
                        <span class="font-bold mr-2"
                            >{{ $t("Average Purchases") }}:</span
                        >
                        {{ $formatPrice(customer.data.avg_purchases) }}
                    </div>
                    <div class="flex mt-2 justify-between">
                        <span class="font-bold mr-2"
                            >{{ $t("Total Purchases") }}:</span
                        >
                        {{ $formatPrice(customer.data.sum_purchases) }}
                    </div>
                    <div class="flex mt-2 justify-between">
                        <span class="font-bold mr-2"
                            >{{ $t("Total Orders") }}:</span
                        >
                        {{ customer.data.total_purchases }}
                    </div>
                    <div class="flex mt-2 justify-between text-danger-500">
                        <span class="font-bold mr-2 text-black"
                            >{{ $t("Cancelations") }}:</span
                        >
                        {{ $formatPrice(customer.data.sum_canceled) }}
                    </div>
                    <div class="flex mt-2 justify-between">
                        <span class="font-bold mr-2"
                            >{{ $t("Total Canceled Orders") }}:</span
                        >
                        {{ customer.data.total_canceled }}
                    </div>
                </div>
            </div>
            <div class="card mt-4 p-3">
                <h5>{{ $t("Shipping Address") }}</h5>
                <div class="flex items-start flex-wrap flex-col" v-if="customer.data.addresses.shipping">
                    <span
                        >{{ customer.data.addresses.shipping.street }}
                        {{ customer.data.addresses.shipping.exterior_no }}
                        {{
                            customer.data.addresses.shipping.interior_no
                                ? `int ${customer.data.addresses.shipping.interior_no}`
                                : ""
                        }}</span
                    >
                    <span
                        >{{ customer.data.addresses.shipping.neighborhood }},
                        CP.
                        {{ customer.data.addresses.shipping.zip_code }}</span
                    >
                    <span>
                        {{ customer.data.addresses.shipping.city }},
                        {{ customer.data.addresses.shipping.state }},
                        {{ customer.data.addresses.shipping.country }}
                    </span>
                    <p class="text-xs">
                        {{ customer.data.addresses.shipping.indications }}
                    </p>
                </div>
                <hr class="my-4" />
                <h5>{{ $t("Billing Address") }}</h5>
                <div class="flex items-start flex-wrap flex-col" v-if="customer.data.addresses.billing">
                    <span
                        >{{ customer.data.addresses.billing.street }}
                        {{ customer.data.addresses.billing.exterior_no }}
                        {{
                            customer.data.addresses.billing.interior_no
                                ? `int ${customer.data.addresses.billing.interior_no}`
                                : ""
                        }}</span
                    >
                    <span
                        >{{ customer.data.addresses.billing.neighborhood }}, CP.
                        {{ customer.data.addresses.billing.zip_code }}</span
                    >
                    <span>
                        {{ customer.data.addresses.billing.city }},
                        {{ customer.data.addresses.billing.state }},
                        {{ customer.data.addresses.billing.country }}
                    </span>
                    <p class="text-xs">
                        {{ customer.data.addresses.billing.indications }}
                    </p>
                </div>
            </div>
            <div class="card mt-4 p-3">
                <h5>
                    {{
                        $t("Total Purchases of :year", {
                            year: moment().format("Y"),
                        })
                    }}
                </h5>
                <LineChart
                    :labels="customer.data.chart.labels"
                    :data="customer.data.chart.data"
                />
            </div>
            <div class="card mt-4 p-3">
                <h5>
                    {{
                        $t("Total Cancelations of :year", {
                            year: moment().format("Y"),
                        })
                    }}
                </h5>
                <LineChart
                    id="CanceledChart"
                    :labels="customer.data.canceledChart.labels"
                    :data="customer.data.canceledChart.data"
                />
            </div>
        </aside>
        <div class="lg:w-3/4">
            <div class="card p-3 mb-4">
                <table
                    class="table table-auto w-full table-hoverable border-collapse"
                    v-cloak
                >
                    <thead>
                        <tr class="text-admin">
                            <th class="text-left">{{ $t("Order") }}</th>
                            <th class="w-px text-center hidden md:table-cell">
                                {{ $t("Total") }}
                            </th>
                            <th class="hidden md:table-cell">
                                {{ $t("Status") }}
                            </th>
                            <th class="hidden lg:table-cell">
                                {{ $t("Created") }}
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="orders.data.length === 0">
                            <td class="text-center" colspan="7">
                                No se encontraron registros
                            </td>
                        </tr>
                        <tr
                            v-for="(order, index, key) in orders.data"
                            :key="key"
                        >
                            <td class="uppercase font-bold">
                                <Link
                                    :href="
                                        route('admin.sales.orders.show', {
                                            order: order.id,
                                        })
                                    "
                                    class="text-admin"
                                    v-text="order.id"
                                />
                            </td>
                            <td class="hidden md:table-cell">
                                {{ $formatPrice(order.total) }}
                            </td>
                            <td class="text-center hidden md:table-cell">
                                <span
                                    v-if="!order.deleted_at"
                                    class="badge badge-outlined uppercase"
                                    :class="{
                                        'badge-admin': order.status.level === 1,
                                        'badge-success':
                                            order.status.level === 2,
                                        'badge-danger':
                                            order.status.level === 3,
                                    }"
                                    >{{ order.status.name }}</span
                                >
                                <span
                                    v-else
                                    class="badge badge-outlined badge-danger uppercase"
                                    >Eliminado</span
                                >
                            </td>
                            <td class="text-center hidden lg:table-cell">
                                {{ $formatedDate(order.created_at) }}
                            </td>
                            <td class="items-center text-center">
                                <Link
                                    :href="
                                        route('admin.sales.orders.show', {
                                            order: order.id,
                                        })
                                    "
                                    v-if="!order.deleted_at"
                                    class="btn btn-outlined btn-admin btn-icon"
                                    as="button"
                                    method="get"
                                    :disabled="!$can('order.update')"
                                >
                                    <span class="la la-eye"></span>
                                </Link>
                                <button
                                    v-if="
                                        !order.deleted_at &&
                                        $can('order.delete')
                                    "
                                    class="btn btn-outlined btn-danger ml-2 btn-icon rounded-full"
                                    @click="confirmDelete"
                                >
                                    <span
                                        class="la la-trash-alt"
                                        :data-id="order.id"
                                        :data-index="index"
                                    ></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                class="w-full pb-5 lg:flex px-0 space-y-4 lg:space-y-0 lg:space-x-4"
            >
                <Pagination
                    :links="orders.meta.links"
                    :total="orders.meta.total"
                    :from="orders.meta.from"
                    :to="orders.meta.to"
                    v-if="orders.data.length > 0"
                />
            </div>
        </div>
    </div>
</template>
