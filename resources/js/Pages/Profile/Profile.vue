<template>
    <Head title="Mi Perfil" />
    <div class="container py-7 lg:flex">
        <ProfileMenu class="lg:w-1/4" />
        <div class="lg:w-3/4 lg:ml-4 lg:mt-0 mt-4">
            <ValidationErrors class="mb-4" />
            <div class="card rounded-sm border">
                <div class="bg-secondary-500 text-primary-500 px-5 py-4">
                    <h5>{{ $t("My Profile") }}</h5>
                </div>
                <div class="p-5">
                    <div class="lg:flex justify-between">
                        <div class="lg:flex">
                            <div class="flex items-center justify-center">
                                <!-- <img src="" alt=""> -->
                                <div
                                    class="h-24 w-24 rounded-full bg-primary-500 flex items-center justify-center"
                                >
                                    <ApplicationLogo
                                        :fill="'#000'"
                                        class="w-16"
                                    />
                                </div>
                            </div>
                            <div
                                class="lg:ml-5 lg:mt-0 mt-4 flex flex-col justify-center items-center lg:items-start"
                            >
                                <h5 class="text-lg font-bold">
                                    {{ user.data.firstname }}
                                </h5>
                                <h5 class="text-lg font-bold">
                                    {{ user.data.lastname }}
                                </h5>
                                <small>{{ user.data.email }}</small>
                                <small>{{ user.data.phone }}</small>
                                <small
                                    @click="editable = !editable"
                                    class="text-secondary-500 hover:underline cursor-pointer mt-1"
                                    >{{ $t("Edit") }}</small
                                >
                            </div>
                        </div>
                        <div class="lg:flex">
                            <div class="lg:ml-4 lg:mt-0 mt-4">
                                <h5>{{ $t("Billing Address") }}</h5>
                                <address v-if="user.data.addresses.billing">
                                    {{ user.data.addresses.billing.street }}
                                    {{
                                        user.data.addresses.billing.exterior_no
                                    }}
                                    {{
                                        user.data.addresses.billing.interior_no
                                            ? `int ${user.data.addresses.billing.interior_no}`
                                            : ""
                                    }}<br />
                                    {{
                                        user.data.addresses.billing
                                            .neighborhood
                                    }}, CP.
                                    {{ user.data.addresses.billing.zip_code
                                    }}<br />
                                    {{ user.data.addresses.billing.city }},
                                    {{ user.data.addresses.billing.state }},
                                    {{ user.data.addresses.billing.country }}
                                </address>
                            </div>
                            <div class="lg:ml-4 lg:mt-0 mt-4">
                                <h5>{{ $t("Shipping Address") }}</h5>
                                <address v-if="user.data.addresses.shipping">
                                    {{ user.data.addresses.shipping.street }}
                                    {{
                                        user.data.addresses.shipping.exterior_no
                                    }}
                                    {{
                                        user.data.addresses.shipping.interior_no
                                            ? `int ${user.data.addresses.shipping.interior_no}`
                                            : ""
                                    }}<br />
                                    {{
                                        user.data.addresses.shipping
                                            .neighborhood
                                    }}, CP.
                                    {{ user.data.addresses.shipping.zip_code
                                    }}<br />
                                    {{ user.data.addresses.shipping.city }},
                                    {{ user.data.addresses.shipping.state }},
                                    {{ user.data.addresses.shipping.country }}
                                </address>
                            </div>
                        </div>
                    </div>
                    <form
                        @submit.prevent="submit"
                        v-if="editable"
                        class="transition ease-all duration-75 mt-4"
                    >
                        <div class="lg:flex lg:space-x-4">
                            <div class="flex-1">
                                <label for="firstname">{{
                                    $t("First names")
                                }}</label>
                                <input
                                    type="text"
                                    class="border-gray-500 border-2 focus:ring-0 rounded shadow-sm mt-1 block w-full"
                                    v-model="form.firstname"
                                    required
                                    autocomplete="firstname"
                                />
                            </div>
                            <div class="mt-4 lg:mt-0 flex-1">
                                <label for="lastname">{{
                                    $t("Last names")
                                }}</label>
                                <input
                                    type="text"
                                    class="border-gray-500 border-2 focus:ring-0 rounded shadow-sm mt-1 block w-full"
                                    v-model="form.lastname"
                                    required
                                    autocomplete="lastname"
                                />
                            </div>
                        </div>
                        <div class="lg:flex lg:space-x-4 mt-4">
                            <div class="flex-1">
                                <label for="email">{{
                                    $t("E-Mail Address")
                                }}</label>
                                <input
                                    type="email"
                                    class="border-gray-500 border-2 focus:ring-0 rounded shadow-sm mt-1 block w-full"
                                    v-model="form.email"
                                    required
                                    autocomplete="email"
                                />
                            </div>
                            <div class="mt-4 lg:mt-0 flex-1">
                                <label for="phone">{{ $t("Phone") }}</label>
                                <input
                                    type="text"
                                    class="border-gray-500 border-2 focus:ring-0 rounded shadow-sm mt-1 block w-full"
                                    v-model="form.phone"
                                    v-maska="'+52 (###) ### ####'"
                                    required
                                    autocomplete="phone"
                                />
                            </div>
                        </div>
                        <div class="mt-4 flex items-center justify-end">
                            <button
                                type="submit"
                                class="btn btn-primary disabled:text-secondary-500"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing || !form.isDirty"
                            >
                                {{ $t("Save") }}
                            </button>
                            <button
                                type="button"
                                @click="cancel"
                                class="btn btn-danger disabled:text-secondary-500 ml-4 capitalize"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                {{ $t("cancel") }}
                            </button>
                        </div>
                    </form>
                    <div class="mt-4">
                        <h5>{{ $t("Recent Orders") }}</h5>
                        <table
                            class="table table-auto w-full table-hoverable border-collapse mt-2"
                        >
                            <thead class="bg-secondary-500">
                                <tr>
                                    <th>Folio</th>
                                    <th>Status</th>
                                    <th class="w-px hidden md:table-cell">
                                        Descuento
                                    </th>
                                    <th class="w-px hidden md:table-cell">
                                        Impuestos
                                    </th>
                                    <th class="w-px">Total</th>
                                    <th class="w-px hidden md:table-cell"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(order, key) in orders.data"
                                    :key="key"
                                >
                                    <td>{{ order.id }}</td>
                                    <td>
                                        <span
                                            class="badge badge-outlined uppercase"
                                            :class="{
                                                'badge-admin':
                                                    order.status.level === 1,
                                                'badge-success':
                                                    order.status.level === 2,
                                                'badge-danger':
                                                    order.status.level === 3,
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
                                                    <DropdownLink class="hover:text-secondary-500">
                                                        {{ $t('Show') }}
                                                    </DropdownLink>
                                                    <DropdownLink class="hover:text-secondary-500" v-if="order.status.prefix === 'PAYMENT_ERROR' || order.status.prefix === 'AWAITING_CHEQUE_PAYMENT'">
                                                        {{ $t('Pay') }}
                                                    </DropdownLink>
                                                    <DropdownLink class="hover:text-secondary-500" v-if="order.status.prefix === 'PAYMENT_ACCEPTED' || order.status.prefix === 'PREPARATION_IN_PROGRESS' || order.status.prefix === 'SHIPPED' || order.status.prefix === 'DELIVERED'">
                                                        {{ $t('Refound') }}
                                                    </DropdownLink>
                                                    <DropdownLink class="hover:text-secondary-500 capitalize" :href="route('checkout.cancel', {order: order.id})" v-if="order.status.prefix === 'PAYMENT_ERROR' || order.status.prefix === 'AWAITING_CHEQUE_PAYMENT'">
                                                        {{ $t('cancel') }}
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
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { Head, Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import ValidationErrors from "@/Components/ValidationErrors";
import ApplicationLogo from "@/Components/ApplicationLogo";
import ProfileMenu from "@/Pages/Profile/ProfileMenu";
import Dropdown from "@/Components/Dropdown";
import DropdownLink from "@/Components/DropdownLink";

const props = defineProps({
    orders: Object,
    user: Object,
});

const editable = ref(false);

const form = useForm({
    firstname: props.user.data.firstname,
    lastname: props.user.data.lastname,
    email: props.user.data.email,
    phone: props.user.data.phone,
});

const submit = () => {
    form.put(route("profile.update"), {
        onFinish: () => {
            editable.value = false;
        },
    });
};

const cancel = () => {
    form.reset();
    editable.value = false;
};
</script>
