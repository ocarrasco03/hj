<script setup>
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";
import { onMounted, ref, computed } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";

const lastSearch = computed(() => usePage().props.value.search);

const form = useForm({
    year: lastSearch.value.year,
    make: lastSearch.value.make,
    model: lastSearch.value.model,
    engine: lastSearch.value.engine,
    category: lastSearch.value.category,
    subcategory: lastSearch.value.subcategory,
});

const formSearch = useForm({
    query: "",
});

const years = ref([]);
const makes = ref([]);
const models = ref([]);
const engines = ref([]);
const categories = ref([]);
const subcategories = ref([]);

const getYears = () => {
    axios
        .get(route("api.years"))
        .then((res) => {
            years.value = res.data;
        })
        .catch((err) => {
            console.log(err);
        });
};

const getMakes = () => {
    axios
        .get(route("api.makes"))
        .then((res) => {
            makes.value = res.data;
        })
        .catch((err) => {
            console.log(err);
        });
};

const getModels = () => {
    if (form.year && form.make) {
        if (
            form.year !== lastSearch.value.year ||
            form.make !== lastSearch.value.make
        ) {
            form.model = null;
            form.engine = null;
        }
        axios
            .get(route("api.models", { year: form.year, make: form.make }))
            .then((res) => {
                models.value = res.data;
            })
            .catch((err) => {
                console.log(err);
            });
    }
};

const getEngines = () => {
    axios
        .get(route("api.engines"))
        .then((res) => {
            engines.value = res.data;
        })
        .catch((err) => {
            console.log(err);
        });
};

const getCategories = () => {
    axios
        .get(route("api.categories"))
        .then((res) => {
            categories.value = res.data;
        })
        .catch((err) => {
            console.log(err);
        });
};

const getSubcategories = () => {
    if (form.category !== lastSearch.value.category) {
        form.subcategory = null;
    }

    axios
        .get(route("api.subcategories", { parent: form.category }))
        .then((res) => {
            subcategories.value = res.data;
        })
        .catch((err) => {
            console.log(err);
        });
};

onMounted(() => {
    getYears();
    getMakes();
    getCategories();

    if (lastSearch.value.year && lastSearch.value.make) {
        getModels();
    }

    if (lastSearch.value.category) {
        getSubcategories();
    }
});

const searchQuery = () => {
    if (formSearch.query !== "") {
        formSearch.get(route("product.search"));
    }
};

const search = () => {
    form.get(route("product.search"));
};
</script>

<template>
    <div
        class="bg-gray-100 px-4 pb-4 rounded-b sm:max-w-xs w-full z-10 shadow-lg divide-y divide-secondary-500 absolute space-y-6"
    >
        <div id="applicationLookup">
            <div>
                <Label
                    for="year"
                    value="A&ntilde;o"
                    class="font-bold text-black mt-1"
                />
                <select
                    class="mt-1 block w-full text-sm"
                    id="year"
                    name="year"
                    v-model="form.year"
                    @change="getModels"
                >
                    <option :value="null" disabled>
                        Selecciona un A&ntilde;o
                    </option>
                    <template v-for="(year, key) in years" :key="key">
                        <option :value="year.year">{{ year.year }}</option>
                    </template>
                </select>
            </div>
            <div>
                <Label
                    for="make"
                    value="Armadora"
                    class="font-bold text-black mt-1"
                />
                <select
                    class="mt-1 block w-full text-sm"
                    id="make"
                    name="make"
                    v-model="form.make"
                    @change="getModels"
                >
                    <option :value="null" disabled>
                        Selecciona una Armadora
                    </option>
                    <template v-for="(make, key) in makes" :key="key">
                        <option :value="make.name">{{ make.name }}</option>
                    </template>
                </select>
            </div>
            <div>
                <Label
                    for="model"
                    value="Model"
                    class="font-bold text-black mt-1"
                />
                <select
                    class="mt-1 block w-full text-sm"
                    id="model"
                    name="model"
                    :disabled="models.length === 0"
                    v-model="form.model"
                >
                    <option :value="null" disabled>Selecciona un Modelo</option>
                    <template v-for="(model, key) in models" :key="key">
                        <option :value="model.name">{{ model.name }}</option>
                    </template>
                </select>
            </div>
            <div>
                <Label
                    for="engine"
                    value="Motor"
                    class="font-bold text-black mt-1"
                />
                <select
                    class="mt-1 block w-full text-sm"
                    id="engine"
                    name="engine"
                    :disabled="engines.length === 0"
                    v-model="form.engine"
                >
                    <option :value="null" disabled>Selecciona un Motor</option>
                    <template v-for="(engine, key) in engines" :key="key">
                        <option :value="engine">{{ engine }}</option>
                    </template>
                </select>
            </div>
            <div>
                <Label
                    for="category"
                    value="Categoria"
                    class="font-bold text-black mt-1"
                />
                <select
                    class="mt-1 block w-full text-sm"
                    id="category"
                    name="category"
                    v-model="form.category"
                    @change="getSubcategories"
                    :disabled="categories.length === 0"
                >
                    <option :value="null">Todas las lineas</option>
                    <template v-for="(category, key) in categories" :key="key">
                        <option :value="category.name">
                            {{ category.name }}
                        </option>
                    </template>
                </select>
            </div>
            <div>
                <Label
                    for="subcategory"
                    value="Subcategoria"
                    class="font-bold text-black mt-1"
                />
                <select
                    class="mt-1 block w-full text-sm"
                    id="subcategory"
                    name="subcategory"
                    v-model="form.subcategory"
                    :disabled="subcategories.length === 0"
                >
                    <option :value="null">Todas las sublineas</option>
                    <template
                        v-for="(subcategory, key) in subcategories"
                        :key="key"
                    >
                        <option :value="subcategory.name">
                            {{ subcategory.name }}
                        </option>
                    </template>
                </select>
            </div>
            <SecondaryButton
                class="flex space-x-1 mt-2 w-full rounded"
                :disabled="form.processing"
                @click="search"
                @keypress.enter="search"
            >
                <i
                    class="fas fa-spinner-third fa-spin mr-2"
                    v-if="form.processing"
                ></i>
                <span>Buscar</span>
            </SecondaryButton>
        </div>
        <div id="textLookup">
            <div>
                <Input
                    id="query"
                    type="text"
                    class="mt-6 block w-full"
                    v-model="formSearch.query"
                    placeholder="Marca, Modelo, Año, Motor, No. Parte"
                    @keypress.enter="searchQuery"
                    required
                />
                <SecondaryButton
                    class="flex space-x-1 mt-2 w-full rounded"
                    :disabled="formSearch.processing"
                    @click="searchQuery"
                >
                    <i
                        class="fas fa-spinner-third fa-spin mr-2"
                        v-if="formSearch.processing"
                    ></i>
                    <span>Buscar</span>
                </SecondaryButton>
            </div>
        </div>
    </div>
</template>
