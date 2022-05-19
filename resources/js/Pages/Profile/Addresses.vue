<template>
    <Head title="Mis Direcciones" />
    <div class="container py-7 lg:flex">
        <nav class="lg:w-1/4">
            <div class="rounded bg-secondary-500 text-yellow-500 py-3">
                <Link
                    :href="route('profile')"
                    class="flex items-center justify-start flex-1 hover:bg-primary-500 hover:text-secondary-500 px-4 py-2 w-full"
                >
                    <span class="la la-user text-2xl leading-none mr-2"></span
                    >{{ $t("My Profile") }}
                </Link>
                <Link
                    :href="route('profile.change.password')"
                    class="flex items-center justify-start flex-1 hover:bg-primary-500 hover:text-secondary-500 px-4 py-2 w-full"
                >
                    <span class="la la-key text-2xl leading-none mr-2"></span
                    >{{ $t("Change Password") }}
                </Link>
                <hr class="border-yellow-100 my-2" />
                <Link
                    :href="route('profile.addresss')"
                    method="get"
                    as="button"
                    class="flex items-center justify-start flex-1 text-secondary-500 bg-primary-500 hover:text-secondary-500 px-4 py-2 w-full"
                >
                    <span
                        class="las la-map-marked-alt text-2xl leading-none mr-2"
                    ></span
                    >{{ $t("Addresses") }}
                </Link>
                <Link
                    class="flex items-center justify-start flex-1 hover:bg-primary-500 hover:text-secondary-500 px-4 py-2 w-full"
                >
                    <span class="la la-dolly text-2xl leading-none mr-2"></span
                    >{{ $t("Orders") }}
                </Link>
                <hr class="border-yellow-100 my-2" />
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="flex items-center justify-start flex-1 hover:bg-primary-500 hover:text-secondary-500 px-4 py-2 w-full"
                >
                    <span
                        class="la la-power-off text-2xl leading-none mr-2"
                    ></span
                    >{{ $t("Logout") }}
                </Link>
            </div>
        </nav>
        <div class="lg:w-3/4 lg:ml-4 lg:mt-0 mt-4">
            <ValidationErrors class="mb-4" />
            <div class="card rounded-sm border border-secondary-500">
                <div
                    class="bg-secondary-500 px-5 py-3 text-yellow-500 border border-secondary-500"
                >
                    {{ $t("Addresses") }}
                </div>
                <div class="p-5">
                    <div class="flex justify-end">
                        <button
                            @click="add = !add"
                            class="btn btn-primary btn-icon md:rounded-full flex-1 md:flex-initial la la-plus"
                        ></button>
                    </div>
                    <transition name="slide">
                        <form
                            @submit.prevent="submit"
                            v-if="add"
                            class="transition ease-all duration-75 mt-4"
                        >
                            <div class="lg:flex lg:space-x-4">
                                <div class="flex-1">
                                    <label for="street">{{
                                        $t("Street")
                                    }}</label>
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
                                        <label for="int_no">{{
                                            $t("Inside Number")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.int_no"
                                            required
                                            autocomplete="int_no"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="lg:flex lg:space-x-4 mt-4">
                                <div class="flex-1">
                                    <label for="country">{{
                                        $t("Country")
                                    }}</label>
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
                                <div class="mt-4 lg:mt-0 flex-1">
                                    <label for="phone">{{ $t("City") }}</label>
                                    <input
                                        type="text"
                                        class="form-control block"
                                        v-model="form.city"
                                        required
                                        @keyup="loadCities"
                                    />
                                </div>
                            </div>
                            <div class="lg:flex lg:space-x-4 mt-4">
                                <div class="mt-4 lg:mt-0 flex-1">
                                    <label for="zip_code">{{
                                        $t("Zip Code")
                                    }}</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="zip_code"
                                        v-model="form.zip_code"
                                        required
                                    />
                                </div>
                                <div class="mt-4 lg:mt-0 flex-1">
                                    <label for="neighborhood">{{
                                        $t("Neighborhood")
                                    }}</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="neighborhood"
                                        v-model="form.neighborhood"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="lg:flex lg:space-x-4 mt-4">
                                <div class="mt-4 lg:mt-0 flex-1">
                                    <label for="notes">{{
                                        $t("Notes")
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
                    </transition>
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

const props = defineProps({
    addresses: Object,
    countries: Object,
});

const add = ref(true);
const editable = ref(false);
const states = ref([]);

const form = useForm({
    street: "",
    ext_no: "",
    int_no: "",
    country: "",
    state: "",
    city: "",
    zip_code: "",
    neighborhood: "",
});

const submit = () => {
    form.put(route("profile.update"), {
        onFinish: () => {
            editable.value = false;
        },
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
            autocomplete(event.target, res.data, "city");
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
                city: form.city,
            }),
            {
                params: { query: form.zip_code },
            }
        )
        .then((res) => {
            autocomplete(event.target, res.data, "zip_code");
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
            }),
            {
                params: { query: form.neighborhood },
            }
        )
        .then((res) => {
            autocomplete(event.target, res.data, "neighborhood");
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
