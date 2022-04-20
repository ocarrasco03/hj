<script setup>
import { computed, onMounted, ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Cms/Pagination.vue";
import Swal from "sweetalert2";
import axios from "axios";
import nprogress from "nprogress";

const props = defineProps({
    users: Object,
});

const selectedRows = ref([]);

const confirmDelete = (event) => {
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
    form.get(route("admin.settings.advanced.users.index"));
};

const getRoleNames = (roles) => {
    let name = "";

    if (roles.length > 0) {
        roles.forEach(element => {
            name = name === '' ? element.name : name;
        });
    }

    return name;
};
</script>

<script context="module">
import AdminLayout from "@/Layouts/Admin.vue";

export default {
    layout: AdminLayout,
};
</script>

<template>
    <Head title="Usuarios" />

    <!-- Breadcrumb -->
    <section class="breadcrumb lg:flex items-start">
        <div>
            <h1>Usuarios</h1>
            <ul>
                <li>
                    <Link :href="route('admin.dashboard')">
                        <span class="la la-home"></span>
                    </Link>
                </li>
                <li class="divider la la-arrow-right"></li>
                <li>Configuraci&oacute;n</li>
                <li class="divider la la-arrow-right"></li>
                <li>Avanzado</li>
                <li class="divider la la-arrow-right"></li>
                <li>Usuarios</li>
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
                <Link
                    :href="route('admin.settings.advanced.users.create')"
                    class="btn btn-admin uppercase ml-2"
                    >Agregar</Link
                >
            </div>
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
                                        selectedRows.length < users.per_page &&
                                        selectedRows.length > 0
                                            ? true
                                            : null
                                    "
                                    disabled
                                />
                                <span></span>
                            </label>
                        </th>
                        <th class="text-left">Usuario</th>
                        <th class="text-left hidden md:table-cell">
                            Nombre de Usuario
                        </th>
                        <th class="text-left hidden md:table-cell">Email</th>
                        <th class="w-px hidden md:table-cell">Status</th>
                        <th>Actions</th>
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
                        <td class="hidden md:table-cell">
                            {{ user.username }}
                        </td>
                        <td class="hidden md:table-cell">{{ user.email }}</td>
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
                            <Link
                                :href="route('admin.settings.advanced.users.show', {id: user.id})"
                                v-if="!user.deleted_at"
                                class="btn btn-outlined btn-admin btn-icon"
                                as="button"
                                method="get"
                                :disabled="!$can('usuarios.update') || (getRoleNames(user.roles) === 'Super Administrador' && !$page.props.isSuperAdmin)"
                            >
                                <span class="la la-pen"></span>
                            </Link>
                            <button
                                v-if="!user.deleted_at"
                                class="btn btn-outlined btn-danger ml-2 btn-icon rounded-full"
                                @click="confirmDelete"
                                :disabled="user.id === $page.props.auth.user.id || !$can('usuarios.delete')"
                            >
                                <span
                                    class="la la-trash-alt"
                                    :data-id="user.id"
                                    :data-index="index"
                                ></span>
                            </button>
                            <Link
                                v-if="user.deleted_at"
                                :href="
                                    route(
                                        'admin.settings.advanced.users.restore',
                                        { user: user.id }
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
            :links="users.links"
            :total="users.total"
            :from="users.from"
            :to="users.to"
        />
    </div>
</template>
