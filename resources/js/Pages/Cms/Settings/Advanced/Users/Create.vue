<script setup>
import { computed, onMounted, ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Cms/Pagination.vue";
import ValidationErrors from "@/Components/Cms/ValidationErrors.vue";
import Swal from "sweetalert2";
import axios from "axios";
import nprogress from "nprogress";
import { trans } from "laravel-vue-i18n";

const props = defineProps({
    roles: Object,
    modules: Object,
});

const form = useForm({
    name: "",
    username: "",
    email: "",
    password: "",
    password_confirmation: "",
    role: null,
    permissions: [],
});

const errors = ref({});

const rules = {
    name: ["required"],
    username: ["required"],
    email: ["required", "email"],
    password: ["required"],
    role: ["required"],
};

const validate = (form) => {
    let flag = true;

    const error = {};

    for (let key in rules) {
        for (let rule in rules[key]) {
            switch (rules[key][rule]) {
                case "required":
                    if (
                        form[key] === "" ||
                        typeof form[key] === undefined ||
                        typeof form[key] === null ||
                        form[key] === null
                    ) {
                        error[key] = trans("validation.required", {
                            attribute: key,
                        });
                        flag = false;
                    }
                    break;

                case "email":
                    if (!pattern.test(form[key])) {
                        error[key] = trans("validation.email", {
                            attribute: key,
                        });
                        flag = false;
                    }
                    break;

                case "string":
                    if (typeof form[key] !== 'string') {
                        error[key] = trans("validation.string", {
                            attribute: key,
                        });
                        flag = false;
                    }
                    break;
            }
        }
    }

    if (!flag) errors.value = error;

    return flag;
};

const submit = () => {
    if (validate(form)) {
        form.post(route("admin.settings.advanced.users.store"), {
            onError: (error) => {
                if (typeof error === "object") {
                    errors.value = error;
                } else {
                    console.error(error);
                }
            },
        });
    }
};

const cleanSpace = (event) =>
    (event.target.value = event.target.value.replace(/\s+/g, ""));

const pattern =
    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

const showPassword = (event) => {
    if (event.target.previousElementSibling.type === "password") {
        event.target.previousElementSibling.type = "text";
        event.target.classList.add("la-low-vision");
        event.target.classList.remove("la-eye");
    } else {
        event.target.previousElementSibling.type = "password";
        event.target.classList.add("la-eye");
        event.target.classList.remove("la-low-vision");
    }
};

const loadPermissions = () => {
    form.permissions = [];
    props.roles.forEach((element) => {
        if (form.role === element.name) {
            element.abilities.forEach((ability) => {
                form.permissions.push(ability);
            });
        }
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
                <li>
                    <Link v-text="'Configuraci&oacute;n'" />
                </li>
                <li class="divider la la-arrow-right"></li>
                <li>
                    <Link v-text="'Avanzado'" />
                </li>
                <li class="divider la la-arrow-right"></li>
                <li>
                    <Link
                        :href="route('admin.settings.advanced.users.index')"
                        v-text="'Usuarios'"
                    />
                </li>
                <li class="divider la la-arrow-right"></li>
                <li>Nuevo</li>
            </ul>
        </div>
        <div class="lg:flex items-center ml-auto mt-5 lg:mt-0">
            <div class="flex mt-5 lg:mt-0">
                <!-- Add New -->
                <Link
                    :href="route('admin.settings.advanced.users.index')"
                    class="btn btn-admin btn-outlined rounded-full uppercase ml-2"
                >
                    <i class="las la-undo"></i>
                    <span class="hidden lg:block ml-2">Regresar</span>
                </Link>
            </div>
        </div>
    </section>

    <div class="w-full px-0">
        <ValidationErrors class="mb-4" />
        <form
            @submit.prevent="submit"
            autocomplete="off"
            class="pb-5 lg:flex space-y-4 lg:space-y-0 lg:space-x-4"
        >
            <div class="lg:w-1/2">
                <div class="card mt-5 p-5">
                    <div class="mb-5">
                        <label class="label block mb-2" for="name"
                            >Nombre</label
                        >
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="form-control"
                            placeholder="John Doe"
                            :class="{ 'is-invalid': errors.name }"
                        />
                        <small
                            v-if="errors.name"
                            class="block mt-2 invalid-feedback"
                            >{{ errors.name }}</small
                        >
                    </div>
                    <div class="mb-5">
                        <label class="label block mb-2" for="username"
                            >Nombre de Usuario</label
                        >
                        <input
                            id="username"
                            v-model="form.username"
                            type="text"
                            class="form-control"
                            placeholder="demo123"
                            @keyup="cleanSpace"
                            :class="{ 'is-invalid': errors.username }"
                        />
                        <small
                            v-if="errors.username"
                            class="block mt-2 invalid-feedback"
                            >{{ errors.username }}</small
                        >
                    </div>
                    <div class="mb-5">
                        <label class="label block mb-2" for="email"
                            >Email</label
                        >
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="form-control"
                            placeholder="example@example.com"
                            :class="{
                                'is-invalid':
                                    (!pattern.test(form.email) &&
                                        form.email.length > 0) ||
                                    errors.email,
                            }"
                        />
                        <small
                            v-if="
                                !pattern.test(form.email) &&
                                form.email.length > 0
                            "
                            class="block mt-2 invalid-feedback"
                            >El email no es valido!</small
                        >
                        <small
                            v-else-if="errors.email"
                            class="block mt-2 invalid-feedback"
                            >{{ errors.email }}</small
                        >
                    </div>
                    <div class="mb-5">
                        <label class="label block mb-2" for="password">{{
                            $t("Password")
                        }}</label>
                        <label
                            class="form-control-addon-within"
                            :class="{ 'is-invalid': errors.password }"
                        >
                            <input
                                id="password"
                                v-model="form.password"
                                type="password"
                                class="form-control border-none"
                            />
                            <button
                                @click="showPassword"
                                type="button"
                                class="btn btn-link text-gray-300 dark:text-gray-700 hover:text-admin-500 dark:hover:text-primary text-xl leading-none mr-4 la la-eye"
                            ></button>
                        </label>
                        <small
                            v-if="errors.password"
                            class="block mt-2 invalid-feedback"
                            >{{ errors.password }}</small
                        >
                    </div>
                    <div class="mb-5">
                        <label
                            class="label block mb-2"
                            for="password_confirmation"
                            >{{ $t("Confirm Password") }}</label
                        >
                        <label
                            class="form-control-addon-within"
                            :class="{
                                'is-invalid':
                                    (form.password !==
                                        form.password_confirmation &&
                                        form.password_confirmation.length >
                                            0) ||
                                    errors.password_confirmation,
                            }"
                        >
                            <input
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                class="form-control border-none"
                            />
                            <button
                                @click="showPassword"
                                type="button"
                                class="btn btn-link text-gray-300 dark:text-gray-700 hover:text-admin-500 dark:hover:text-primary text-xl leading-none mr-4 la la-eye"
                            ></button>
                        </label>
                        <small
                            v-if="
                                form.password !== form.password_confirmation &&
                                form.password_confirmation.length > 0
                            "
                            class="block mt-2 invalid-feedback"
                            >Las contraseñas deben coincidir!</small
                        >
                        <small
                            v-else-if="errors.password_confirmation"
                            class="block mt-2 invalid-feedback"
                            >{{ errors.password_confirmation }}</small
                        >
                    </div>
                </div>
            </div>
            <div class="lg:w-1/2">
                <div class="card mt-5 p-5">
                    <form @submit.prevent="submit" autocomplete="off">
                        <div class="mb-5">
                            <label
                                class="label block mb-2"
                                for="password_confirmation"
                                >Rol de Usuario</label
                            >
                            <div class="custom-select">
                                <select
                                    id="role"
                                    class="form-control"
                                    v-model="form.role"
                                    @change="loadPermissions"
                                    :class="{ 'is-invalid': errors.role }"
                                >
                                    <option :value="null" disabled>
                                        Asigna un Rol
                                    </option>
                                    <template
                                        v-for="(role, index, key) in roles"
                                        :key="key"
                                    >
                                        <option
                                            :value="role.name"
                                            v-if="
                                                role.name ===
                                                    'Super Administrador' &&
                                                $page.props.isSuperAdmin
                                            "
                                        >
                                            {{ role.name }}
                                        </option>
                                        <option
                                            :value="role.name"
                                            v-else-if="
                                                role.name !==
                                                'Super Administrador'
                                            "
                                        >
                                            {{ role.name }}
                                        </option>
                                    </template>
                                </select>
                                <div
                                    class="custom-select-icon la la-caret-down"
                                ></div>
                            </div>
                            <small
                                v-if="errors.role"
                                class="block mt-2 invalid-feedback"
                                >{{ errors.role }}</small
                            >
                        </div>
                        <div class="mb-5">
                            <table
                                class="table table-auto w-full border-collapse overflow-auto max-h-96"
                            >
                                <thead>
                                    <tr class="text-admin">
                                        <th>Modulo</th>
                                        <th class="w-20 text-center">Crear</th>
                                        <th class="w-20 text-center">Leer</th>
                                        <th class="w-20 text-center">
                                            Actualizar
                                        </th>
                                        <th class="w-20 text-center">
                                            Eliminar
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-if="
                                            form.role === 'Super Administrador'
                                        "
                                    >
                                        <td
                                            colspan="5"
                                            class="text-center font-medium"
                                        >
                                            Los permisos de Super Administrador
                                            no pueden ser modificados
                                        </td>
                                    </tr>
                                    <tr
                                        v-else
                                        v-for="(module, key) in modules"
                                        :key="key"
                                    >
                                        <td>{{ module.name }}</td>
                                        <td>
                                            <label
                                                class="admin-checkbox flex justify-center items-center"
                                            >
                                                <input
                                                    type="checkbox"
                                                    v-model="form.permissions"
                                                    :value="
                                                        module.prefix +
                                                        '.create'
                                                    "
                                                    :disabled="
                                                        form.role === null
                                                    "
                                                />
                                                <span></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label
                                                class="admin-checkbox flex justify-center items-center"
                                            >
                                                <input
                                                    type="checkbox"
                                                    v-model="form.permissions"
                                                    :value="
                                                        module.prefix + '.read'
                                                    "
                                                    :disabled="
                                                        form.role === null
                                                    "
                                                />
                                                <span></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label
                                                class="admin-checkbox flex justify-center items-center"
                                            >
                                                <input
                                                    type="checkbox"
                                                    v-model="form.permissions"
                                                    :value="
                                                        module.prefix +
                                                        '.update'
                                                    "
                                                    :disabled="
                                                        form.role === null
                                                    "
                                                />
                                                <span></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label
                                                class="admin-checkbox flex justify-center items-center"
                                            >
                                                <input
                                                    type="checkbox"
                                                    v-model="form.permissions"
                                                    :value="
                                                        module.prefix +
                                                        '.delete'
                                                    "
                                                    :disabled="
                                                        form.role === null
                                                    "
                                                />
                                                <span></span>
                                            </label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-5 lg:flex lg:justify-end">
                            <button
                                type="submit"
                                class="btn btn-admin text-right"
                            >
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </form>
    </div>
</template>
