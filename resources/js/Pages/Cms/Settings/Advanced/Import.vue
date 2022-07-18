<script setup>
import { computed, onMounted, ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Cms/Pagination.vue";
import Swal from "sweetalert2";
import axios from "axios";
import nprogress from "nprogress";
import ValidationErrors from "@/Components/ValidationErrors";

const form = useForm({
    files: null,
});

const submit = () => {
    // form.post(route("admin.settings.general.slider.store", { slider: 1 }), {
    //     preserveScroll: true,
    //     preserveState: false,
    // });
};

const drop = event => {
    event.preventDefault()
    document.getElementById("uploadFile").files = event.dataTransfer.files;
    form.image = event.dataTransfer.files;
    submit();
}

</script>

<script context="module">
import AdminLayout from "@/Layouts/Admin.vue";

export default {
    layout: AdminLayout,
};
</script>

<template>
    <Head title="Importar" />

    <!-- Breadcrumb -->
    <section class="breadcrumb lg:flex items-start">
        <div>
            <h1>Importar</h1>
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
                <li>Importar</li>
            </ul>
        </div>
    </section>

    <div class="w-full pb-5 px-0 space-y-4">
        <div class="card w-full p-3 md:flex">
            <div class="flex-1">
                <label for="type">Tipo</label>
                <select name="type" id="type">
                    <option value="image">Imagenes</option>
                    <option value="file">Archivo</option>
                </select>
            </div>
            <div class="md:ml-2">
                <label for="type">Tipo de Carga</label>
                <select name="type" id="type">
                    <option value="image">Productos</option>
                </select>
            </div>
        </div>
        <div class="card w-full p-3">
            <form @submit.prevent="submit" :disabled="form.processing">
                <ValidationErrors class="mt-5" />
                <div
                    id="uploadFileZone"
                    class="dropzone cursor-pointer"
                    :class="{'bg-gray-100 cursor-not-allowed': form.processing}"
                    @click="upload"
                    @drop="drop"
                    @dragover="dragover"
                    @dragleave="dragleave"
                    :disabled="form.processing"
                >
                    <h3>{{ $t('Drop files here to upload or click') }}</h3>
                    <input
                        type="file"
                        @input="form.files = $event.target.files[0]"
                        id="uploadFile"
                        @change="submit"
                        class="hidden"
                        multiple
                        :disabled="form.processing"
                    />
                </div>
            </form>
        </div>
    </div>

</template>
