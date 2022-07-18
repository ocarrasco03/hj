<script setup>
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import moment from "moment";
import axios from 'axios';
moment.locale("es-mx");

const props = defineProps({
    logs: Object,
});

const form = useForm({
    file: '',
    l: ''
});

const loadLog = () => {
    axios.get(route('admin.support.logs.crypt'), { params: { l: form.file } }).then(res => {
        form.l = res.data
        submit();
    });
}

const submit = () => {
    form.get(route('admin.support.logs'), {
        preserveState: true
    });
}
</script>

<script context="module">
import AdminLayout from "@/Layouts/Admin.vue";

export default {
    layout: AdminLayout,
};
</script>
<template>
    <Head title="Logs" />

    <section class="breadcrumb">
        <h1>Logs</h1>
        <ul>
            <li>
                <Link :href="route('admin.dashboard')">
                    <span class="la la-home"></span>
                </Link>
            </li>
            <li class="divider la la-arrow-right"></li>
            <li><Link v-text="$t('Support')" /></li>
            <li class="divider">
                <i class="fal fa-arrow-right"></i>
            </li>
            <li>Logs</li>
        </ul>
    </section>

    <div class="lg:flex w-full items-center justify-end mb-3">

        <div>
            <label for="">Archivo Log</label>
            <select id="log-file" class="form-control" v-model="form.file" @change="loadLog">
                <option
                    v-for="(file, index,key) in logs.files"
                    :key="key"
                    :selected="index === 0 ? true : false"
                >
                    {{ file }}
                </option>
            </select>
        </div>
    </div>
    <div class="lg:flex pb-5 w-full">
        <div class="flex-auto space-y-3">
            <template v-if="logs.logs === null">
                <div>Log file > 50M, pleade download it.</div>
            </template>
            <template v-else>
                <template v-for="(log, index, key) in logs.logs" :key="key">
                    <div
                        class="card w-full divide-y hover:border-admin-500 border border-transparent"
                    >
                        <div
                            class="py-2 flex items-center justify-center space-y-4 lg:space-y-0 flex-col lg:flex-row"
                        >
                            <div class="shrink-0 text-left w-full lg:w-28">
                                <div
                                    class="text-white w-full text-center uppercase font-bold py-1"
                                    :class="`bg-${log.level_class}`"
                                >
                                    <span
                                        :class="`fa fa-${log.level_img}`"
                                    ></span>
                                </div>
                            </div>
                            <div class="flex-auto px-4">
                                <div>
                                    <p
                                        class="text-secondary-500 font-normal text-xs whitespace-normal"
                                    >
                                        {{ log.text }}
                                    </p>
                                </div>
                                <template v-if="log.in_file">
                                    <p>{{ log.in_file }}</p>
                                </template>
                            </div>
                        </div>
                        <div
                            class="divide-y lg:divide-y-0 lg:divide-x bg-admin-50 rounded-b-xl lg:flex lg:items-stretch"
                        >
                            <template v-if="logs.standardFormat">
                                <div
                                    class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                                >
                                    <small class="capitalize text-left">{{
                                        $t("level")
                                    }}</small>
                                    <span
                                        class="font-bold capitalize"
                                        :class="`text-${log.level_class}`"
                                        >{{ log.level }}</span
                                    >
                                </div>
                                <div
                                    class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                                >
                                    <small class="capitalize text-left">{{
                                        $t("context")
                                    }}</small>
                                    <span class="capitalize">{{
                                        log.context
                                    }}</span>
                                </div>
                            </template>
                            <div
                                class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                            >
                                <small class="capitalize text-left">{{
                                    $t("due")
                                }}</small>
                                <span>{{
                                    moment(log.date).format("LLL")
                                }}</span>
                            </div>
                            <div
                                class="p-2 flex items-center justify-center rounded-br-xl"
                            >
                                <span class="la la-circle"></span>
                            </div>
                        </div>
                    </div>
                </template>
            </template>
        </div>
    </div>
</template>
