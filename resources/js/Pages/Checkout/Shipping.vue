<script setup>
import { ref } from "vue";
import { Head, Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import axios from "axios";
import { trans } from "laravel-vue-i18n";
import SimpleTypeahead from "vue3-simple-typeahead";
import SecondaryButton from "@/Components/SecondaryButton";
import PrimaryButton from "@/Components/Button";
import Input from "@/Components/Input";

const props = defineProps({
    countries: Object,
    items: Object,
    tax: Number,
    subtotal: Number,
    discount: {
        type: Number,
        default: 0,
    },
    shipping: {
        type: Number,
        default: 0,
    },
    total: Number,
    user: Object,
    addresses: Object,
});

const states = ref([]);
const cities = ref([]);
const zipCodes = ref([]);
const neighborhoods = ref([]);
const addAddress = ref(false);

const form = useForm({
    address:
        props.user.data.addresses.shipping !== null
            ? props.user.data.addresses.shipping.id
            : null,
    shipping: 0,
    discount: props.discount,
    subtotal: props.subtotal,
    tax: props.tax,
    total: props.total,
});

const addressForm = useForm({
    street: "",
    ext_no: "",
    int_no: null,
    country: "",
    state: "",
    city: null,
    zip_code: null,
    neighborhood: null,
    notes: null,
});

const submit = () => {
    form.post(route("cart.process.order"), {
        preserveScroll: true,
        preserveState: true,
        onError: (err) => console.log(err),
    });
};

const saveAddress = () => {
    addressForm.post(route("profile.address.store"), {
        preserveScroll: true,
        onFinish: () => {
            addressForm.reset();
            addAddress.value = false;
        },
        onError: (err) => console.log(err),
    });
};

const discountForm = useForm({
    discount_code: "",
});

const applyDiscount = () => {
    discountForm.put(route("cart.discount"), {
        onSuccess: (res) => {
            props.items = res.props.cart;
            form.subtotal = res.props.subtotal;
            form.discount = res.props.discount;
            form.tax = res.props.tax;
            form.total = res.props.total;
        },
        onFinish: () => discountForm.reset(),
    });
};

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
                        if (property === model) {
                            form[model] =
                                this.getElementsByTagName("input")[0].value;
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

const loadCities = () => {
    axios
        .get(
            route("api.v2.autocomplete.city", {
                country: addressForm.country,
                state: addressForm.state,
            })
        )
        .then((res) => {
            cities.value = res.data;
        })
        .catch((err) => {
            console.error(err);
        });
};

const loadZipCodes = (city) => {
    axios
        .get(
            route("api.v2.autocomplete.zip.code", {
                country: addressForm.country,
                state: addressForm.state,
                city: city,
            })
        )
        .then((res) => {
            zipCodes.value = res.data;
        })
        .catch((err) => {
            console.error(err);
        });
};

const loadNeighborhoods = (zip_code) => {
    axios
        .get(
            route("api.v2.autocomplete.neighborhood", {
                zip_code: zip_code,
            })
        )
        .then((res) => {
            neighborhoods.value = res.data;
        })
        .catch((err) => {
            console.error(err);
        });
};

const cityEventHandler = (event) => {
    addressForm.city = event.input;
};

const cityBlurEventHandler = (event) => {
    addressForm.city = event.input;
    loadZipCodes(event.input);
};

const citySelectItemEventHandler = (item) => {
    addressForm.city = item;
};

const zipCodeEventHandler = (event) => {
    addressForm.zip_code = event.input;
};

const zipCodeBlurEventHandler = (event) => {
    loadNeighborhoods(event.input);
    addressForm.zip_code = event.input;
};

const zipCodeSelectItemEventHandler = (item) => {
    addressForm.zip_code = item;
};

const neighborhoodEventHandler = (event) => {
    addressForm.neighborhood = event.input;
};

const neighborhoodSelectItemEventHandler = (item) => {
    addressForm.neighborhood = item;
};

const loadStates = () => {
    const prepend = document.getElementById("model-prepend");
    prepend.innerHTML = trans("Loading");
    axios
        .get(route("api.v2.states", { country: addressForm.country }))
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
                <div class="lg:w-1/2 lg:pr-4 divide-y">
                    <div class="mb-5">
                        <select
                            name="shipping"
                            id="shipping"
                            class="form-control rounded-b-none"
                            v-model="form.address"
                        >
                            <option
                                :value="address.id"
                                v-for="(address, key) in addresses.data"
                                :key="key"
                            >
                                {{
                                    `${address.street} ${address.exterior_no} ${address.neighborhood} ${address.city} ${address.state}`
                                }}
                            </option>
                        </select>
                        <button
                            @click="addAddress = !addAddress"
                            class="form-control border-t-0 rounded-t-none hover:bg-secondary-500 hover:text-primary-500"
                        >
                            {{ $t("Add new address") }}
                        </button>
                    </div>
                    <!-- <hr class="divide mt-5" /> -->
                    <form
                        @submit.prevent="saveAddress"
                        v-if="addAddress"
                        class="my-5"
                    >
                        <div class="mt-5">
                            <label for="address_line_1" class="label"
                                >{{ $t("Street") }}
                                <small class="text-sm text-red-500"
                                    >*</small
                                ></label
                            >
                            <input
                                type="text"
                                name="address_line_1"
                                id="address_line_1"
                                required
                                class="form-control"
                                v-model="addressForm.street"
                            />
                        </div>
                        <div class="mt-5 flex space-x-2">
                            <div class="w-1/2">
                                <label for="ext_no" class="label"
                                    >{{ $t("Outdoor Number") }}
                                    <small class="text-sm text-red-500"
                                        >*</small
                                    ></label
                                >
                                <input
                                    type="text"
                                    name="ext_no"
                                    id="ext_no"
                                    required
                                    class="form-control"
                                    v-model="addressForm.ext_no"
                                />
                            </div>
                            <div class="w-1/2">
                                <label for="int_no" class="label"
                                    >{{ $t("Inside Number") }}
                                    <small>(opcional)</small></label
                                >
                                <input
                                    type="text"
                                    name="int_no"
                                    id="int_no"
                                    class="form-control"
                                    v-model="addressForm.int_no"
                                />
                            </div>
                        </div>
                        <div class="mt-5">
                            <label for="country" class="label"
                                >{{ $t("Country") }}
                                <small class="text-sm text-red-500"
                                    >*</small
                                ></label
                            >
                            <select
                                name="country"
                                id="country"
                                class="form-control"
                                required
                                v-model="addressForm.country"
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
                                <small class="text-sm text-red-500"
                                    >*</small
                                ></label
                            >
                            <select
                                name="state"
                                id="state"
                                class="form-control"
                                required
                                v-model="addressForm.state"
                                :disabled="states.length < 1"
                                @change="loadCities"
                            >
                                <option
                                    value=""
                                    selected
                                    disabled
                                    id="model-prepend"
                                >
                                    {{ $t("Select a state") }}
                                </option>
                                <template
                                    v-for="(state, key) in states"
                                    :key="key"
                                >
                                    <option>{{ state.state }}</option>
                                </template>
                            </select>
                        </div>
                        <div class="mt-5">
                            <label for="city" class="label"
                                >{{ $t("City") }}
                                <small class="text-sm text-red-500"
                                    >*</small
                                ></label
                            >
                            <vue3-simple-typeahead
                                id="cities"
                                :placeholder="$t('City')"
                                :items="cities"
                                :minInputLength="1"
                                @selectItem="citySelectItemEventHandler"
                                @onInput="cityEventHandler"
                                @onBlur="cityBlurEventHandler"
                                @onFocus="cityEventHandler"
                                @input="cityEventHandler"
                                v-model="addressForm.city"
                            >
                            </vue3-simple-typeahead>
                        </div>
                        <div class="mt-5">
                            <label for="zip_code" class="label"
                                >{{ $t("Zip Code") }}
                                <small class="text-sm text-red-500"
                                    >*</small
                                ></label
                            >
                            <vue3-simple-typeahead
                                id="zip_code"
                                :placeholder="$t('Zip Code')"
                                :items="zipCodes"
                                :minInputLength="1"
                                @selectItem="zipCodeSelectItemEventHandler"
                                @onInput="zipCodeEventHandler"
                                @onBlur="zipCodeBlurEventHandler"
                                @onFocus="zipCodeEventHandler"
                                @input="zipCodeEventHandler"
                                v-model="addressForm.zip_code"
                            >
                            </vue3-simple-typeahead>
                        </div>
                        <div class="mt-5">
                            <label for="neighborhood" class="label"
                                >{{ $t("Neighborhood") }}
                                <small class="text-sm text-red-500"
                                    >*</small
                                ></label
                            >
                            <vue3-simple-typeahead
                                id="neighborhood"
                                :placeholder="$t('Neighborhood')"
                                :items="neighborhoods"
                                :minInputLength="1"
                                @selectItem="neighborhoodSelectItemEventHandler"
                                @onInput="neighborhoodEventHandler"
                                @onBlur="neighborhoodEventHandler"
                                @onFocus="neighborhoodEventHandler"
                                @input="neighborhoodEventHandler"
                                v-model="addressForm.neighborhood"
                            >
                            </vue3-simple-typeahead>
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
                                v-model="addressForm.notes"
                            ></textarea>
                        </div>
                        <div class="mt-5 flex">
                            <SecondaryButton class="flex-1">
                                {{ $t("Save") }}
                            </SecondaryButton>
                        </div>
                    </form>
                    <form @submit.prevent="applyDiscount">
                        <div class="mt-5 flex flex-col md:flex-row space-y-2 md:space-x-2 md:space-y-0">
                            <input type="text" class="form-control flex-auto" name="discount_code" id="discount_code" placeholder="183ERKJSSDS" v-model="discountForm.discount_code">
                            <button type="submit" class="capitalize font-normal flex-1 bg-gray-700 btn btn-secondary">Aplicar Cupon</button>
                        </div>
                    </form>
                </div>
                <form
                    @submit.prevent="submit"
                    method="post"
                    class="lg:w-1/2 w_ticket lg:h-full"
                >
                    <div>
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
                                    <tr
                                        v-for="(item, key) in props.items"
                                        :key="key"
                                    >
                                        <td>
                                            <div>
                                                <span class="font-bold"
                                                    >{{ item.qty }}x</span
                                                >
                                                <p>{{ item.name }}</p>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            ${{ item.total }}
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
                                            {{ $t("Discount") }}
                                        </td>
                                        <td class="text-red-500 text-right">
                                            {{ $formatPrice(form.discount) }}
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
                            <SecondaryButton
                                class="flex-1 disabled:opacity-70 disabled:cursor-not-allowed"
                                :disabled="form.address === null"
                            >
                                {{ $t("Select payment method") }}
                            </SecondaryButton>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
