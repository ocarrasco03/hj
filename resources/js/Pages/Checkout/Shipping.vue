<script setup>
import { ref } from "vue";
import { Head, Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import axios from "axios";
import { trans } from "laravel-vue-i18n";

const props = defineProps({
    countries: Object,
    items: Object,
    tax: Number,
    subtotal: Number,
    discount: {
        type: Number,
        default: 0
    },
    total: Number,
});

const states = ref([]);

const form = useForm({
    name: usePage().props.value.auth.user.name,
    email: usePage().props.value.auth.user.email,
    phone: usePage().props.value.auth.user.phone,
    zip_code: null,
    neighborhood: null,
    company: null,
    country: "",
    state: "",
    city: null,
    address: "",
    notes: "",
    items: props.items,
    shipping: "",
    discount: "",
    subtotal: props.subtotal,
    tax: props.tax,
    total: props.total,
});

const submit = () => {
    form.post(route('cart.process.order'), {
        onError: (err) => {
            console.error(err);
        }
    });
}

const autocomplete = (input, array, model) => {
    let currentFocus;
    input.addEventListener("input", function (event) {
        let a,
            b,
            i,
            val = this.value;
        closeAllLists();
        if (!val) return false;
        currentFocus = -1;
        a = document.createElement("div");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        this.parentNode.appendChild(a);
        for (i = 0; i < array.length; i++) {
            if (
                array[i].substr(0, val.length).toUpperCase() ===
                val.toUpperCase()
            ) {
                b = document.createElement("div");
                b.innerHTML = `<strong>${array[i].substr(
                    0,
                    val.length
                )}</strong>`;
                b.innerHTML += array[i].substr(val.length);
                b.innerHTML += `<input type="hidden" value="${array[i]}" />`;
                b.addEventListener("click", function (event) {
                    input.value = this.getElementsByTagName("input")[0].value;
                    for (const property in form) {
                        console.log(`${property}: ${form[property]}`);
                        if (property === model) {
                            form[model] = this.getElementsByTagName("input")[0].value;
                        }
                    }
                    closeAllLists();
                });
                a.appendChild(b);
            }
        }
    });
    input.addEventListener("keydown", function (event) {
        let x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        switch (event.keyCode) {
            case 40:
                currentFocus++;
                addActive(x);
                break;
            case 38:
                currentFocus--;
                addActive(x);
                break;
            case 13:
                event.preventDefault();
                if (currentFocus > -1) {
                    if (x) x[currentFocus].click();
                }
                break;
        }
    });

    const addActive = (x) => {
        if (!x) return false;
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = x.length - 1;
        x[currentFocus].classList.add("autocomplete-active");
    };

    const removeActive = (x) => {
        for (let i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    };

    const closeAllLists = (element) => {
        let x = document.getElementsByClassName("autocomplete-items");
        for (let i = 0; i < x.length; i++) {
            if (element != x[i] && element !== input) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    };

    document.addEventListener("click", function (event) {
        closeAllLists(event.target);
    });
};

const loadCities = (event) => {
    axios
        .get(
            route("api.v2.autocomplete.city", {
                country: form.country,
                state: form.state,
            }),
            {
                params: { query: form.city },
            }
        )
        .then((res) => {
            autocomplete(event.target, res.data, 'city');
        })
        .catch((err) => {
            console.error(err);
        });
};

const loadZipCodes = (event) => {
    axios
        .get(
            route("api.v2.autocomplete.zip.code", {
                country: form.country,
                state: form.state,
                city: form.city
            }),
            {
                params: { query: form.zip_code },
            }
        )
        .then((res) => {
            autocomplete(event.target, res.data, 'zip_code');
        })
        .catch((err) => {
            console.error(err);
        });
};

const loadNeighborhoods = (event) => {
    axios
        .get(
            route("api.v2.autocomplete.neighborhood", {
                zip_code: form.zip_code,
            })
        )
        .then((res) => {
            autocomplete(event.target, res.data, 'neighborhood');
        })
        .catch((err) => {
            console.error(err);
        });
};

const loadStates = () => {
    const prepend = document.getElementById("model-prepend");
    prepend.innerHTML = trans("Loading");
    axios
        .get(route("api.v2.states", { country: form.country }))
        .then((res) => {
            states.value = res.data.data;
            prepend.innerHTML = trans("Select a state");
        })
        .catch((err) => {
            console.error(err);
            prepend.innerHTML = trans("Error");
        });
};
</script>

<template>
    <Head :title="$t('Shipping')" />
    <div class="container py-5">
        <div class="border border-gray-500 shadow-md rounded">
            <div class="bg-black text-primary-500 px-5 py-4">
                <h4>{{ $t("Shipping address") }}</h4>
            </div>
            <div class="pb-10 pt-6 px-10 lg:flex">
                <div class="lg:w-1/2 lg:pr-4">
                    <div>
                        <label for="name" class="label"
                            >{{ $t("Full Name") }}
                            <small class="text-sm text-red-500">*</small></label
                        >
                        <input
                            type="text"
                            name="name"
                            id="name"
                            v-model="form.name"
                            required
                            class="form-control"
                        />
                    </div>
                    <div class="mt-5">
                        <label for="company" class="label">{{
                            $t("Company")
                        }}</label>
                        <input
                            type="text"
                            name="company"
                            id="company"
                            class="form-control"
                            v-model="form.company"
                        />
                    </div>
                    <div class="mt-5">
                        <label for="address_line_1" class="label"
                            >{{ $t("Street & House No.") }}
                            <small class="text-sm text-red-500">*</small></label
                        >
                        <input
                            type="text"
                            name="address_line_1"
                            id="address_line_1"
                            required
                            class="form-control"
                            v-model="form.address"
                        />
                    </div>
                    <div class="mt-5">
                        <label for="country" class="label"
                            >{{ $t("Country") }}
                            <small class="text-sm text-red-500">*</small></label
                        >
                        <select
                            name="country"
                            id="country"
                            class="form-control"
                            required
                            v-model="form.country"
                            @change="loadStates"
                        >
                            <option value="" selected disabled>
                                {{ $t("Select a country") }}
                            </option>
                            <template
                                v-for="(country, key) in countries"
                                :key="key"
                            >
                                <option>{{ country }}</option>
                            </template>
                        </select>
                    </div>
                    <div class="mt-5">
                        <label for="state" class="label"
                            >{{ $t("State") }}
                            <small class="text-sm text-red-500">*</small></label
                        >
                        <select
                            name="country"
                            id="country"
                            class="form-control"
                            required
                            v-model="form.state"
                            :disabled="states.length < 1"
                        >
                            <option value="" selected disabled id="model-prepend">
                                {{ $t("Select a state") }}
                            </option>
                            <template v-for="(state, key) in states" :key="key">
                                <option>{{ state.state }}</option>
                            </template>
                        </select>
                    </div>
                    <div class="mt-5">
                        <label for="city" class="label"
                            >{{ $t("City") }}
                            <small class="text-sm text-red-500">*</small></label
                        >
                        <input
                            type="text"
                            name="city"
                            id="city"
                            class="form-control"
                            v-model="form.city"
                            autocomplete="off"
                            @keyup="loadCities"
                        />
                    </div>
                    <div class="mt-5">
                        <label for="zip_code" class="label"
                            >{{ $t("Zip Code") }}
                            <small class="text-sm text-red-500">*</small></label
                        >
                        <input
                            type="text"
                            name="zip_code"
                            id="zip_code"
                            class="form-control"
                            autocomplete="off"
                            v-model="form.zip_code"
                            @keyup="loadZipCodes"
                        />
                    </div>
                    <div class="mt-5">
                        <label for="neighborhood" class="label"
                            >{{ $t("Neighborhood") }}
                            <small class="text-sm text-red-500">*</small></label
                        >
                        <input
                            type="text"
                            name="neighborhood"
                            id="neighborhood"
                            class="form-control"
                            autocomplete="off"
                            required
                            v-model="form.neighborhood"
                            @keyup="loadNeighborhoods"
                        />
                    </div>
                    <div class="mt-5">
                        <label for="phone" class="label">{{ $t("Phone") }}
                            <small class="text-sm text-red-500">*</small></label
                        >
                        <input
                            type="tel"
                            name="phone"
                            id="phone"
                            class="form-control"
                            v-model="form.phone"
                        />
                    </div>
                    <div class="mt-5">
                        <label for="email" class="label"
                            >{{ $t("E-Mail Address") }}
                            <small class="text-sm text-red-500">*</small></label
                        >
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            v-model="form.email"
                        />
                    </div>
                    <hr class="divider mt-5" />
                    <h4 class="font-medium text-lg mt-5">
                        {{ $t("Aditional Information") }}
                    </h4>
                    <div>
                        <label for="notes" class="label">{{
                            $t("Order Notes")
                        }}</label>
                        <textarea
                            name="notes"
                            id="notes"
                            rows="10"
                            class="form-control resize-none"
                            v-model="form.notes"
                        ></textarea>
                    </div>
                </div>
                <div class="lg:w-1/2 w_ticket lg:h-full">
                    <div class="heading">
                        <h4>{{ $t("Your Order") }}</h4>
                    </div>
                    <div class="detail">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th
                                        class="text-left uppercase text-lg text-secondary-500"
                                    >
                                        {{ $t("Product") }}
                                    </th>
                                    <th
                                        class="w-px uppercase text-lg text-secondary-500"
                                    >
                                        {{ $t("Total") }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, key) in props.items" :key="key">
                                    <td>
                                        <div>
                                            <span class="font-bold">{{ item.qty }}x</span>
                                            <p>{{ item.name }}</p>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        {{ $formatPrice(item.total) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="uppercase font-bold">
                                        {{ $t("Subtotal") }}
                                    </td>
                                    <td class="text-red-500 text-right">
                                        {{ $formatPrice(form.subtotal) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="uppercase font-bold">
                                        {{ $t("Tax") }}
                                    </td>
                                    <td class="text-red-500 text-right">
                                        {{ $formatPrice(form.tax) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="uppercase font-bold">
                                        {{ $t("Shipping") }}
                                    </td>
                                    <td class="text-red-500 text-right">
                                        {{ $formatPrice(0) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="uppercase font-bold text-lg">
                                        {{ $t("Total") }}
                                    </td>
                                    <td class="text-red-500 text-right">
                                        {{ $formatPrice(form.total) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5">
                        <p class="text-justify">
                            Tus datos personales se usarán para procesar tu
                            pedido, ofrecerte soporte y atención sobre tu
                            actividad en nuestro sitio y para los propósitos
                            descritos en nuestro
                            <Link
                                class="font-bold text-secondary-500"
                                :href="route('policy')"
                                v-text="'aviso de privacidad'"
                            />.
                        </p>
                    </div>
                    <div class="mt-5 flex">
                        <button class="btn btn-primary flex-1" @click="submit">
                            {{ $t("Select payment method") }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
