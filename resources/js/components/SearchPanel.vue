<script setup>
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import { useForm } from "@inertiajs/inertia-vue3";

const form = useForm({
    year: new Date().getFullYear(),
    make: null,
    model: null,
    engine: null,
});

const formSearch = useForm({
    sku: '',
})

const years = [2022,2021,2020,2019,2018,2017,2016,2015,2014,2013,2012,2011,2010];
const makes = ['Acura', 'Chevrolet', 'Dodge', 'Ford', 'Honda', 'Mazda', 'Volkswagen'];
const models = ['Aveo', 'Silverado', 'Cruze', 'Amarok'];
const engines = ['2.3', '2.4', '2.5']


const search = () => {
    //
};
</script>
<template>
    <div
        class="bg-gray-100 px-4 pb-4 rounded-b max-w-xs w-full ml-8 z-10 shadow-lg divide-y divide-secondary-500 absolute space-y-6"
    >
        <div id="applicationLookup">
            <div>
                <Label
                    for="year"
                    value="A&ntilde;o"
                    class="font-bold text-black mt-1"
                />
                <select class="mt-1 block w-full" id="year" name="year">
                    <template v-for="(year, key) in years" :key="key">
                        <option :value="year">{{ year }}</option>
                    </template>
                </select>
            </div>
            <div>
                <Label
                    for="make"
                    value="Armadora"
                    class="font-bold text-black mt-1"
                />
                <select class="mt-1 block w-full" id="make" name="make">
                    <template v-for="(make, key) in makes" :key="key">
                        <option :value="make">{{ make }}</option>
                    </template>
                </select>
            </div>
            <div>
                <Label
                    for="model"
                    value="Model"
                    class="font-bold text-black mt-1"
                />
                <select class="mt-1 block w-full" id="model" name="model">
                    <template v-for="(model, key) in models" :key="key">
                        <option :value="model">{{ model }}</option>
                    </template>
                </select>
            </div>
            <div>
                <Label
                    for="engine"
                    value="Motor"
                    class="font-bold text-black mt-1"
                />
                <select class="mt-1 block w-full" id="engine" name="engine">
                    <template v-for="(engine, key) in engines" :key="key">
                        <option :value="engine">{{ engine }}</option>
                    </template>
                </select>
            </div>
        </div>
        <div id="textLookup">
            <div>
                <Input
                    id="email"
                    type="text"
                    class="mt-6 block w-full"
                    v-model="form.email"
                    placeholder="Marca, Modelo, Año, Motor"
                />
                <SecondaryButton
                    class="flex space-x-1 mt-2 w-full rounded"
                    :disabled="form.processing"
                >
                    <i
                        class="fas fa-spinner-third fa-spin mr-2"
                        v-if="form.processing"
                    ></i>
                    <span>Buscar</span>
                </SecondaryButton>
            </div>
        </div>
        <div id="textLookup">
            <div>
                <div class="relative text-gray-600 focus-within:text-gray-400">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                        <span class="p-1 focus:outline-none focus:shadow-outline">
                            <svg
                                fill="none"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                class="w-6 h-6"
                            >
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                    </span>
                    <Input
                        id="skuSearch"
                        type="text"
                        class="mt-6 pl-10 block w-full"
                        v-model="formSearch.sku"
                        placeholder="No. de Parte"
                    />
                </div>
                <SecondaryButton
                    class="flex space-x-1 mt-2 w-full rounded"
                    :disabled="form.processing"
                >
                    <i
                        class="fas fa-spinner-third fa-spin mr-2"
                        v-if="form.processing"
                    ></i>
                    <span>Buscar</span>
                </SecondaryButton>
            </div>
        </div>
    </div>
</template>
