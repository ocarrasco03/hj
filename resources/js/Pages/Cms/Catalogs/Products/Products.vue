<script setup>
import { computed, onMounted, ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Cms/Pagination.vue";
import Swal from "sweetalert2";
import axios from "axios";
import nprogress from "nprogress";

const props = defineProps({
    products: Object,
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
    form.get(route("admin.catalogs.products.index"));
};

const formatNumber = (
    number,
    options = { style: "currency", currency: "MXN", minimumFractionDigits: 2 }
) => {
    const formatter = Intl.NumberFormat("es-MX", options);
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
    <Head title="Productos" />

    <!-- Breadcrumb -->
    <section class="breadcrumb lg:flex items-start">
        <div>
            <h1>Productos</h1>
            <ul>
                <li>
                    <Link :href="route('admin.dashboard')">
                        <span class="la la-home"></span>
                    </Link>
                </li>
                <li class="divider la la-arrow-right"></li>
                <li><Link v-text="'Catalogos'" /></li>
                <li class="divider la la-arrow-right"></li>
                <li>Productos</li>
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
            <div class="flex mt-5 lg:mt-0">
                <!-- Add New -->
                <Link
                    :href="route('admin.catalogs.products.create')"
                    class="btn btn-admin uppercase ml-2"
                    >Agregar</Link
                >
                <button class="btn btn-outlined btn-admin ml-2 btn-icon btn-icon-large">
                    <span class="las la-cloud-upload-alt"></span>
                </button>
                <button class="btn btn-outlined btn-admin ml-2 btn-icon btn-icon-large">
                    <span class="las la-cloud-download-alt"></span>
                </button>
            </div>
        </div>
    </section>

    <div
        class="w-full pb-5 lg:flex px-0 space-y-4 lg:space-y-0 lg:space-x-4"
    >
        <div class="card w-full py-4">
            <table
                class="table table-auto table-admin w-full table-hoverable border-collapse"
                v-cloak
            >
                <thead>
                    <tr>
                        <th class="w-px hidden md:table-cell">
                            <label class="admin-checkbox">
                                <input
                                    type="checkbox"
                                    :checked="selectedRows.length > 0"
                                    :partial="
                                        selectedRows.length <
                                            products.per_page &&
                                        selectedRows.length > 0
                                            ? true
                                            : null
                                    "
                                    disabled
                                />
                                <span></span>
                            </label>
                        </th>
                        <th class="text-left w-px">{{ $t("SKU") }}</th>
                        <th class="text-left hidden md:table-cell">
                            {{ $t("Name") }}
                        </th>
                        <th class="text-left hidden md:table-cell">
                            {{ $t("Brand") }}
                        </th>
                        <th class="text-center hidden md:table-cell w-auto">
                            {{ $t("Category") }}
                        </th>
                        <th class="w-px text-left hidden md:table-cell">
                            {{ $t("Price") }}
                        </th>
                        <th class="w-px hidden md:table-cell">
                            {{ $t("Status") }}
                        </th>
                        <th class="hidden md:table-cell">
                            {{ $t("Last updated") }}
                        </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="products.data.length === 0">
                        <td class="text-center" colspan="9">
                            No se encontraron registros
                        </td>
                    </tr>
                    <tr
                        v-for="(product, index, key) in products.data"
                        :key="key"
                    >
                        <td class="hidden md:table-cell">
                            <label class="admin-checkbox">
                                <input
                                    type="checkbox"
                                    data-toggle="rowSelection"
                                    v-model="selectedRows"
                                    :value="product.id"
                                    :checked="product.id"
                                />
                                <span></span>
                            </label>
                        </td>
                        <td class="uppercase font-bold">
                            <Link
                                :href="
                                    route('admin.catalogs.products.show', {
                                        product: product.id,
                                    })
                                "
                                class="text-admin"
                                v-text="product.sku"
                            />
                        </td>
                        <td class="hidden md:table-cell">
                            {{ product.name }}
                        </td>
                        <td class="hidden md:table-cell">
                            {{ product.brand.name }}
                        </td>
                        <td class="hidden md:table-cell">
                            <template
                                v-for="(
                                    category, index, key
                                ) in product.categories"
                                :key="key"
                            >
                                <span
                                    class="badge badge-outlined badge-admin ml-2 mb-1"
                                    >{{ category.name }}</span
                                >
                            </template>
                        </td>
                        <td class="hidden md:table-cell">
                            {{ formatNumber(product.price) }}
                        </td>
                        <td class="text-center hidden md:table-cell">
                            <span
                                v-if="!product.deleted_at"
                                class="badge badge-outlined uppercase"
                                :class="{
                                    'badge-success':
                                        product.status.prefix === 'ACTIVE',
                                    'badge-warning':
                                        product.status.prefix === 'PAUSED',
                                    'badge-danger':
                                        product.status.prefix === 'SUSPENDED',
                                }"
                                >{{ product.status.name }}</span
                            >
                            <span
                                v-else
                                class="badge badge-outlined badge-danger uppercase"
                                >Eliminado</span
                            >
                        </td>
                        <td class="text-center hidden md:table-cell">
                            {{ formatedDate(product.created_at) }}
                        </td>
                        <td class="items-center text-center">
                            <Link
                                :href="
                                    route('admin.catalogs.products.show', {
                                        product: product.id,
                                    })
                                "
                                v-if="!product.deleted_at"
                                class="btn btn-outlined btn-admin btn-icon"
                                as="button"
                                method="get"
                                :disabled="!$can('pedidos.update')"
                            >
                                <span class="la la-eye"></span>
                            </Link>
                            <button
                                v-if="!product.deleted_at"
                                class="btn btn-outlined btn-danger ml-2 btn-icon rounded-full"
                                @click="confirmDelete"
                                :disabled="!$can('pedidos.delete')"
                            >
                                <span
                                    class="la la-trash-alt"
                                    :data-id="product.id"
                                    :data-index="index"
                                ></span>
                            </button>
                            <Link
                                v-if="product.deleted_at"
                                :href="
                                    route(
                                        'admin.settings.advanced.users.restore',
                                        { product: product.id }
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
        class="w-full pb-5 lg:flex px-0 space-y-4 lg:space-y-0 lg:space-x-4"
    >
        <Pagination
            :links="products.links"
            :total="products.total"
            :from="products.from"
            :to="products.to"
            v-if="products.data.length > 0"
        />
    </div>
</template>
