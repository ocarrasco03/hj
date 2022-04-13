<script setup>
import { computed, onMounted, ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from '@/Components/Cms/Pagination.vue';
const props = defineProps({
    users: Object,
});

const selectedRows = ref([]);
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
            <!-- Layout -->
            <div class="flex mt-5 lg:mt-0">
                <a href="#" class="btn btn-icon btn-icon-large btn-outlined btn-admin">
                    <span class="la la-bars"></span>
                </a>
                <a href="#"
                    class="btn btn-icon btn-icon-large btn-outlined btn-admin-secondary ml-2">
                    <span class="la la-list"></span>
                </a>
                <a href="#"
                    class="btn btn-icon btn-icon-large btn-outlined btn-admin-secondary ml-2">
                    <span class="la la-th-large"></span>
                </a>
            </div>
            <!-- Search -->
            <form class="flex items-center lg:ml-2 mt-5 lg:mt-0" @submit.prevent="">
                <label class="form-control-addon-within rounded-full border-admin-secondary">
                    <input type="text" class="form-control border-none" placeholder="Search">
                    <button type="button"
                        class="btn btn-link text-secondary dark:text-gray-700 hover:text-primary dark:hover:text-primary text-xl leading-none la la-search mr-4"></button>
                </label>
            </form>
            <div class="flex mt-5 lg:mt-0">
                <!-- Sort By -->
                <div class="dropdown lg:ml-2">
                    <button class="btn btn-outlined btn-admin-secondary uppercase" data-toggle="dropdown-menu">
                        Sort By
                        <span class="ml-3 la la-caret-down text-xl leading-none"></span>
                    </button>
                    <!-- <div class="dropdown-menu">
                        <a href="#">Ascending</a>
                        <a href="#">Descending</a>
                    </div> -->
                </div>
                <!-- Add New -->
                <button class="btn btn-admin uppercase ml-2">Agregar</button>
            </div>
        </div>
    </section>

    <div class="container pb-5 lg:flex px-0 space-y-4 lg:space-y-0 lg:space-x-4">
        <div class="card w-full py-4">
            <table class="table table-auto w-full table-hoverable border-collapse" v-cloak>
                <thead>
                    <tr class="text-admin">
                        <th class="w-px hidden md:table-cell">
                            <label class="admin-checkbox">
                                <input type="checkbox" :checked="selectedRows.length > 0" :partial="selectedRows.length < users.per_page && selectedRows.length > 0 ? true : null" v-model="selectAll" disabled>
                                <span></span>
                            </label>
                        </th>
                        <th class="text-left">Usuario</th>
                        <th class="text-left">Nombre de Usuario</th>
                        <th class="hidden md:table-cell">Email</th>
                        <th class="w-px hidden md:table-cell">Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index, key) in users.data" :key="key">
                        <td class="hidden md:table-cell">
                            <label class="admin-checkbox">
                                <input type="checkbox" data-toggle="rowSelection" v-model="selectedRows" :value="user.id" :checked="user.id">
                                <span></span>
                            </label>
                        </td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.username }}</td>
                        <td class="hidden md:table-cell">{{ user.email }}</td>
                        <td class="text-center hidden md:table-cell">
                            <span v-if="user.deleted_at !== undefined" class="badge badge-outlined badge-success uppercase">Activo</span>
                            <span v-else class="badge badge-outlined badge-danger uppercase">Desactivado</span>
                        </td>
                        <td class="items-center text-center">
                            <Link class="btn btn-outlined btn-admin btn-icon">
                                <span class="la la-pen"></span>
                            </Link>
                            <Link class="btn btn-outlined btn-danger ml-2 btn-icon rounded-full">
                                <span class="la la-trash-alt"></span>
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="container pb-5 lg:flex px-0 space-y-4 lg:space-y-0 lg:space-x-4">
        <Pagination :links="users.links" :total="users.total" :from="users.from" :to="users.to" />
    </div>
</template>
