<script setup>
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { ref } from 'vue';
import axios from 'axios';

const isLoading = ref(false)

const form = useForm({
    command: '',
});

const submit = () => {
    const target = document.getElementById('output');

    !isLoading
    axios
        .post(route('admin.support.console.exec'), form)
        .then(res => {
            target.innerHTML = ''
            const output = new DOMParser().parseFromString(res.data, 'text/xml')
            console.log(output.firstChild)
            console.log(output.firstChild.firstChild)
            target.innerHTML = res.data
        }).catch(err => {
            console.log(err)
        })
}
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
        <h1>Terminal</h1>
        <ul>
            <li><a href="#">Soporte</a></li>
            <li class="divider">
                <i class="fal fa-arrow-right"></i>
            </li>
            <li>Terminal</li>
        </ul>
    </section>

    <!-- Card Blank -->
    <div class="lg:flex pb-5">
        <div class="flex-auto">
            <div id="output" class="bg-secondary-500 h-96 overflow-auto text-gray-200 p-2 rounded-md shadow-md block overflow-y-visible">
                <code class="text-green-500">
                    <i class="las la-angle-right"></i>
                </code>
                <code v-if="isLoading">Ejecutando...</code>
            </div>
            <div class="card p-5 mt-3 w-full">
                <form @submit.prevent="submit">
                    <div class="input-group mt-5">
                        <input type="text" class="form-control input-group-item" placeholder="Comando php artisan 'list | queue:listen'" v-model="form.command">
                        <button type="submit" class="btn btn-primary uppercase input-group-item">Ejecutar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
