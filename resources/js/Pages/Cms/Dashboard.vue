<script setup>
import { onMounted } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import LineChartAnnotation from "@/Components/Cms/LineWithAnnotationChart.vue";
import LineChart from "@/Components/Cms/LineChart.vue";
import PolarWithShadowChart from "@/Components/Cms/PolarWithShadowChart.vue";
import { v4 as uuidv4 } from "uuid";

const props = defineProps({
    users: Number,
    visitors: {
        type: Object,
        default: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            data: [0,0,0,0,0,0,0,0,0,0,0,0]
        }
    }
})

let colors = {
    primary: "20, 83, 136",
};
let ctx = "";
const labels = [
    "Lunes",
    "Martes",
    "Miercoles",
    "Jueves",
    "Viernes",
    "Sabado",
    "Domingo",
];

const dataArr = [1250, 1300, 1550, 900, 1800, 1100, 1600];


</script>

<script context="module">
import AdminLayout from "@/Layouts/Admin.vue";

export default {
    layout: AdminLayout,
};
</script>

<template>
    <Head title="Dashboard" />

    <!-- Breadcrumb -->
    <section class="breadcrumb">
        <h1>Dashboard</h1>
        <ul>
            <li>
                <Link :href="route('admin.dashboard')">
                    <span class="la la-home"></span>
                </Link>
            </li>
            <li class="divider la la-arrow-right"></li>
            <li>Dashboard</li>
        </ul>
    </section>

    <div class="lg:flex pb-5 lg:-mx-4">
        <div class="lg:w-1/2 lg:px-4">
            <!-- Summaries -->
            <div class="lg:flex lg:-mx-4">
                <div class="lg:w-1/3 lg:px-4">
                    <div
                        class="card px-4 py-8 text-center lg:transform hover:scale-110 hover:shadow-lg transition-transform duration-200"
                    >
                        <span
                            class="text-admin text-5xl leading-none la la-users"
                        ></span>
                        <p class="mt-2">Nuevos Usuarios</p>
                        <div class="text-admin mt-5 text-3xl leading-none">
                            {{ users }}
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/3 lg:px-4 pt-5 lg:pt-0">
                    <div
                        class="card px-4 py-8 text-center lg:transform hover:scale-110 hover:shadow-lg transition-transform duration-200"
                    >
                        <span
                            class="text-admin text-5xl leading-none la la-cloud"
                        ></span>
                        <p class="mt-2">Ordenes Pendientes</p>
                        <div class="text-admin mt-5 text-3xl leading-none">
                            16
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/3 lg:px-4 pt-5 lg:pt-0">
                    <div
                        class="card px-4 py-8 text-center lg:transform hover:scale-110 hover:shadow-lg transition-transform duration-200"
                    >
                        <span
                            class="text-admin text-5xl leading-none la la-layer-group"
                        ></span>
                        <p class="mt-2">Ordenes Completadas</p>
                        <div class="text-admin mt-5 text-3xl leading-none">
                            9
                        </div>
                    </div>
                </div>
            </div>
            <!-- Visitors -->
            <div class="card mt-5 p-5">
                <h3>Visitors</h3>
                <div class="mt-5">
                    <LineChart
                        id="visitorsChart"
                        :labels="visitors.labels"
                        :data="visitors.data"
                    />
                </div>
            </div>
        </div>
        <div class="lg:w-1/2 lg:px-4 pt-5 lg:pt-0 -mx-4">
            <!-- Lines -->
            <div class="flex flex-wrap">
                <div class="w-1/2 lg:w-1/4 px-4">
                    <div class="card p-5">
                        <h6 class="chart-heading uppercase"></h6>
                        <h4 class="chart-value text-2xl mt-2"></h4>
                        <small class="chart-label uppercase"></small>
                        <LineChartAnnotation
                            id="lineWithAnnotationChart1"
                            title="Ordenes Totales"
                            :labels="labels"
                            :data="dataArr"
                            class="mt-5"
                        />
                    </div>
                </div>
                <div class="w-1/2 lg:w-1/4 px-4">
                    <div class="card p-5">
                        <h6 class="chart-heading uppercase"></h6>
                        <h4 class="chart-value text-2xl mt-2"></h4>
                        <small class="chart-label uppercase"></small>
                        <LineChartAnnotation
                            title="Ordenes Activas"
                            :labels="labels"
                            :data="[100, 125, 75, 125, 100, 75, 75]"
                            class="mt-5"
                        />
                    </div>
                </div>
                <div class="w-1/2 lg:w-1/4 px-4 mt-5 lg:mt-0">
                    <div class="card p-5">
                        <h6 class="chart-heading uppercase"></h6>
                        <h4 class="chart-value text-2xl mt-2"></h4>
                        <small class="chart-label uppercase"></small>
                        <LineChartAnnotation
                            id="lineWithAnnotationChart3"
                            title="Ordenes Pendientes"
                            :labels="labels"
                            :data="[300, 300, 600, 700, 600, 300, 300]"
                            class="mt-5"
                        />
                    </div>
                </div>
                <div class="w-1/2 lg:w-1/4 px-4 mt-5 lg:mt-0">
                    <div class="card p-5">
                        <h6 class="chart-heading uppercase"></h6>
                        <h4 class="chart-value text-2xl mt-2"></h4>
                        <small class="chart-label uppercase"></small>
                        <LineChartAnnotation
                            id="lineWithAnnotationChart4"
                            title="Ordenes Enviadas"
                            :labels="labels"
                            :data="[200, 400, 200, 500, 100, 100, 400]"
                            class="mt-5"
                        />
                    </div>
                </div>
            </div>
            <!-- Recent Orders -->
            <div class="card mt-5 p-5">
                <h3>Pedidos Recientes</h3>
                <table class="table table-list mt-3 w-full">
                    <thead>
                        <tr class="text-admin-500">
                            <th class="text-left uppercase">
                                Orden #
                            </th>
                            <th class="w-px uppercase">Views</th>
                            <th class="w-px uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, key) in 5" :key="key">
                            <td>{{ uuidv4() }}</td>
                            <td class="text-center">100</td>
                            <td class="text-center">
                                <div class="badge badge-outlined badge-danger uppercase">
                                    Cancelado
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="flex items-center justify-end">
                    <a href="#" class="btn btn-admin rounded-full mt-5">Ver Todo</a>
                </div>
            </div>
        </div>
    </div>
</template>
