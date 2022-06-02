<script setup>
import { computed, ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Modal from "@/Components/Cms/DialogModal.vue";

const props = defineProps({
    roles: Object,
    permissions: Object,
});

const role = ref(null);
const selected = ref([]);
const index = ref(null);
const showAddRole = ref(false);
const showAddPermission = ref(false);
const roleInput = ref(null);
const permissionInput = ref(null);

const form = useForm({
    name: "",
});

const formPermission = useForm({
    name: "",
});

const formAssign = useForm({
    permissions: selected,
});

const loadPermissions = () => {
    selected.value = [];
    const roles = props.roles;
    index.value = roles.findIndex((element) => {
        if (element.name === role.value) {
            element.permissions.forEach((e) => {
                selected.value.push(e.name);
            });
        }
        return element.name === role.value;
    });
};

const processPermissionName = (permission) => {
    let name = permission.split(".");
    let procesed = name[0];

    switch (name[1]) {
        case "create":
            procesed += " crear";
            break;
        case "read":
            procesed += " leer";
            break;
        case "update":
            procesed += " editar";
            break;
        case "delete":
            procesed += " eliminar";
            break;
        default:
            break;
    }

    return procesed;
};


const saveRole = () => {
    form.post(route("admin.settings.advanced.roles.permissions.save.role"), {
        preserveScroll: true,
        onSuccess: () => closeModal("role"),
        onError: () => roleInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const savePermission = () => {
    formPermission.post(
        route("admin.settings.advanced.roles.permissions.save.permission"),
        {
            preserveScroll: true,
            onSuccess: () => closeModal("permission"),
            onError: () => permissionInput.value.focus(),
            onFinish: () => form.reset(),
        }
    );
};

const assignPermissions = () => {
    formAssign.put(
        route("admin.settings.advanced.roles.permissions.update.permissions", {
            rol: role.value,
        }),
        {
            preserveScroll: true,
            preserveState: true,
        }
    );
};

const closeModal = (type) => {
    switch (type) {
        case "role":
            showAddRole.value = false;
            form.reset();
            break;
        case "permission":
            showAddPermission.value = false;
            formPermission.reset();
            break;
    }
};
</script>
<script context="module">
import AdminLayout from "@/Layouts/Admin.vue";

export default {
    layout: AdminLayout,
};
</script>
<template>
    <Head title="Roles y Permisos" />

    <!-- Breadcrumb -->
    <section class="breadcrumb lg:flex items-start">
        <div>
            <h1>Roles y Permisos</h1>
            <ul>
                <li>
                    <Link :href="route('admin.dashboard')">
                        <span class="la la-home"></span>
                    </Link>
                </li>
                <li class="divider la la-arrow-right"></li>
                <li><Link v-text="'Configuraci&oacute;n'" /></li>
                <li class="divider la la-arrow-right"></li>
                <li><Link v-text="'Avanzado'" /></li>
                <li class="divider la la-arrow-right"></li>
                <li>Roles y Permisos</li>
            </ul>
        </div>
        <div class="lg:flex items-center ml-auto mt-5 lg:mt-0">
            <div class="flex mt-5 lg:mt-0">
                <!-- Add New -->
                <button
                    class="btn btn-admin uppercase ml-2"
                    @click="showAddRole = true"
                >
                    Nuevo Rol
                </button>
            </div>
            <div class="flex mt-5 lg:mt-0">
                <!-- Add New -->
                <button
                    class="btn btn-admin uppercase ml-2"
                    @click="showAddPermission = true"
                    v-if="$page.props.isSuperAdmin"
                >
                    Nuevo Permiso
                </button>
            </div>
        </div>
    </section>

    <!-- Content -->
    <div class="card w-full py-2 container mb-5 flex">
        <div class="custom-select flex-1">
            <select
                id="role"
                class="form-control"
                v-model="role"
                @change="loadPermissions"
            >
                <option :value="null" disabled>Selecciona un Rol</option>
                <template v-for="(role, index, key) in roles" :key="key">
                    <option :value="role.name">
                        {{ role.name }}
                    </option>
                </template>
            </select>
            <div class="custom-select-icon la la-caret-down"></div>
        </div>
        <button
            class="btn btn-admin ml-2 flex-shrink-0"
            :disabled="role === null || role === 'Super Administrador'"
            @click="assignPermissions"
        >
            {{ $t("Save permissions") }}
        </button>
    </div>
    <div
        class="container mb-5 px-0 box-border"
        v-if="role === 'Super Administrador'"
    >
        <div class="card card-row hover:bg-admin-100 p-2">
            <label
                class="flex space-x-2 items-center px-2 py-4 flex-1 border border-dashed justify-center font-bold"
            >
                <span
                    >Los permisos de Super Administrador no pueden ser
                    modificados</span
                >
            </label>
        </div>
    </div>
    <div class="card container mb-5 px-0" v-else>
        <table class="table table-admin w-full table-admin-first-col">
            <thead>
                <tr>
                    <th class="capitalize">{{ $t("module") }}</th>
                    <th class="capitalize">{{ $t("create") }}</th>
                    <th class="capitalize">{{ $t("read") }}</th>
                    <th class="capitalize">{{ $t("update") }}</th>
                    <th class="capitalize">{{ $t("delete") }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(permission, key) in permissions" :key="key">
                    <td class="text-left capitalize">{{ $t(permission.name) }}</td>
                    <td>
                        <label class="admin-checkbox flex items-center justify-center">
                            <input
                                type="checkbox"
                                :id="permission.prefix"
                                v-model="selected"
                                :value="`${permission.prefix}.create`"
                                :checked="permission.prefix"
                                :disabled="
                                    index === null ||
                                    role === 'Super Administrador'
                                "
                            />
                            <span></span>
                        </label>
                    </td>
                    <td>
                        <label class="admin-checkbox flex items-center justify-center">
                            <input
                                type="checkbox"
                                :id="permission.prefix"
                                v-model="selected"
                                :value="`${permission.prefix}.read`"
                                :checked="permission.prefix"
                                :disabled="
                                    index === null ||
                                    role === 'Super Administrador'
                                "
                            />
                            <span></span>
                        </label>
                    </td>
                    <td>
                        <label class="admin-checkbox flex items-center justify-center">
                            <input
                                type="checkbox"
                                :id="permission.prefix"
                                v-model="selected"
                                :value="`${permission.prefix}.update`"
                                :checked="permission.prefix"
                                :disabled="
                                    index === null ||
                                    role === 'Super Administrador'
                                "
                            />
                            <span></span>
                        </label>
                    </td>
                    <td>
                        <label class="admin-checkbox flex items-center justify-center">
                            <input
                                type="checkbox"
                                :id="permission.prefix"
                                v-model="selected"
                                :value="`${permission.prefix}.delete`"
                                :checked="permission.prefix"
                                :disabled="
                                    index === null ||
                                    role === 'Super Administrador'
                                "
                            />
                            <span></span>
                        </label>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <Modal :show="showAddRole" @close="closeModal('role')">
        <template #title>
            <h2>{{ $t("Create new role") }}</h2></template
        >

        <template #content>
            <div class="mt-4">
                <input
                    type="text"
                    ref="roleInput"
                    class="form-control"
                    placeholder="Rol ej. Administrador"
                    v-model="form.name"
                    @keyup.enter="saveRole"
                />

                <!-- <JetInputError :message="form.errors.password" class="mt-2" /> -->
            </div>
        </template>

        <template #footer>
            <button
                class="btn btn-secondary rounded-full mr-2"
                @click="closeModal('role')"
            >
                {{ $t("Cancel") }}
            </button>
            <button
                class="btn btn-admin"
                :class="{ 'opacity-25': form.processing }"
                @click="saveRole"
            >
                {{ $t("Save") }}
            </button>
        </template>
    </Modal>
    <Modal :show="showAddPermission" @close="closeModal('permission')">
        <template #title>
            <h2>{{ $t("Create new permission") }}</h2></template
        >

        <template #content>
            <div class="mt-4">
                <input
                    type="text"
                    ref="permissionInput"
                    class="form-control"
                    placeholder="Permiso ej. Editar usuarios"
                    v-model="formPermission.name"
                    @keyup.enter="savePermission"
                />

                <!-- <JetInputError :message="form.errors.password" class="mt-2" /> -->
            </div>
        </template>

        <template #footer>
            <button
                class="btn btn-secondary rounded-full mr-2"
                @click="closeModal('permission')"
            >
                {{ $t("Cancel") }}
            </button>
            <button
                class="btn btn-admin"
                :class="{ 'opacity-25': formPermission.processing }"
                @click="savePermission"
            >
                {{ $t("Save") }}
            </button>
        </template>
    </Modal>
</template>
