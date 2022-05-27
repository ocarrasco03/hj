<template>
    <Head title="Tickets" />
    <!-- Breadcrumb -->
    <section class="breadcrumb">
        <h1>Terminal</h1>
        <ul>
            <li><a href="#">Soporte</a></li>
            <li class="divider">
                <i class="fal fa-arrow-right"></i>
            </li>
            <li>Tickets</li>
        </ul>
    </section>

    <!-- Card Blank -->
    <div class="lg:flex pb-5">
        <div class="flex-auto space-y-3">
            <div
                class="card w-full divide-y hover:border-admin-500 border border-transparent"
            >
                <div class="py-2 flex items-center justify-center space-y-4 lg:space-y-0 flex-col lg:flex-row">
                    <div class="shrink-0 text-left w-full lg:w-28">
                        <h5 class="ml-1 font-normal">#256465625</h5>
                        <div class="bg-admin text-white w-full text-center uppercase font-bold py-1">Open</div>
                    </div>
                    <div class="flex-auto px-4">
                        <h5>
                            Lorem ipsum, dolor sit amet consectetur adipisicing
                            elit.
                        </h5>
                        <div>
                            <p class="text-gray-500 font-normal text-xs">
                                Lorem ipsum dolor sit amet, consectetur
                                adipisicing elit. Earum possimus inventore
                                deserunt dolorum adipisci cumque ad
                                necessitatibus soluta voluptatum doloribus odio
                                exercitationem, quia odit quae animi explicabo
                                delectus, dolorem repellat.
                            </p>
                        </div>
                    </div>
                    <div class="grow-0 shrink-0 pr-4">
                        <i class="las la-paperclip"></i>
                    </div>
                </div>
                <div
                    class="divide-y lg:divide-y-0 lg:divide-x bg-admin-50 rounded-b-xl lg:flex lg:items-stretch"
                >
                    <div
                        class="p-2 rounded-bl-xl flex items-center justify-center"
                    >
                        <i class="las la-thumbtack"></i>
                    </div>
                    <div
                        class="p-2 flex items-center justify-center"
                    >
                        <span class="lar la-star"></span>
                    </div>
                    <div
                        class="p-2 flex items-center justify-center"
                    >
                        <span class="la la-ellipsis-h"></span>
                    </div>
                    <div
                        class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                    >
                        <small class="capitalize text-left">{{
                            $t("created by")
                        }}</small>
                        <span>Oscar Carrasco</span>
                    </div>
                    <div
                        class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                    >
                        <small class="capitalize text-left">{{
                            $t("assigned to")
                        }}</small>
                        <span>Oscar Carrasco</span>
                    </div>
                    <div
                        class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                    >
                        <small class="capitalize text-left">{{
                            $t("priority")
                        }}</small>
                        <span class="text-danger-500 font-bold">Critical</span>
                    </div>
                    <div
                        class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                    >
                        <small class="capitalize text-left">{{
                            $t("category")
                        }}</small>
                        <span>Support</span>
                    </div>
                    <div
                        class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                    >
                        <small class="capitalize text-left">{{
                            $t("due")
                        }}</small>
                        <span>1 day ago</span>
                    </div>
                    <div
                        class="p-2 flex items-center justify-center rounded-br-xl"
                    >
                        <span class="la la-circle"></span>
                    </div>
                </div>
            </div>
            <div
                class="card w-full divide-y hover:border-admin-500 border border-transparent"
            >
                <div class="py-2 flex items-center justify-center space-y-4 lg:space-y-0 flex-col lg:flex-row">
                    <div class="shrink-0 w-full text-left lg:w-28">
                        <h5 class="ml-1 font-normal">#256465625</h5>
                        <div class="bg-danger-500 text-white w-full text-center uppercase font-bold py-1">Closed</div>
                    </div>
                    <div class="flex-auto px-4">
                        <h5>
                            Lorem ipsum, dolor sit amet consectetur adipisicing
                            elit.
                        </h5>
                        <div>
                            <p class="text-gray-500 font-normal text-xs">
                                Lorem ipsum dolor sit amet, consectetur
                                adipisicing elit. Earum possimus inventore
                                deserunt dolorum adipisci cumque ad
                                necessitatibus soluta voluptatum doloribus odio
                                exercitationem, quia odit quae animi explicabo
                                delectus, dolorem repellat.
                            </p>
                        </div>
                    </div>
                    <div class="grow-0 shrink-0 pr-4">
                        <i class="las la-paperclip"></i>
                    </div>
                </div>
                <div
                    class="divide-y lg:divide-y-0 lg:divide-x bg-admin-50 rounded-b-xl lg:flex lg:items-stretch"
                >
                    <div
                        class="p-2 rounded-bl-xl flex items-center justify-center"
                    >
                        <i class="las la-thumbtack"></i>
                    </div>
                    <div
                        class="p-2 flex items-center justify-center"
                    >
                        <span class="lar la-star"></span>
                    </div>
                    <div
                        class="p-2 flex items-center justify-center"
                    >
                        <span class="la la-ellipsis-h"></span>
                    </div>
                    <div
                        class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                    >
                        <small class="capitalize text-left">{{
                            $t("created by")
                        }}</small>
                        <span>Oscar Carrasco</span>
                    </div>
                    <div
                        class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                    >
                        <small class="capitalize text-left">{{
                            $t("assigned to")
                        }}</small>
                        <span>Oscar Carrasco</span>
                    </div>
                    <div
                        class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                    >
                        <small class="capitalize text-left">{{
                            $t("priority")
                        }}</small>
                        <span>High</span>
                    </div>
                    <div
                        class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                    >
                        <small class="capitalize text-left">{{
                            $t("category")
                        }}</small>
                        <span>Sales</span>
                    </div>
                    <div
                        class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                    >
                        <small class="capitalize text-left">{{
                            $t("due")
                        }}</small>
                        <span>1 day ago</span>
                    </div>
                    <div
                        class="p-2 flex items-center justify-center rounded-br-xl"
                    >
                        <span class="la la-circle text-danger-500"></span>
                    </div>
                </div>
            </div>
            <div
                class="card w-full divide-y hover:border-admin-500 border border-transparent"
            >
                <div class="py-2 flex items-center justify-center space-y-4 lg:space-y-0 flex-col lg:flex-row">
                    <div class="shrink-0 text-left w-full lg:w-28">
                        <h5 class="ml-1 font-normal">#01654</h5>
                        <div class="bg-warning-700 text-white w-full text-center uppercase font-bold py-1">New</div>
                    </div>
                    <div class="flex-auto px-4">
                        <h5>
                            Lorem ipsum, dolor sit amet consectetur adipisicing
                            elit.
                        </h5>
                        <div>
                            <p class="text-gray-500 font-normal text-xs">
                                Lorem ipsum dolor sit amet, consectetur
                                adipisicing elit. Earum possimus inventore
                                deserunt dolorum adipisci cumque ad
                                necessitatibus soluta voluptatum doloribus odio
                                exercitationem, quia odit quae animi explicabo
                                delectus, dolorem repellat.
                            </p>
                        </div>
                    </div>
                    <div class="grow-0 shrink-0 pr-4">
                        <i class="las la-paperclip"></i>
                    </div>
                </div>
                <div
                    class="divide-y lg:divide-y-0 lg:divide-x bg-admin-50 rounded-b-xl lg:flex lg:items-stretch"
                >
                    <div
                        class="p-2 rounded-bl-xl flex items-center justify-center"
                    >
                        <i class="las la-thumbtack"></i>
                    </div>
                    <div
                        class="p-2 flex items-center justify-center"
                    >
                        <span class="lar la-star"></span>
                    </div>
                    <div
                        class="p-2 flex items-center justify-center"
                    >
                        <span class="la la-ellipsis-h"></span>
                    </div>
                    <div
                        class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                    >
                        <small class="capitalize text-left">{{
                            $t("created by")
                        }}</small>
                        <span>Oscar Carrasco</span>
                    </div>
                    <div
                        class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                    >
                        <small class="capitalize text-left">{{
                            $t("assigned to")
                        }}</small>
                        <span>Oscar Carrasco</span>
                    </div>
                    <div
                        class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                    >
                        <small class="capitalize text-left">{{
                            $t("priority")
                        }}</small>
                        <span>High</span>
                    </div>
                    <div
                        class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                    >
                        <small class="capitalize text-left">{{
                            $t("category")
                        }}</small>
                        <span>Sales</span>
                    </div>
                    <div
                        class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                    >
                        <small class="capitalize text-left">{{
                            $t("due")
                        }}</small>
                        <span>1 day ago</span>
                    </div>
                    <div
                        class="p-2 flex items-center justify-center rounded-br-xl"
                    >
                        <span class="la la-circle text-danger-500"></span>
                    </div>
                </div>
            </div>
            <div
                class="card w-full divide-y hover:border-admin-500 border border-transparent"
            >
                <div class="py-2 flex items-center justify-center space-y-4 lg:space-y-0 flex-col lg:flex-row">
                    <div class="shrink-0 text-left w-full lg:w-28">
                        <h5 class="ml-1 font-normal">#256465625</h5>
                        <div class="bg-success-700 text-white w-full text-center uppercase font-bold py-1">On Hold</div>
                    </div>
                    <div class="flex-auto px-4">
                        <h5>
                            Lorem ipsum, dolor sit amet consectetur adipisicing
                            elit.
                        </h5>
                        <div>
                            <p class="text-gray-500 font-normal text-xs">
                                Lorem ipsum dolor sit amet, consectetur
                                adipisicing elit. Earum possimus inventore
                                deserunt dolorum adipisci cumque ad
                                necessitatibus soluta voluptatum doloribus odio
                                exercitationem, quia odit quae animi explicabo
                                delectus, dolorem repellat.
                            </p>
                        </div>
                    </div>
                    <div class="grow-0 shrink-0 pr-4">
                        <i class="las la-paperclip"></i>
                    </div>
                </div>
                <div
                    class="divide-y lg:divide-y-0 lg:divide-x bg-admin-50 rounded-b-xl lg:flex lg:items-stretch"
                >
                    <div
                        class="p-2 rounded-bl-xl flex items-center justify-center"
                    >
                        <i class="las la-thumbtack"></i>
                    </div>
                    <div
                        class="p-2 flex items-center justify-center"
                    >
                        <span class="lar la-star"></span>
                    </div>
                    <div
                        class="p-2 flex items-center justify-center"
                    >
                        <span class="la la-ellipsis-h"></span>
                    </div>
                    <div
                        class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                    >
                        <small class="capitalize text-left">{{
                            $t("created by")
                        }}</small>
                        <span>Oscar Carrasco</span>
                    </div>
                    <div
                        class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                    >
                        <small class="capitalize text-left">{{
                            $t("assigned to")
                        }}</small>
                        <span>Oscar Carrasco</span>
                    </div>
                    <div
                        class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                    >
                        <small class="capitalize text-left">{{
                            $t("priority")
                        }}</small>
                        <span>High</span>
                    </div>
                    <div
                        class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                    >
                        <small class="capitalize text-left">{{
                            $t("category")
                        }}</small>
                        <span>Sales</span>
                    </div>
                    <div
                        class="p-2 flex flex-col items-center lg:items-start justify-start flex-auto text-left"
                    >
                        <small class="capitalize text-left">{{
                            $t("due")
                        }}</small>
                        <span>1 day ago</span>
                    </div>
                    <div
                        class="p-2 flex items-center justify-center rounded-br-xl"
                    >
                        <span class="la la-circle text-danger-500"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head } from "@inertiajs/inertia-vue3";
</script>

<script context="module">
import AdminLayout from "@/Layouts/Admin.vue";

export default {
    layout: AdminLayout,
};
</script>
