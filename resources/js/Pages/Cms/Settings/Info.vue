<script setup>
import { onMounted } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
defineProps({
    information: Object
});
</script>

<script context="module">
import AdminLayout from "@/Layouts/Admin.vue";

export default {
    layout: AdminLayout,
};
</script>

<template>
    <Head title="Informaci&oacute;n del Sistema" />

    <!-- Breadcrumb -->
    <section class="breadcrumb">
        <h1>Informaci&oacute;n del Sistema</h1>
        <ul>
            <li>
                <Link :href="route('admin.dashboard')">
                    <span class="la la-home"></span>
                </Link>
            </li>
            <li class="divider la la-arrow-right"></li>
            <li>Configuraci&oacute;n</li>
            <li class="divider la la-arrow-right"></li>
            <li>Informaci&oacute;n del Sistema</li>
        </ul>
    </section>

    <div class="container pb-5 lg:flex px-0 space-y-4 lg:space-y-0 lg:space-x-4">
        <div class="lg:w-1/2">
            <div class="card container py-4">
                <h4 class="pb-2">Informaci&oacute;n de configuraci&oacute;n</h4>
                <p>Utiliza esta informaci&oacute;n para comunicar un problema en el bug tracker o con soporte tecnico.</p>
            </div>
            <div class="card container py-4 mt-4">
                <h4 class="pb-2">Informaci&oacute;n del Servidor</h4>
                <ul>
                    <li>
                        <strong>Versi&oacute;n del software del servidor:</strong> {{ information.server.version }}
                    </li>
                    <li>
                        <strong>Versi&oacute;n de PHP:</strong> {{ information.server.php }}
                    </li>
                    <li>
                        <strong>Límite de memoria:</strong> {{ information.server.memory_limit }}
                    </li>
                    <li>
                        <strong>Tiempo m&aacute;x. de ejecuci&oacute;n:</strong> {{ information.server.max_execution_time }}
                    </li>
                    <li>
                        <strong>Tamaño m&aacute;x. para la subida de archivos:</strong> {{ information.server.upload_max_filesize }}
                    </li>
                </ul>
            </div>
            <div class="card container py-4 mt-4">
                <h4 class="pb-2">Informaci&oacute;n de la Base de Datos</h4>
                <ul>
                    <li>
                        <strong>Servidor:</strong> {{ information.database.connection }}
                    </li>
                    <li>
                        <strong>Host:</strong> {{ information.database.host }}
                    </li>
                    <li>
                        <strong>Nombre de Base de Datos:</strong> {{ information.database.database }}
                    </li>
                    <li>
                        <strong>Usuario MySQL:</strong> {{ information.database.username }}
                    </li>
                    <li>
                        <strong>Prefijo de las tablas:</strong> {{ information.database.prefix }}
                    </li>
                </ul>
            </div>
        </div>
        <div class="lg:w-1/2">
            <div class="card container py-4">
                <h4 class="pb-2">Informaci&oacute;n de la Tienda</h4>
                <ul>
                    <li>
                        <strong>Version:</strong> {{ information.store.version }}
                    </li>
                    <li>
                        <strong>URL de la tienda:</strong> https://{{ information.store.url }}
                    </li>
                    <li>
                        <strong>Ruta de la tienda:</strong> {{ information.store.path }}
                    </li>
                    <li>
                        <strong>Desarrollador:</strong> HJ ACCO AUTOPARTES SA DE CV
                    </li>
                </ul>
            </div>
            <div class="card container py-4 mt-4">
                <h4 class="pb-2">Configuraci&oacute;n de correo electr&oacute;nico</h4>
                <ul>
                    <li>
                        <strong>Tipo de servicio:</strong> {{ information.mail.type }}
                    </li>
                    <li>
                        <strong>Servidor de correo:</strong> {{ information.mail.server }}
                    </li>
                    <li>
                        <strong>Correo de salida:</strong> {{ information.mail.from }}
                    </li>
                    <li>
                        <strong>Puerto de salida de correo:</strong> {{ information.mail.port }}
                    </li>
                    <li>
                        <strong>Encriptación de correo:</strong> {{ information.mail.encrypt }}
                    </li>
                </ul>
            </div>
            <div class="card container py-4 mt-4">
                <h4 class="pb-2">Tu Informaci&oacute;n</h4>
                <ul>
                    <li>
                        <strong>Navegador:</strong> {{ information.customer.browser }}
                    </li>
                    <li>
                        <strong>Direcci&oacute;n IP:</strong> {{ information.customer.ip }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
