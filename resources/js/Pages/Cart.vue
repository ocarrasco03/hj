<script setup>
import { Head, Link, usePage } from "@inertiajs/inertia-vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import axios from "axios";
import nprogress from "nprogress";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

defineProps({
    cart: Object,
    subtotal: String,
    tax: String,
    discount: String,
    total: String,
    count: Number,
});
</script>

<script>
export default {
    data: () => ({
        propCart: {
            cart: usePage().props.value.cart,
            subtotal: usePage().props.value.subtotal,
            discount: usePage().props.value.discount,
            tax: usePage().props.value.tax,
            total: usePage().props.value.total,
            count: usePage().props.value.count,
        },
    }),
    props: {
        cart: Object,
        subtotal: String,
        tax: String,
        discount: String,
        total: String,
        count: Number,
    },
    methods: {
        add(item) {
            nprogress.start();
            axios
                .put(route("cart.update"), {
                    id: item.rowId,
                    qty: item.qty + 1,
                })
                .then((res) => {
                    item.qty++;
                    item.subtotal = res.data.success.cart.item.subtotal;
                    item.total = res.data.success.cart.item.total;
                    this.propCart.subtotal = res.data.success.cart.subtotal;
                    this.propCart.discount = res.data.success.cart.discount;
                    this.propCart.tax = res.data.success.cart.tax;
                    this.propCart.total = res.data.success.cart.total;
                    nprogress.done();
                })
                .catch((err) => {
                    console.error(err);
                    nprogress.done();
                });
        },
        reduce(item, index) {
            nprogress.start();
            axios
                .put(route("cart.update"), {
                    id: item.rowId,
                    qty: item.qty - 1,
                })
                .then((res) => {
                    item.qty--;
                    if (item.qty === 0) {
                        delete this.propCart.cart[index];
                        this.propCart.count = res.data.success.cart.count;
                    }
                    item.subtotal = res.data.success.cart.item.subtotal;
                    item.total = res.data.success.cart.item.total;
                    this.propCart.subtotal = res.data.success.cart.subtotal;
                    this.propCart.discount = res.data.success.cart.discount;
                    this.propCart.tax = res.data.success.cart.tax;
                    this.propCart.total = res.data.success.cart.total;
                    nprogress.done();
                })
                .catch((err) => {
                    console.error(err);
                    nprogress.done();
                });
        },
        // remove(id, index) {
        //     nprogress.start();
        //     axios
        //         .delete(route("cart.destroy", { id: id }))
        //         .then((res) => {
        //             this.propCart.subtotal = res.data.success.cart.subtotal;
        //             this.propCart.discount = res.data.success.cart.discount;
        //             this.propCart.tax = res.data.success.cart.tax;
        //             this.propCart.total = res.data.success.cart.total;
        //             delete this.propCart.cart[index];
        //             nprogress.done();
        //         })
        //         .catch((err) => {
        //             console.error(err);
        //             nprogress.done();
        //         });
        // },
    },
};
</script>

<template>
    <Head title="Mi Carrito" />
    <section class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
        <div class="border border-gray-500 shadow-md rounded">
            <div class="bg-black text-primary-500 px-5 py-4">
                <h4>Carrito de Compras</h4>
            </div>
            <div class="pb-10">
                <div class="pl-2 flex flex-col md:flex-row items-start">
                    <table class="flex-1">
                        <tbody>
                            <tr v-for="(item, index) of this.propCart.cart" :key="index">
                                <td class="px-2">
                                    Cantidad:
                                    <div class="flex max-w-xs w-44">
                                        <Input
                                            :value="item.qty"
                                            name="qty"
                                            id="qty"
                                            class="px-4 py-1 text-center mr-1"
                                            readonly
                                        />
                                        <SecondaryButton
                                            class="mr-1"
                                            @click="add(item)"
                                        >
                                            <i class="fas fa-chevron-up"></i>
                                        </SecondaryButton>
                                        <SecondaryButton @click="reduce(item, index)">
                                            <i class="fas fa-chevron-down"></i>
                                        </SecondaryButton>
                                    </div>
                                    <!-- <Link
                                        class="text-center underline text-secondary-500 items-center justify-center"
                                        @click="remove(item.rowId, index)"
                                        >Remover</Link
                                    > -->
                                </td>
                                <td class="px-2 border-x border-gray-500">
                                    <div class="flex items-center space-x-2">
                                        <img
                                            v-if="item.options.image"
                                            :src="item.options.image"
                                            alt="6204"
                                            class="h-24 w-24"
                                        />
                                        <ApplicationLogo
                                            class="h-24 w-24"
                                            :fill="'#000'"
                                            v-else
                                        />

                                        <h4 class="font-bold">
                                            {{ item.name }}
                                        </h4>
                                    </div>
                                </td>
                                <td class="px-4">
                                    Precio:
                                    <h4 class="font-bold">
                                        $ {{ item.total }}
                                    </h4>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div
                        class="border-b border-l border-gray-500 flex-auto shrink-0 divide-y max-w-sm w-full"
                    >
                        <div class="p-2">
                            <span
                                >Hay {{ propCart.count }} articulos en el
                                carrito</span
                            >
                            <div class="flex justify-between">
                                <h5>Subtotal:</h5>
                                <span>$ {{ propCart.subtotal }}</span>
                            </div>
                            <div class="flex justify-between">
                                <h5>Descuento:</h5>
                                <span>$ {{ propCart.discount }}</span>
                            </div>
                        </div>
                        <div class="p-2">
                            <div class="flex justify-between">
                                <h5>IVA:</h5>
                                <span>$ {{ propCart.tax }}</span>
                            </div>
                            <div class="flex justify-between">
                                <h5>Total:</h5>
                                <span>$ {{ propCart.total }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="p-4 flex flex-col space-y-2 md:flex-row md:space-x-2 md:space-y-0"
                >
                    <div
                        class="flex flex-col space-y-2 md:flex-row md:space-x-2 md:space-y-0 flex-1"
                    >
                        <Link
                            :href="route('home')"
                            class="px-4 py-2 bg-secondary-800 border border-transparent text-center font-semibold text-sm text-white capitalize tracking-widest hover:bg-secondary-700 hover:text-yellow-700 active:bg-secondary-900 focus:outline-none focus:border-secondary-900 focus:shadow-outline-secondary transition ease-in-out duration-150 justify-center"
                        >
                            Seguir Comprando
                        </Link>
                        <form
                            @submit.prevent=""
                            class="flex flex-col md:flex-row md:space-x-2 space-y-2 md:space-y-0 flex-1"
                        >
                            <Input
                                name="discount-code"
                                id="discount-code"
                                placeholder="183ERKJSSDS"
                                class="px-4 py-1 text-center flex-auto"
                            />
                            <PrimaryButton
                                class="capitalize font-normal flex-auto bg-gray-700"
                                >Aplicar Cupon</PrimaryButton
                            >
                        </form>
                    </div>
                    <SecondaryButton class="flex flex-1 md:max-w-sm"
                        >Pagar</SecondaryButton
                    >
                </div>
                <div class="flex items-center justify-center">
                    <Link
                        :href="route('terms')"
                        class="font-bold text-secondary-500 hover:text-gray-900 text-sm"
                        >Terminos y Condiciones</Link
                    >
                </div>
            </div>
        </div>
    </section>
</template>
