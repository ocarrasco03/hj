<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import ProfileMenu from "@/Pages/Profile/ProfileMenu";
import Dropdown from "@/Components/Dropdown";
import DropdownLink from "@/Components/DropdownLink";

const props = defineProps({
    orders: Object,
});
</script>

<template>
    <Head title="Mis Pedidos" />
    <div class="container py-7 lg:flex">
        <ProfileMenu class="lg:w-1/4" />
        <div class="lg:w-3/4 lg:ml-4 lg:mt-0 mt-4">
            <table
                class="table table-auto w-full table-hoverable border-collapse border"
            >
                <thead class="bg-secondary-500">
                    <tr>
                        <th>Folio</th>
                        <th>Status</th>
                        <th class="w-px hidden md:table-cell">Descuento</th>
                        <th class="w-px hidden md:table-cell">Impuestos</th>
                        <th class="w-px">Total</th>
                        <th class="w-px hidden md:table-cell"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(order, key) in orders.data" :key="key">
                        <td>{{ order.id }}</td>
                        <td>
                            <span
                                class="badge badge-outlined uppercase"
                                :class="{
                                    'badge-admin': order.status.level === 1,
                                    'badge-success': order.status.level === 2,
                                    'badge-danger': order.status.level === 3,
                                }"
                                >{{ order.status.name }}</span
                            >
                        </td>
                        <td class="hidden md:table-cell">
                            {{ $formatPrice(order.discount) }}
                        </td>
                        <td class="hidden md:table-cell">
                            {{ $formatPrice(order.tax) }}
                        </td>
                        <td>
                            {{ $formatPrice(order.total) }}
                        </td>
                        <td class="hidden md:table-cell">
                            <Dropdown>
                                <template #trigger>
                                    <span
                                        class="btn btn-icon rounded-full text-secondary-500 hover:text-secondary-500 hover:bg-gray-100 la la-ellipsis-v"
                                    ></span>
                                </template>
                                <template #content>
                                    <div class="divide-y">
                                        <DropdownLink
                                            class="hover:text-secondary-500"
                                        >
                                            {{ $t("Show") }}
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('cart.checkout', {order: order.id})"
                                            class="hover:text-secondary-500"
                                            v-if="
                                                order.status.prefix ===
                                                    'PAYMENT_ERROR' ||
                                                order.status.prefix ===
                                                    'AWAITING_CHEQUE_PAYMENT'
                                            "
                                        >
                                            {{ $t("Pay") }}
                                        </DropdownLink>
                                        <DropdownLink
                                            class="hover:text-secondary-500"
                                            v-if="
                                                order.status.prefix ===
                                                    'PAYMENT_ACCEPTED' ||
                                                order.status.prefix ===
                                                    'PREPARATION_IN_PROGRESS' ||
                                                order.status.prefix ===
                                                    'SHIPPED' ||
                                                order.status.prefix ===
                                                    'DELIVERED'
                                            "
                                        >
                                            {{ $t("Refound") }}
                                        </DropdownLink>
                                        <DropdownLink
                                            class="hover:text-secondary-500 capitalize"
                                            :href="
                                                route('checkout.cancel', {
                                                    order: order.id,
                                                })
                                            "
                                            v-if="
                                                order.status.prefix ===
                                                    'PAYMENT_ERROR' ||
                                                order.status.prefix ===
                                                    'AWAITING_CHEQUE_PAYMENT'
                                            "
                                        >
                                            {{ $t("cancel") }}
                                        </DropdownLink>
                                    </div>
                                </template>
                            </Dropdown>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
