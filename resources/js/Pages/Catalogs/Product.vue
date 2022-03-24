<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/Button.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Input from "@/Components/Input.vue";
import Tabs from "@/Components/Tabs.vue";
import Tab from "@/Components/Tab.vue";
import axios from "axios";
import nprogress from "nprogress";
import { ref } from "vue";

defineProps({
    product: Object,
    rate: String,
});

const stock = usePage().props.value.product.stock;

const form = useForm({
    id: usePage().props.value.product.id,
    name:
        usePage().props.value.product.sku +
        " " +
        usePage().props.value.product.name,
    qty: 1,
    price: usePage().props.value.product.price_wo_tax,
    options: {
        image: "https://www.hjautopartes.com.mx/storage/uploads/2021-05-18/images/SC-739(0)_1621399447.jpg",
    },
});

const add = () => (form.qty < stock ? form.qty++ : null);
const reduce = () => (form.qty > 1 ? form.qty-- : null);
const fbShare = () => {
    FB.ui(
        {
            method: "feed",
            link: "https://www.hjautopartes.com.mx/producto/653/2609-soporte-para-motor/",
        },
        function (response) {}
    );
};

const addToCart = () =>
    form.post(route("cart.store"), {
        preserveScroll: true,
        onSuccess: () => {
            form.qty = 1;
        },
    });

let previousImage = "";

window.onload = () => {
    if (usePage().props.value.product.files.length > 0) {
        previousImage = document.getElementById("main-image").src;
    }
};

const formatedDate = (date) => {
    const day = new Date().getDay();
    const month = new Date().getMonth();
    const year = new Date().getFullYear();

    const months = [
        "enero",
        "febrero",
        "marzo",
        "abril",
        "mayo",
        "junio",
        "julio",
        "agosto",
        "septiembre",
        "octubre",
        "noviembre",
        "diciembre",
    ];

    return day + " de " + months[month] + " de " + year;
};

const eventChange = (event) => {
    let target = document.getElementById("main-image");
    switch (event.type) {
        case "mouseover":
            target.src = event.target.src;
            break;
        case "mouseleave":
            target.src = previousImage;
            break;
        default:
            target.src = event.target.src;
            previousImage = event.target.src;
            break;
    }
};
</script>

<template>
    <Head :title="product.name" />
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col md:flex-row space-x-3">
            <div class="preview shrink-0">
                <img
                    v-if="product.files.length > 0"
                    id="main-image"
                    src="https://www.hjautopartes.com.mx/storage/uploads/2021-05-18/images/SC-739(0)_1621399447.jpg"
                    alt=""
                    srcset=""
                    height="450"
                    width="500"
                />
                <ApplicationLogo
                    class="block h-full w-96 mx-auto"
                    :fill="'#000'"
                    v-else
                />
                <div class="flex flex-row flex-wrap">
                    <template
                        v-for="(file, key, index) in product.files"
                        :key="index"
                    >
                        <img
                            data-toggle="preview"
                            :src="file.path"
                            :alt="file.name"
                            srcset=""
                            height="95"
                            width="95"
                            @click="eventChange"
                            @mouseover="eventChange"
                            @mouseleave="eventChange"
                        />
                    </template>
                </div>
            </div>
            <div class="detail mx-auto flex flex-col px-2 max-w-sm">
                <h2>{{ product.name }}</h2>
                <h4 class="text-gray-500">SKU: {{ product.sku }}</h4>
                <div id="rate" class="flex flex-row space-x-1 mt-3">
                    <template v-for="(i, key) in 5" :key="key">
                        <i
                            v-if="i <= rate"
                            class="fas fa-star text-yellow-500"
                        ></i>
                        <i v-else class="fal fa-star text-secondary-500"></i>
                    </template>
                </div>
                <h2 class="mt-3">$ {{ product.price }}</h2>
                <div class="mt-3">
                    <ul class="list-inside">
                        <li>Marca: {{ product.brand.name }}</li>
                        <li>
                            OEM:
                            <span v-if="product.notes.oem">{{
                                product.notes.oem
                            }}</span>
                        </li>
                    </ul>
                </div>
                <div class="mt-3 flex flex-col">
                    <h4 class="text-secondary" v-if="product.stock > 0">
                        Disponible: {{ product.stock }}
                    </h4>
                    <h4 class="text-red-500" v-else>Sin Existencia</h4>
                    <div class="flex space-x-1">
                        <Input
                            name="qty"
                            id="qty"
                            v-model="form.qty"
                            class="px-4 py-1 text-center mr-1 w-28 flex-1"
                            readonly
                        />
                        <SecondaryButton @click="add()">
                            <i class="fas fa-chevron-up"></i>
                        </SecondaryButton>
                        <SecondaryButton @click="reduce()">
                            <i class="fas fa-chevron-down"></i>
                        </SecondaryButton>
                    </div>
                    <SecondaryButton class="flex-1 mt-4" @click="addToCart">
                        Agregar al carrito
                    </SecondaryButton>
                </div>

                <div class="share mt-3 flex justify-between">
                    <span class="font-light text-black">Compartir:</span>
                    <div class="social-share flex flex-row space-x-7">
                        <a
                            href="#"
                            class="text-gray-400 hover:text-primary-900"
                            @click="fbShare"
                            ><i class="fab fa-facebook-f"></i
                        ></a>
                        <!-- <a href="#" class="text-gray-400 hover:text-primary-900"
                            ><i class="fab fa-twitter"></i
                        ></a> -->
                        <a
                            :href="`https://wa.me/?text=${route(
                                'product.show',
                                { slug: product.slug }
                            )}`"
                            class="text-gray-400 hover:text-primary-900"
                            target="_blank"
                            ><i class="fab fa-whatsapp"></i
                        ></a>
                        <!-- <a href="#" class="text-gray-400 hover:text-primary-900"
                            ><i class="fab fa-linkedin-in"></i
                        ></a> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col tabs mt-3">
            <Tabs>
                <Tab :title="'Descripcion'" :class="'open'">
                    {{ product.description }}
                </Tab>
                <Tab :title="'Detalles'">
                    <ul class="list-disc list-inside">
                        <li
                            v-for="(note, key, index) in product.notes"
                            :key="index"
                            class="list-item"
                        >
                            {{ key }}: {{ note }}
                        </li>
                    </ul>
                </Tab>
                <Tab :title="'Aplicación'">
                    <div
                        class="relative overflow-x-auto shadow-md sm:rounded-lg max-h-96"
                    >
                        <table
                            class="w-full text-sm text-left text-gray-500 dark:text-gray-400 table-auto"
                        >
                            <thead
                                class="text-xs text-yellow-700 uppercase bg-black"
                            >
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        A&ntilde;o
                                    </th>
                                    <th scope="col" class="px-6 py-3">Marca</th>
                                    <th scope="col" class="px-6 py-3">
                                        Modelo
                                    </th>
                                    <th scope="col" class="px-6 py-3">Motor</th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 uppercase"
                                        v-for="(
                                            note, key, index
                                        ) in product.notes"
                                        :key="index"
                                    >
                                        {{ key }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                >
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"
                                    >
                                        2011
                                    </th>
                                    <td class="px-6 py-4">Nissan</td>
                                    <td class="px-6 py-4">Versa</td>
                                    <td class="px-6 py-4">1.6</td>
                                    <td
                                        class="px-6 py-4 capitalize"
                                        v-for="(
                                            note, key, index
                                        ) in product.notes"
                                        :key="index"
                                    >
                                        {{ note }}
                                    </td>
                                </tr>
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                >
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"
                                    >
                                        2011
                                    </th>
                                    <td class="px-6 py-4">Nissan</td>
                                    <td class="px-6 py-4">Versa</td>
                                    <td class="px-6 py-4">1.6</td>
                                    <td
                                        class="px-6 py-4 capitalize"
                                        v-for="(
                                            note, key, index
                                        ) in product.notes"
                                        :key="index"
                                    >
                                        {{ note }}
                                    </td>
                                </tr>
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                >
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"
                                    >
                                        2011
                                    </th>
                                    <td class="px-6 py-4">Nissan</td>
                                    <td class="px-6 py-4">Versa</td>
                                    <td class="px-6 py-4">1.6</td>
                                    <td
                                        class="px-6 py-4 capitalize"
                                        v-for="(
                                            note, key, index
                                        ) in product.notes"
                                        :key="index"
                                    >
                                        {{ note }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </Tab>
                <Tab :title="'Reseñas'">
                    <div class="w-full overscroll-none">
                        <div
                            class="flex py-2"
                            v-for="(review, key, index) in product.ratings"
                            :key="index"
                        >
                            <div class="px-4">
                                <i class="fal fa-user-circle fa-3x"></i>
                            </div>
                            <div class="flex-1">
                                <div id="rate" class="flex flex-row space-x-1">
                                    <template v-for="(i, key) in 5" :key="key">
                                        <i
                                            v-if="i <= review.rating"
                                            class="fas fa-star text-yellow-500"
                                        ></i>
                                        <i
                                            v-else
                                            class="fal fa-star text-secondary-500"
                                        ></i>
                                    </template>
                                </div>
                                <div>
                                    <small
                                        >Revisado el
                                        {{
                                            formatedDate(review.created_at)
                                        }}</small
                                    >
                                </div>
                                <p>{{ review.comment }}</p>
                            </div>
                        </div>
                    </div>
                </Tab>
            </Tabs>
        </div>
    </div>
</template>
