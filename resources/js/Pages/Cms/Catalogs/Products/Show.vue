<script setup>
import { ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const edit = ref(false);

const props = defineProps({
    product: Object,
    brands: Object,
});

const form = useForm({
    id: props.product.id,
    sku: props.product.sku,
    name: props.product.name,
    description: props.product.description,
    notes: props.product.notes,
    brand: props.product.brand.name,
    cost: props.product.cost,
    price_wo_tax: props.product.price_wo_tax,
    price: props.product.price,
});

const calculatePrice = () => {
    const profit = 1.63;
    form.price = Math.ceil(form.cost * profit);
    calculatePriceWoTax();
};

const calculatePriceWoTax = () => {
    form.price_wo_tax =
        Math.round((form.price / 1.16) * Math.pow(10, 10)) / Math.pow(10, 10);
};
</script>

<script context="module">
import AdminLayout from "@/Layouts/Admin.vue";

export default {
    layout: AdminLayout,
};
</script>

<template>
    <Head :title="`${$t('Product')} ${product.sku}`" />

    <!-- Breadcrumb -->
    <section class="breadcrumb lg:flex items-start">
        <div>
            <h1>{{ `${$t("Product")} ${product.sku}` }}</h1>
            <ul>
                <li>
                    <Link :href="route('admin.dashboard')">
                        <span class="la la-home"></span>
                    </Link>
                </li>
                <li class="divider la la-arrow-right"></li>
                <li><Link v-text="'Catalogos'" /></li>
                <li class="divider la la-arrow-right"></li>
                <li><Link @click="back" v-text="$t('Products')" /></li>
                <li class="divider la la-arrow-right"></li>
                <li>{{ `${$t("Product")} ${product.sku}` }}</li>
            </ul>
        </div>
        <div class="lg:flex items-center ml-auto mt-5 lg:mt-0">
            <div class="flex mt-5 lg:mt-0">
                <!-- Add New -->
                <Link
                    @click="back"
                    class="btn btn-admin btn-outlined rounded-full uppercase ml-2"
                >
                    <i class="las la-undo"></i>
                    <span class="hidden lg:block ml-2">Regresar</span>
                </Link>
            </div>
        </div>
    </section>
    <div class="lg:flex lg:-mx-4">
        <!-- Content -->
        <div class="lg:w-1/2 xl:w-3/4 lg:px-4">
            <div class="card p-5">
                <form>
                    <div class="mb-5 xl:w-1/2">
                        <label class="label block mb-2" for="sku">SKU</label>
                        <input
                            id="sku"
                            type="text"
                            class="form-control"
                            v-model="form.sku"
                        />
                    </div>
                    <div class="mb-5 xl:w-1/2">
                        <label class="label block mb-2" for="name">{{
                            $t("Name")
                        }}</label>
                        <input
                            id="name"
                            type="text"
                            class="form-control"
                            v-model="form.name"
                        />
                    </div>
                    <div class="mb-5 xl:w-1/2">
                        <label class="label block mb-2" for="brand">{{
                            $t("Brand")
                        }}</label>
                        <div class="custom-select">
                            <select class="form-control" v-model="form.brand">
                                <template
                                    v-for="(brand, key) in brands"
                                    :key="key"
                                >
                                    <option :value="brand">{{ brand }}</option>
                                </template>
                            </select>
                            <div
                                class="custom-select-icon la la-caret-down"
                            ></div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label class="label block mb-2" for="content">{{
                            $t("Description")
                        }}</label>
                        <textarea
                            id="content"
                            class="form-control resize-none overflow-auto"
                            v-model="form.description"
                            rows="10"
                        ></textarea>
                    </div>
                    <div class="xl:w-1/2">
                        <label class="label block mb-2" for="notes">{{
                            $t("Notes")
                        }}</label>
                        <textarea
                            id="content"
                            class="form-control resize-none"
                            v-model="form.description"
                            rows="10"
                        ></textarea>
                    </div>
                </form>
            </div>
        </div>

        <!-- Recent -->
        <div class="lg:w-1/2 xl:w-1/4 lg:px-4 pt-5 lg:pt-0">
            <div class="relative card p-5">
                <h3>Costos</h3>
                <form class="mt-5">
                    <div class="flex items-center">
                        <div class="w-1/4">
                            <label class="label block">{{ $t("Cost") }}</label>
                        </div>
                        <div class="w-3/4 ml-2">
                            <input
                                type="text"
                                name="cost"
                                id="cost"
                                v-model="form.cost"
                                class="form-control"
                                @keyup="calculatePrice"
                            />
                        </div>
                    </div>
                    <div class="flex items-center mt-5">
                        <div class="w-1/4">
                            <label class="label block">{{
                                $t("Price W/O Tax")
                            }}</label>
                        </div>
                        <div class="w-3/4 ml-2">
                            <input
                                type="text"
                                name="price_wo_tax"
                                id="price_wo_tax"
                                v-model="form.price_wo_tax"
                                class="form-control"
                                disabled
                            />
                        </div>
                    </div>
                    <div class="flex items-center mt-5">
                        <div class="w-1/4">
                            <label class="label block">{{ $t("Price") }}</label>
                        </div>
                        <div class="w-3/4 ml-2">
                            <input
                                type="text"
                                name="price"
                                id="price"
                                v-model="form.price"
                                class="form-control"
                            />
                        </div>
                    </div>
                    <!-- <div class="flex items-center mt-5">
                        <div class="w-1/4">
                            <label class="label block">{{ $t('Status') }}</label>
                        </div>
                        <div class="w-3/4 ml-2">
                            <label class="label switch">
                                <input type="checkbox" />
                                <span></span>
                                <span>Immediately</span>
                            </label>
                        </div>
                    </div> -->
                </form>
                <div class="mt-5">
                    <button class="btn btn-admin mt-5 mr-2 uppercase" :disabled="!form.isDirty">
                        {{ $t("Save") }}
                    </button>
                    <button
                        class="btn btn-outlined btn-danger rounded-full mt-5 uppercase"
                    >
                        {{ $t("Cancel") }}
                    </button>
                </div>
            </div>

            <!-- Categories -->
            <div class="card mt-5 p-5">
                <h3>{{ $t("Categories") }}</h3>
                <div class="flex items-center mt-5">
                    <div class="w-1/4">
                        <label class="label block">{{ $t("Category") }}</label>
                    </div>
                    <div class="w-3/4 ml-2">
                        <div class="custom-select">
                            <select class="form-control" v-model="form.brand">
                                <template
                                    v-for="(brand, key) in brands"
                                    :key="key"
                                >
                                    <option :value="brand">{{ brand }}</option>
                                </template>
                            </select>
                            <div
                                class="custom-select-icon la la-caret-down"
                            ></div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center mt-5">
                    <div class="w-1/4">
                        <label class="label block">{{ $t("Subcategory") }}</label>
                    </div>
                    <div class="w-3/4 ml-2">
                        <div class="custom-select">
                            <select class="form-control" v-model="form.brand">
                                <template
                                    v-for="(brand, key) in brands"
                                    :key="key"
                                >
                                    <option :value="brand">{{ brand }}</option>
                                </template>
                            </select>
                            <div
                                class="custom-select-icon la la-caret-down"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tags -->
            <div class="card mt-5 p-5">
                <h3>Tags</h3>
                <form class="mt-5">
                    <label class="form-control-addon-within flex-row-reverse">
                        <input
                            type="text"
                            class="form-control ltr:pl-2 rtl:pr-2 border-none w-full"
                            placeholder="Enter a tag"
                        />
                        <span class="flex items-center pl-4">
                            <span class="badge badge-admin">
                                tag
                                <button
                                    type="button"
                                    class="focus:outline-none ltr:ml-1 rtl:mr-1 la la-times"
                                ></button>
                            </span>
                        </span>
                    </label>
                    <small class="block mt-2">Seperate tags with commas</small>
                </form>
            </div>

            <!-- Featured Image -->
            <div class="card mt-5 p-5">
                <h3>{{ $t('Media Gallery') }}</h3>
                <div class="mt-5 grid grid-cols-6 gap-4">
                    <template v-for="(image, key) in product.media" :key="key">
                        <img :src="image.original_url" :alt="image.file_name" srcset="">
                    </template>
                </div>
                <div class="dropzone mt-5">
                    <h3>Drop files here to upload</h3>
                </div>
                <button class="mt-5 btn btn-outlined btn-secondary uppercase rounded-full">
                    Browse
                </button>
            </div>
        </div>
    </div>
</template>
