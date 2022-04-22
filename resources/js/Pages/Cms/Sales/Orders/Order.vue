<script setup>
import { computed, onMounted, ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Cms/Pagination.vue";
import Swal from "sweetalert2";
import axios from "axios";
import nprogress from "nprogress";

const props = defineProps({
    orders: Object,
});

const selectedRows = ref([]);

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

const form = useForm({
    query: "",
});

const search = () => {
    form.get(route("admin.sales.orders.index"));
};

const formatNumber = (number) => {
    const formatter = Intl.NumberFormat("es-MX", {
        style: "currency",
        currency: "MXN",
        minimumFractionDigits: 2,
    });
    return formatter.format(number);
};

const formatedDate = (date) => {
    const options = { year: "numeric", month: "long", day: "numeric" };
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
                <li>Pedidos</li>
            </ul>
        </div>
        <div class="lg:flex items-center ml-auto mt-5 lg:mt-0">
            <!-- Search -->
            <form
                class="flex items-center lg:ml-2 mt-5 lg:mt-0"
                @submit.prevent="search"
            >
                <label
                    class="form-control-addon-within rounded-full border-admin-secondary"
                >
                    <input
                        type="text"
                        class="form-control border-none"
                        :placeholder="$t('Search')"
                        v-model="form.query"
                    />
                    <button
                        type="button"
                        class="btn btn-link text-secondary dark:text-gray-700 hover:text-admin dark:hover:text-admin text-xl leading-none la la-search mr-4"
                    ></button>
                </label>
            </form>
        </div>
    </section>

    <div
        class="container pb-5 lg:flex px-0 space-y-4 lg:space-y-0 lg:space-x-4"
    >
        <div class="card w-full py-4">
            <table
                class="table table-auto w-full table-hoverable border-collapse"
                v-cloak
            >
                <thead>
                    <tr class="text-admin">
                        <th class="w-px hidden md:table-cell">
                            <label class="admin-checkbox">
                                <input
                                    type="checkbox"
                                    :checked="selectedRows.length > 0"
                                    :partial="
                                        selectedRows.length < orders.per_page &&
                                        selectedRows.length > 0
                                            ? true
                                            : null
                                    "
                                    disabled
                                />
                                <span></span>
                            </label>
                        </th>
                        <th class="text-left">{{ $t("Order") }}</th>
                        <th class="text-left hidden md:table-cell">
                            {{ $t("Customer") }}
                        </th>
                        <th class="w-px text-center hidden md:table-cell">
                            {{ $t("Total") }}
                        </th>
                        <th class="hidden md:table-cell">{{ $t("Status") }}</th>
                        <th class="hidden md:table-cell">
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
                    <tr v-for="(order, index, key) in orders.data" :key="key">
                        <td class="hidden md:table-cell">
                            <label class="admin-checkbox">
                                <input
                                    type="checkbox"
                                    data-toggle="rowSelection"
                                    v-model="selectedRows"
                                    :value="order.id"
                                    :checked="order.id"
                                />
                                <span></span>
                            </label>
                        </td>
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
                            {{ order.user.name }}
                        </td>
                        <td class="hidden md:table-cell">
                            {{ formatNumber(order.total) }}
                        </td>
                        <td class="text-center hidden md:table-cell">
                            <span
                                v-if="!order.deleted_at"
                                class="badge badge-outlined uppercase"
                                :class="{
                                    'badge-admin': order.status.level === 1,
                                    'badge-success': order.status.level === 2,
                                    'badge-danger': order.status.level === 3,
                                }"
                                >{{ order.status.name }}</span
                            >
                            <span
                                v-else
                                class="badge badge-outlined badge-danger uppercase"
                                >Eliminado</span
                            >
                        </td>
                        <td class="text-center hidden md:table-cell">
                            {{ formatedDate(order.created_at) }}
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
                                :disabled="!$can('pedidos.update')"
                            >
                                <span class="la la-eye"></span>
                            </Link>
                            <button
                                v-if="!order.deleted_at"
                                class="btn btn-outlined btn-danger ml-2 btn-icon rounded-full"
                                @click="confirmDelete"
                                :disabled="!$can('pedidos.delete')"
                            >
                                <span
                                    class="la la-trash-alt"
                                    :data-id="order.id"
                                    :data-index="index"
                                ></span>
                            </button>
                            <Link
                                v-if="order.deleted_at"
                                :href="
                                    route(
                                        'admin.settings.advanced.users.restore',
                                        { order: order.id }
                                    )
                                "
                                class="btn btn-outlined btn-admin ml-2 btn-icon rounded-full"
                                preserve-scroll
                                method="put"
                                as="button"
                            >
                                <span class="la la-redo-alt"></span>
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div
        class="container pb-5 lg:flex px-0 space-y-4 lg:space-y-0 lg:space-x-4"
    >
        <Pagination
            :links="orders.links"
            :total="orders.total"
            :from="orders.from"
            :to="orders.to"
            v-if="orders.data.length > 0"
        />
    </div>
</template>
