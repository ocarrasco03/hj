<template>
    <Head title="Mis Direcciones" />
    <div class="container py-7 lg:flex">
        <ProfileMenu class="lg:w-1/4" />
        <div class="lg:w-3/4 lg:ml-4 lg:mt-0 mt-4">
            <ValidationErrors class="mb-4" />

            <form
                @submit.prevent="submit"
                v-if="add"
                class="transition ease-all duration-75 mt-4"
            >
                <div class="lg:flex lg:space-x-4">
                    <div class="flex-1">
                        <label for="street">{{ $t("Street") }}</label>
                        <input
                            id="street"
                            type="text"
                            class="form-control"
                            v-model="form.street"
                            required
                            autocomplete="street"
                        />
                    </div>
                    <div class="flex flex-1 mt-4 lg:mt-0 space-x-4">
                        <div class="mt-4 lg:mt-0 flex-1">
                            <label for="lastname">{{
                                $t("Outdoor Number")
                            }}</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="form.ext_no"
                                required
                                autocomplete="ext_no"
                            />
                        </div>
                        <div class="mt-4 lg:mt-0 flex-1">
                            <label for="int_no"
                                >{{ $t("Inside Number") }}
                                <small>(opcional)</small></label
                            >
                            <input
                                type="text"
                                class="form-control"
                                v-model="form.int_no"
                                autocomplete="int_no"
                            />
                        </div>
                    </div>
                </div>
                <div class="lg:flex lg:space-x-4 mt-4">
                    <div class="flex-1">
                        <label for="country">{{ $t("Country") }}</label>
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
                    <div class="mt-4 lg:mt-0 flex-1">
                        <label for="phone">{{ $t("State") }}</label>
                        <select
                            name="state"
                            id="state"
                            class="form-control"
                            required
                            v-model="form.state"
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
                            <template v-for="(state, key) in states" :key="key">
                                <option>{{ state.state }}</option>
                            </template>
                        </select>
                    </div>
                    <div class="mt-4 lg:mt-0 flex-1">
                        <label for="phone">{{ $t("City") }}</label>
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
                            v-model="form.city"
                        >
                        </vue3-simple-typeahead>
                    </div>
                </div>
                <div class="lg:flex lg:space-x-4 mt-4">
                    <div class="mt-4 lg:mt-0 flex-1">
                        <label for="zip_code">{{ $t("Zip Code") }}</label>
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
                        >
                        </vue3-simple-typeahead>
                    </div>
                    <div class="mt-4 lg:mt-0 flex-1">
                        <label for="neighborhood">{{
                            $t("Neighborhood")
                        }}</label>
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
                            v-model="form.neighborhood"
                        >
                        </vue3-simple-typeahead>
                    </div>
                </div>
                <div class="lg:flex lg:space-x-4 mt-4">
                    <div class="mt-4 lg:mt-0 flex-1">
                        <label for="notes">{{
                            $t(
                                "Indicaciones adicionales para las entregas en esta dirección"
                            )
                        }}</label>
                        <textarea
                            name="notes"
                            id="notes"
                            rows="5"
                            class="form-control resize-none"
                            v-model="form.notes"
                        ></textarea>
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

            <div class="card rounded-sm divide-y border" v-if="!add">
                <div class="bg-secondary-500 text-primary-500 px-5 py-4">
                    <h5>{{ $t("Addresses") }}</h5>
                </div>
                <div
                    class="py-2 px-4 flex items-center justify-between"
                    v-for="(address, key) in addresses.data"
                    :key="key"
                >
                    <div>
                        <div class="flex space-x-2 items-center">
                            <span class="text-base"
                                >{{ address.street }} {{ address.exterior_no }}
                                {{
                                    address.interior_no
                                        ? `int ${address.interior_no}`
                                        : ""
                                }}</span
                            >
                            <span
                                v-if="
                                    address.type === 'both' ||
                                    address.type === 'shipping'
                                "
                                class="badge badge-outlined text-xs uppercase badge-success"
                                >{{ $t("Shipping") }}</span
                            >
                            <span
                                v-if="
                                    address.type === 'both' ||
                                    address.type === 'billing'
                                "
                                class="badge badge-outlined text-xs uppercase badge-secondary"
                                >{{ $t("Billing") }}</span
                            >
                        </div>
                        <p class="text-xs text-gray-700">
                            C.P. {{ address.zip_code }}, {{ address.city }},
                            {{ address.state }}, {{ address.country }}
                        </p>
                        <p class="text-xs text-gray-700">
                            {{ address.indications }}
                        </p>
                    </div>
                    <Dropdown v-if="address.type !== 'both'">
                        <template #trigger>
                            <span
                                class="btn btn-icon rounded-full text-secondary-500 hover:text-secondary-500 hover:bg-gray-100 la la-ellipsis-v"
                            ></span>
                        </template>
                        <template #content>
                            <div class="divide-y">
                                <!-- <DropdownLink class="hover:text-secondary-500"
                                    >Editar</DropdownLink
                                > -->
                                <DropdownLink
                                    v-if="
                                        address.type !== 'both' &&
                                        address.type !== 'shipping'
                                    "
                                    :href="
                                        route('profile.address.set', {
                                            id: address.id,
                                            type: 'shipping',
                                        })
                                    "
                                    class="hover:text-secondary-500"
                                    >Usar para Envios</DropdownLink
                                >
                                <DropdownLink
                                    v-if="
                                        address.type !== 'both' &&
                                        address.type !== 'billing'
                                    "
                                    :href="
                                        route('profile.address.set', {
                                            id: address.id,
                                        })
                                    "
                                    class="hover:text-secondary-500"
                                    >Usar para Facturación</DropdownLink
                                >
                            </div>
                        </template>
                    </Dropdown>
                    <!-- <button class="btn btn-icon rounded-full text-secondary-500 hover:text-secondary-500 hover:bg-gray-100"><span class="la la-ellipsis-v"></span></button> -->
                </div>
                <div class="flex">
                    <button
                        @click="add = !add"
                        class="flex-1 rounded-b-sm font-medium text-secondary-500 inline-flex items-center justify-between px-4 py-2 border border-transparent hover:text-yellow-500 hover:bg-secondary-500 transition ease-linear duration-100"
                    >
                        {{ $t("Add new address") }}
                        <span class="la la-angle-right mr-2"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { Head, Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import { trans } from "laravel-vue-i18n";
import ValidationErrors from "@/Components/ValidationErrors";
import SimpleTypeahead from "vue3-simple-typeahead";
import Dropdown from "@/Components/Dropdown";
import DropdownLink from "@/Components/DropdownLink";
import ProfileMenu from "@/Pages/Profile/ProfileMenu";

const props = defineProps({
    addresses: Object,
    countries: Object,
});

const add = ref(false);
const editable = ref(false);
const states = ref([]);
const cities = ref([]);
const zipCodes = ref([]);
const neighborhoods = ref([]);

const form = useForm({
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
    form.post(route("profile.address.store"), {
        preserveScroll: true,
        onFinish: () => {
            form.reset();
            add.value = false;
        },
    });
};

const cancel = () => {
    form.reset();
    add.value = false;
};

const cityEventHandler = (event) => {
    form.city = event.input;
};

const cityBlurEventHandler = (event) => {
    form.city = event.input;
    loadZipCodes(event.input);
};

const citySelectItemEventHandler = (item) => {
    form.city = item;
};

const zipCodeEventHandler = (event) => {
    form.zip_code = event.input;
};

const zipCodeBlurEventHandler = (event) => {
    loadNeighborhoods(event.input);
    form.zip_code = event.input;
};

const zipCodeSelectItemEventHandler = (item) => {
    form.zip_code = item;
};

const neighborhoodEventHandler = (event) => {
    form.neighborhood = event.input;
};

const neighborhoodSelectItemEventHandler = (item) => {
    form.neighborhood = item;
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

const loadCities = () => {
    axios
        .get(
            route("api.v2.autocomplete.city", {
                country: form.country,
                state: form.state,
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
                country: form.country,
                state: form.state,
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
</script>

<style scoped>
/*
  Enter and leave animations can use different
  durations and timing functions.
*/
.slide-enter-active {
    transition: all 0.3s ease-out;
}

.slide-leave-active {
    transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-enter-from,
.slide-leave-to {
    transform: translateX(10px);
    opacity: 0;
}
</style>
