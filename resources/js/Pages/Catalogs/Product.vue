<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/Button.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Input from "@/Components/Input.vue";
import Tabs from "@/Components/Tabs.vue";
import Tab from "@/Components/Tab.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
import ProductItem from "@/Components/ProductItem.vue";
import axios from "axios";
import nprogress from "nprogress";
import { onMounted, ref } from "vue";

const props = defineProps({
    product: Object,
});

const stock = props.product.data.stock;

const form = useForm({
    id: props.product.data.id,
    name: props.product.data.sku +
        " " +
        props.product.data.name,
    qty: 1,
    price: props.product.data.price_wo_tax,
    options: {
        image: props.product.data.image,
    },
});

const add = () => (form.qty < stock ? form.qty++ : null);
const reduce = () => (form.qty > 1 ? form.qty-- : null);
const fbShare = () => {
    FB.ui(
        {
            method: "feed",
            link: route("product.show", {
                slug: props.product.data.slug,
            }),
        },
        function (response) {
            console.log(response)
        }
    );
};

const addToCart = () =>
    form.post(route("cart.store"), {
        preserveScroll: true,
        onSuccess: () => {
            form.qty = 1;
        },
    });

let previousImage = props.product.data.image;

onMounted(() => {
    if (props.product.data.media.length > 0) {
        previousImage = document.getElementById("main-image").src;
    }
})

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
    <Head :title="product.data.sku + ' ' + product.data.name + ' ' +product.data.brand">
        <meta name="description" :content="`${product.data.sku} ${product.data.name.toLowerCase()} ${product.data.brand}. Compara Precios y Compra ${product.data.name} Online en HJAutopartes.com.mx. Distribuidor Autorizado ${product.data.brand}`" />
    </Head>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col md:flex-row space-x-3 md:justify-around">
            <div class="preview shrink-0">
                <img
                    v-if="product.data.image"
                    id="main-image"
                    :src="product.data.image"
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
                        v-for="(file, key, index) in product.data.media"
                        :key="index"
                    >
                        <img
                            data-toggle="preview"
                            :src="file.original_url"
                            :alt="file.name"
                            srcset=""
                            height="95"
                            width="95"
                            class="hover:cursor-pointer"
                            @click="eventChange"
                            @mouseover="eventChange"
                            @mouseleave="eventChange"
                        />
                    </template>
                </div>
            </div>
            <div class="detail mx-auto flex flex-col px-2 w-full md:max-w-sm mt-4 md:mt-0">
                <h2>{{ product.data.name }}</h2>
                <h4 class="text-gray-500">SKU: {{ product.data.sku }}</h4>
                <div id="rate" class="flex flex-row space-x-1 mt-3">
                    <template v-for="(i, key) in 5" :key="key">
                        <i
                            v-if="i <= product.data.rate"
                            class="fas fa-star text-yellow-500"
                        ></i>
                        <i v-else class="fal fa-star text-secondary-500"></i>
                    </template>
                </div>
                <h2 class="mt-3">{{ $formatPrice(product.data.price) }}</h2>
                <div class="mt-3">
                    <ul class="list-inside">
                        <li>Marca: {{ product.data.brand }}</li>
                        <!-- <li>
                            OEM:
                            <span v-if="product.notes.oem">{{
                                product.notes.oem
                            }}</span>
                        </li> -->
                    </ul>
                </div>
                <div class="mt-3 flex flex-col">
                    <h4 class="text-secondary" v-if="product.data.stock > 0">
                        Disponible: {{ product.data.stock }}
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
                                { slug: product.data.slug }
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
                    {{ product.data.description }}
                </Tab>
                <Tab :title="'Detalles'">
                    <ul class="list-disc list-inside">
                        <li
                            v-for="(note, key, index) in product.data.attributes"
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
                                    <th scope="col" class="w-px px-6 py-3 bg-secondary-500 sticky top-0">A&ntilde;o</th>
                                    <th scope="col" class="px-6 py-3 bg-secondary-500 sticky top-0">Marca</th>
                                    <th scope="col" class="px-6 py-3 bg-secondary-500 sticky top-0">Modelo</th>
                                    <th scope="col" class="w-px px-6 py-3 bg-secondary-500 sticky top-0">Motor</th>
                                    <th scope="col" class="px-6 py-3 bg-secondary-500 sticky top-0">Notas</th>
                                    <!-- <th
                                        scope="col"
                                        class="px-6 py-3 uppercase"
                                        v-for="(
                                            note, key, index
                                        ) in product.data.attributes"
                                        :key="index"
                                    >
                                        {{ key }}
                                    </th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(car, key) in product.data.application" :key="key"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                >
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ car.year }}
                                    </th>
                                    <td class="px-6 py-4">{{ car.make }}</td>
                                    <td class="px-6 py-4">{{ car.model }}</td>
                                    <td class="px-6 py-4">{{ car.engine }}</td>
                                    <td class="px-6 py-4">{{ car.notes }}</td>
                                    <!-- <td
                                        class="px-6 py-4 capitalize"
                                        v-for="(
                                            note, key, index
                                        ) in car.attributes"
                                        :key="index"
                                    >
                                        {{ note }}
                                    </td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </Tab>
                <Tab :title="'Reseñas'">
                    <div class="w-full overscroll-none">
                        <div
                            class="flex py-2"
                            v-for="(review, key, index) in product.data.reviews"
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
    <SectionTitle :primary="true" v-if="product.data.related.length > 0">
        <h4>Productos Relacionados</h4>
    </SectionTitle>
    <div class="container divide-y-2" v-if="product.data.related.length > 0">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 sm:gap-x-2 sm:gap-y-8 place-items-stretch">
            <template v-for="(related, key) in product.data.related" :key="key">
                <ProductItem
                    :rating="5"
                    :description="related.description"
                    :name="related.name"
                    :sku="related.sku"
                    :slug="related.slug"
                    :price="related.price"
                    :image="related.image ? related.image : undefined"
                />
            </template>
        </div>
    </div>
</template>
