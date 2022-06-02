<script setup>
import { computed, onMounted, ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Cms/Pagination";
import Dropdown from "@/Components/Dropdown";
import DropdownLink from "@/Components/DropdownLink";
import Swal from "sweetalert2";
import axios from "axios";
import nprogress from "nprogress";

const props = defineProps({
    users: Object,
});

const selectedRows = ref([]);

const confirmDelete = (id, index, event) => {
    Swal.fire({
        title: "&iquest;Estás seguro de querer eliminar el usuario?",
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
                    route("admin.customers.customer.delete", {
                        customer: id,
                    })
                )
                .then((res) => {
                    if (res.data.success) {
                        props.users.data[index].deleted_at = new Date(
                            Date.now()
                        ).toISOString();
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
    form.get(route("admin.customers.customer.index"), {
        preserveScroll: true,
        preserveState: true,
    });
};
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
            <h1>{{ $t("Customers") }}</h1>
            <ul>
                <li>
                    <Link :href="route('admin.dashboard')">
                        <span class="la la-home"></span>
                    </Link>
                </li>
                <li class="divider la la-arrow-right"></li>
                <li>{{ $t("Customers") }}</li>
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
                        placeholder="Search"
                        v-model="form.query"
                    />
                    <button
                        type="button"
                        class="btn btn-link text-secondary dark:text-gray-700 hover:text-primary dark:hover:text-primary text-xl leading-none la la-search mr-4"
                    ></button>
                </label>
            </form>
            <div class="flex mt-5 lg:mt-0">
                <!-- Add New -->
                <!-- <Link
                    :href="route('admin.settings.advanced.users.create')"
                    class="btn btn-admin uppercase ml-2"
                    >Agregar</Link
                > -->
            </div>
        </div>
    </section>

    <div class="w-full pb-5 lg:flex px-0 space-y-4 lg:space-y-0 lg:space-x-4">
        <div class="card w-full">
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
                                        selectedRows.length < users.meta.per_page &&
                                        selectedRows.length > 0
                                            ? true
                                            : null
                                    "
                                    disabled
                                />
                                <span></span>
                            </label>
                        </th>
                        <th class="text-left">Cliente</th>
                        <th class="text-left hidden md:table-cell">Email</th>
                        <th class="text-left hidden md:table-cell">{{ $t('Phone') }}</th>
                        <th class="text-left hidden md:table-cell">{{ $t('Average Purchases') }}</th>
                        <th class="w-px hidden lg:table-cell">{{ $t('Suscribed') }}</th>
                        <th class="w-px hidden lg:table-cell">Verificado</th>
                        <th class="w-px hidden md:table-cell">Status</th>
                        <th class="w-px"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="users.data.length === 0">
                        <td class="text-center" colspan="6">
                            No se encontraron registros
                        </td>
                    </tr>
                    <tr v-for="(user, index, key) in users.data" :key="key">
                        <td class="hidden md:table-cell">
                            <label class="admin-checkbox">
                                <input
                                    type="checkbox"
                                    data-toggle="rowSelection"
                                    v-model="selectedRows"
                                    :value="user.id"
                                    :checked="user.id"
                                />
                                <span></span>
                            </label>
                        </td>
                        <td>{{ user.name }}</td>
                        <td class="hidden md:table-cell">{{ user.email }}</td>
                        <td class="hidden md:table-cell">{{ user.phone }}</td>
                        <td class="hidden md:table-cell">{{ $formatPrice(user.ave_purchases) }}</td>
                        <td class="text-center hidden lg:table-cell">
                            <span
                                v-if="user.suscribed"
                                class="text-success-700 text-2xl las la-user-check"
                            >
                            </span>
                            <span
                                v-else
                                class="text-danger-500 text-2xl las la-times-circle"
                            >
                            </span>
                        </td>
                        <td class="text-center hidden lg:table-cell">
                            <span
                                v-if="user.email_verified_at"
                                class="text-success-700 text-2xl las la-user-check"
                            >
                            </span>
                            <span
                                v-else
                                class="text-danger-500 text-2xl las la-times-circle"
                            >
                            </span>
                        </td>
                        <td class="text-center hidden md:table-cell">
                            <span
                                v-if="!user.deleted_at"
                                class="badge badge-outlined badge-success uppercase"
                                >Activo</span
                            >
                            <span
                                v-else
                                class="badge badge-outlined badge-danger uppercase"
                                >Desactivado</span
                            >
                        </td>
                        <td class="items-center text-center">
                            <Dropdown>
                                <template #trigger>
                                    <span
                                        class="btn btn-icon rounded-full text-secondary-500 hover:text-secondary-500 hover:bg-gray-100 la la-ellipsis-v"
                                    ></span>
                                </template>
                                <template #content>
                                    <div class="divide-y">
                                        <DropdownLink :href="
                                                route(
                                                    'admin.customers.customer.show',
                                                    { customer: user.id }
                                                )" class="hover:text-admin-500">
                                            <span
                                                class="la la-eye leading-none mr-2"
                                            ></span
                                            >{{ $t("Show") }}
                                        </DropdownLink>
                                        <DropdownLink
                                            v-if="
                                                !user.deleted_at &&
                                                $can('usuarios.delete')
                                            "
                                            @click="
                                                confirmDelete(user.id, index)
                                            "
                                            class="hover:text-danger-500"
                                        >
                                            <span
                                                class="la la-trash-alt leading-none mr-2"
                                                :data-id="user.id"
                                                :data-index="index"
                                            ></span
                                            >{{ $t("Delete") }}
                                        </DropdownLink>
                                        <DropdownLink
                                            v-if="
                                                user.deleted_at &&
                                                $can('usuarios.delete')
                                            "
                                            :href="
                                                route(
                                                    'admin.customers.customer.restore',
                                                    { customer: user.id }
                                                )
                                            "
                                            method="put"
                                            as="button"
                                            preserve-scroll
                                            class="hover:text-admin-500"
                                        >
                                            <span class="la la-redo-alt leading-none mr-2"></span>{{ $t("Restore") }}
                                        </DropdownLink>
                                    </div>
                                </template>
                            </Dropdown>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="w-full pb-5 lg:flex px-0 space-y-4 lg:space-y-0 lg:space-x-4">
        <Pagination
            :links="users.meta.links"
            :total="users.meta.total"
            :from="users.meta.from"
            :to="users.meta.to"
            v-if="users.data.length > 0"
        />
    </div>
</template>
