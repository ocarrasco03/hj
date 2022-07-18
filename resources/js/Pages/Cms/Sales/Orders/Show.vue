<script setup>
import { computed, onMounted, ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";
import axios from "axios";
import nprogress from "nprogress";

const props = defineProps({
    order: Object,
});

const confirmDelete = (event) => {
    Swal.fire({
        title: "&iquest;Estás seguro de querer eliminar la orden?",
        icon: "warning",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#145388",
        cancelButtonColor: "#df4759",
        confirmButtonText: "Si, eliminar!",
    }).then((result) => {
        if (result.isConfirmed) {
            nprogress.start();
            axios
                .delete(
                    route("admin.settings.advanced.users.delete", {
                        user: event.target.dataset.id,
                    })
                )
                .then((res) => {
                    if (res.data.success) {
                        props.users.data[
                            event.target.dataset.index
                        ].deleted_at = new Date(Date.now()).toISOString();
                        Swal.fire("Eliminado!", res.data.message, "success");
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops... Ocurrio un error!",
                            text: res.data.message,
                        });
                    }
                    nprogress.done();
                })
                .catch((err) => {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...!",
                        text: "Ocurrio un error crítico si el error persiste contacta al administrador",
                    });
                    nprogress.done();
                });
        }
    });
};

const formatedNumber = (number) => {
    const formatter = Intl.NumberFormat("es-MX", {
        style: "currency",
        currency: "MXN",
        minimumFractionDigits: 2,
    });
    return formatter.format(number);
};

const formatedDate = (
    date,
    options = { year: "numeric", month: "long", day: "numeric" }
) => {
    // const options = { year: "numeric", month: "long", day: "numeric" };
    return new Date(date).toLocaleDateString("es-MX", options);
};
</script>

<script context="module">
import AdminLayout from "@/Layouts/Admin.vue";

export default {
    layout: AdminLayout,
};
</script>

<template>
    <Head title="Pedidos" />

    <!-- Breadcrumb -->
    <section class="breadcrumb lg:flex items-start">
        <div>
            <h1>Pedidos</h1>
            <ul>
                <li>
                    <Link :href="route('admin.dashboard')">
                        <span class="la la-home"></span>
                    </Link>
                </li>
                <li class="divider la la-arrow-right"></li>
                <li><Link v-text="'Ventas'" /></li>
                <li class="divider la la-arrow-right"></li>
                <li>
                    <Link
                        :href="route('admin.sales.orders.index')"
                        v-text="$t('Orders')"
                    />
                </li>
                <li class="divider la la-arrow-right"></li>
                <li>{{ $t("Details") }}</li>
            </ul>
        </div>
    </section>

    <div class="w-full pb-5 px-0 lg:flex space-y-4 lg:space-y-0 lg:space-x-4">
        <div class="lg:w-1/4">
            <div class="card p-5">
                <h3>{{ $t("Actions") }}</h3>
                <div class="mt-5 leading-normal">
                    <Link
                        class="flex items-center text-gray-700 dark:text-gray-500 hover:text-admin"
                        href="#"
                    >
                        <span
                            class="la la-cloud-upload-alt text-gray-600 text-2xl mr-2"
                        ></span>
                        {{ $t("Load Invoice") }}
                    </Link>
                    <Link
                        class="flex items-center text-gray-700 dark:text-gray-500 hover:text-admin"
                        href="#"
                        v-if="
                            order.data.status.prefix !== 'AWAITING_CHEQUE_PAYMENT' &&
                            order.data.status.prefix !== 'PAYMENT_ERROR' &&
                            order.data.status.prefix !== 'CANCELED' &&
                            order.data.status.prefix !== 'REFUND'
                        "
                    >
                        <span
                            class="hj hj-product-return text-gray-600 text-2xl mr-2"
                        ></span>
                        {{ $t("Refund") }}
                    </Link>
                    <Link
                        class="flex items-center text-gray-700 dark:text-gray-500 hover:text-admin"
                        :href="route('checkout.cancel', {order: order.data.id})"
                        v-if="
                            order.data.status.prefix !== 'CANCELED' &&
                            order.data.status.prefix !== 'PAYMENT_ACCEPTED' &&
                            order.data.status.prefix !== 'SHIPPED' &&
                            order.data.status.prefix !== 'REFUND'
                        "
                    >
                        <span
                            class="hj hj-product-return text-gray-600 text-2xl mr-2"
                        ></span>
                        {{ $t("Cancel") }}
                    </Link>
                    <Link
                        class="flex items-center text-gray-700 dark:text-gray-500 hover:text-admin"
                        href="#"
                        v-if="
                            order.data.status.prefix !== 'CANCELED' &&
                            order.data.status.prefix !== 'SHIPPED' &&
                            order.data.status.prefix !== 'REFUND' &&
                            order.data.status.prefix !== 'DELIVERED'
                        "
                    >
                        <span
                            class="la la-shipping-fast text-gray-600 text-2xl mr-2"
                        ></span>
                        {{ $t("Add tracking number") }}
                    </Link>
                    <hr class="my-2" />
                    <Link
                        class="flex items-center text-gray-700 dark:text-gray-500 hover:text-admin"
                        href="#"
                        v-if="order.data.status.prefix !== 'CANCELED'"
                    >
                        <span
                            class="la la-comments text-gray-600 text-2xl mr-2"
                        ></span>
                        {{ $t("Comments") }}
                    </Link>
                    <Link
                        class="flex items-center text-gray-700 dark:text-gray-500 hover:text-admin"
                        href="#"
                    >
                        <span
                            class="la la-comment text-gray-600 text-2xl mr-2"
                        ></span>
                        {{ $t("History") }}
                    </Link>
                    <hr class="my-2" />
                    <Link
                        class="flex items-center text-gray-700 dark:text-gray-500 hover:text-admin"
                        href="#"
                    >
                        <span
                            class="la la-print text-gray-600 text-2xl mr-2"
                        ></span>
                        {{ $t("Print order") }}
                    </Link>
                    <Link
                        class="flex items-center text-gray-700 dark:text-gray-500 hover:text-admin"
                        href="#"
                    >
                        <span
                            class="la la-file-export text-gray-600 text-2xl mr-2"
                        ></span>
                        {{ $t("Export to PDF") }}
                    </Link>
                    <hr class="my-2" />
                    <Link
                        class="flex items-center text-gray-700 dark:text-gray-500 hover:text-admin"
                        @click="back"
                    >
                        <span
                            class="las la-undo text-gray-600 text-2xl mr-2"
                        ></span>
                        {{ $t("Go back") }}
                    </Link>
                </div>
            </div>
        </div>
        <div class="card lg:w-3/4">
            <div class="p-10 flex justify-between">
                <h2 class="uppercase text-4xl text-admin">{{ $t("Order") }}</h2>
            </div>
            <hr />
            <div class="px-10 py-5 flex justify-between">
                <div>
                    <strong>{{ $t("Order") }} No.:</strong> {{ order.data.id }}
                </div>
                <div>
                    <strong>{{ $t("Created") }}:</strong>
                    {{ formatedDate(order.data.created_at) }}
                </div>
            </div>
            <hr />
            <div class="px-10 py-5 flex justify-between">
                <div>
                    <strong>{{ $t("Last updated") }}:</strong>
                    {{ order.data.updated_at }}
                </div>
                <div>
                    <strong class="mr-2">{{ $t("Status") }}:</strong>
                    <span
                        class="badge uppercase"
                        :class="{
                            'badge-admin': order.data.status.level === 1,
                            'badge-success': order.data.status.level === 2,
                            'badge-danger': order.data.status.level === 3,
                        }"
                        >{{ order.data.status.name }}</span
                    >
                </div>
            </div>
            <hr />
            <div class="px-10 py-5 flex justify-between">
                <div>
                    <strong class="mr-2">{{ $t("Payment Method") }}:</strong>
                    <span class="uppercase">
                    {{ order.data.payment_provider }}
                    </span>
                </div>
            </div>
            <hr />
            <div class="px-10 py-5 flex justify-between">
                <div>
                    <h4 class="mb-2 uppercase">{{ $t("Billing Address") }}</h4>
                    <p class="leading-relaxed">
                        {{ order.data.user }}<br />
                        {{ order.data.addresses.billing.street }}
                        {{ order.data.addresses.billing.exterior_no }}
                        {{
                            order.data.addresses.billing.interior_no
                                ? `int ${order.data.addresses.billing.interior_no}`
                                : ""
                        }}<br />
                        {{ order.data.addresses.billing.neighborhood }}, CP. {{ order.data.addresses.billing.zip_code }}<br />
                        {{ order.data.addresses.billing.city }} ,
                        {{ order.data.addresses.billing.state }},
                        {{ order.data.addresses.billing.country }}
                    </p>
                </div>
                <div class="text-right">
                    <h4 class="mb-2 uppercase">{{ $t("Shipping Address") }}</h4>
                    <p class="leading-relaxed">
                        {{ order.data.user }}<br />
                        {{ order.data.addresses.shipping.street }}
                        {{ order.data.addresses.shipping.exterior_no }}
                        {{
                            order.data.addresses.shipping.interior_no
                                ? `int ${order.data.addresses.shipping.interior_no}`
                                : ""
                        }}<br />
                        {{ order.data.addresses.shipping.neighborhood }}, CP. {{ order.data.addresses.shipping.zip_code }}<br />
                        {{ order.data.addresses.shipping.city }} ,
                        {{ order.data.addresses.shipping.state }},
                        {{ order.data.addresses.shipping.country }}
                    </p>
                </div>
            </div>
            <hr />
            <div class="overflow-x-auto p-10 flex">
                <table class="table table-list flex-1 table-admin">
                    <thead>
                        <tr>
                            <th class="text-left uppercase">Concepto</th>
                            <th class="w-fit uppercase">Precio U.</th>
                            <th class="w-px uppercase">QTY</th>
                            <th class="w-fit uppercase">
                                {{ $t("Tax Rate") }}
                            </th>
                            <th class="w-px uppercase">{{ $t("Discount") }}</th>
                            <th class="w-px uppercase">{{ $t("Amount") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(item, index, key) in order.data.items"
                            :key="key"
                        >
                            <td>
                                <h5>{{ item.sku }}</h5>
                                <p>{{ item.name }}</p>
                            </td>
                            <td class="text-center">
                                {{ formatedNumber(item.price / item.quantity) }}
                            </td>
                            <td class="text-center">{{ item.quantity }}</td>
                            <td class="text-center">
                                {{ formatedNumber(item.tax) }}
                            </td>
                            <td class="text-center">
                                {{ formatedNumber(item.amount) }}
                            </td>
                            <td class="text-center font-bold">
                                {{ formatedNumber(item.discount) }}
                            </td>
                        </tr>
                        <tr class="text-right font-bold">
                            <td colspan="6">
                                <table
                                    class="ml-auto table table-borderless table-condensed"
                                >
                                    <tbody>
                                        <tr class="py-1">
                                            <td>Subtotal:</td>
                                            <td>
                                                {{
                                                    formatedNumber(
                                                        order.data.subtotal
                                                    )
                                                }}
                                            </td>
                                        </tr>
                                        <tr class="py-1">
                                            <td>{{ $t("Discount") }}:</td>
                                            <td>
                                                {{
                                                    formatedNumber(
                                                        order.data.discount
                                                    )
                                                }}
                                            </td>
                                        </tr>
                                        <tr class="py-1">
                                            <td>IVA:</td>
                                            <td>
                                                {{
                                                    formatedNumber(
                                                        order.data.tax
                                                    )
                                                }}
                                            </td>
                                        </tr>
                                        <tr class="py-1">
                                            <td>Total:</td>
                                            <td>
                                                {{
                                                    formatedNumber(
                                                        order.data.total
                                                    )
                                                }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- <hr />
            <div class="p-10 text-right">
                <h4 class="uppercase">Total</h4>
                <p class="text-4xl my-4">$45</p>
                <p>Forty Five Dollars Only</p>
            </div> -->
        </div>
    </div>
</template>
