<script setup>
import { computed, onMounted, ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { Pagination, Navigation } from "swiper";
import { Swiper, SwiperSlide } from "swiper/vue";
import { trans } from "laravel-vue-i18n";
import Swal from "sweetalert2";
import axios from "axios";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/autoplay";

const edit = ref(false);
const index = ref(null);
const url = ref(null);
const errors = ref({});
const modules = [Pagination, Navigation];

const models = ref([]);

const getModels = () => {
    const prepend = document.getElementById("model-prepend");
    vehicle.model = "";
    if (vehicle.year && vehicle.make) {
        prepend.innerHTML = trans("Loading");
        axios
            .get(
                route("api.vehicles.models.application", {
                    make: vehicle.make,
                    year: vehicle.year,
                })
            )
            .then((res) => {
                models.value = res.data;
                prepend.innerHTML = trans("Model");
            })
            .catch((err) => {
                console.error(err);
                prepend.innerHTML = trans("Error");
            });
    }
};

const vehicle = useForm({
    year: "",
    make: "",
    model: "",
    engine: "",
});

const props = defineProps({
    product: Object,
    brands: Object,
    categories: Object,
    years: Object,
    makes: Object,
});

const setCategory = (type = "parent") => {
    let name;
    props.product.categories.map((element) => {
        if (element.parent_id === null) {
            name = element.name;
            index.value = props.categories.findIndex(
                (object) => object.name === element.name
            );
        } else {
            if (type === "children") {
                name = element.name;
            }
        }
    });

    return name;
};

const form = useForm({
    sku: props.product.sku,
    name: props.product.name,
    description: props.product.description,
    notes: props.product.notes,
    brand: props.product.brand.name,
    cost: props.product.cost,
    price_wo_tax: props.product.price_wo_tax,
    price: props.product.price,
    category: setCategory(),
    subcategory: setCategory("children"),
    condition: props.product.condition,
    stock: props.product.stock,
});

const submit = () => {
    form.put(
        route("admin.catalogs.products.update", { product: props.product.id }),
        {
            preserveScroll: true,
            preserveState: true,
            onError: (error) => {
                if (typeof error === "object") {
                    errors.value = error;
                } else {
                    console.error(error);
                }
            },
        }
    );
};

const upload = useForm({
    image: null,
});

const uploadImage = () => {
    upload.post(
        route("admin.catalogs.products.upload.file", {
            product: props.product.id,
        }),
        {
            preserveScroll: true,
            preserveState: true,
            onSuccess: (res) => {
                const input = document.getElementById("customFile");
                url.value = null;
                upload.reset("image");
                input.value = null;
                input.parentNode.querySelector(".file-name").innerHTML =
                    trans("No file chosen");
            },
        }
    );
};

const removeImage = (event) => {
    Swal.fire({
        title: "&iquest;Estás seguro de querer eliminar esta imagen?",
        icon: "warning",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#145388",
        cancelButtonColor: "#df4759",
        confirmButtonText: "Si, eliminar!",
    }).then((result) => {
        if (result.isConfirmed) {
            console.log(event);
        }
    });
};

const calculatePrice = () => {
    const profit = 1.63;
    form.price = Math.ceil(form.cost * profit);
    calculatePriceWoTax();
};

const loadSubcategories = () => {
    const categories = props.categories;
    index.value = categories.findIndex((element) => {
        return element.name === form.category;
    });
};

const calculatePriceWoTax = () => {
    form.price_wo_tax =
        Math.round((form.price / 1.16) * Math.pow(10, 10)) / Math.pow(10, 10);
};

const customFileInput = (event) => {
    const filename = event.target.value.split("\\").pop();
    const file = event.target.files[0];
    event.target.parentNode.querySelector(".file-name").innerHTML = filename;
    url.value = URL.createObjectURL(file);
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
                    <div class="mb-5">
                        <label class="label block mb-2" for="sku">SKU</label>
                        <input
                            id="sku"
                            type="text"
                            class="form-control"
                            v-model="form.sku"
                        />
                    </div>
                    <div class="mb-5">
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
                    <div class="mb-5">
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
                    <div class="flex flex-col xl:flex-row xl:space-x-5">
                        <div class="mb-5 xl:w-1/2">
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
                                v-model="form.notes"
                                rows="10"
                            ></textarea>
                        </div>
                    </div>
                    <div class="flex flex-col xl:flex-row xl:space-x-5 mt-5 xl:mt-0">
                        <div class="mb-5 xl:w-1/2">
                            <label class="label block mb-2" for="related">{{
                                $t("Related Products")
                            }}</label>
                            <label
                                class="form-control-addon-within rounded-full border-admin-secondary"
                            >
                                <input
                                    type="text"
                                    class="form-control border-none"
                                    :placeholder="$t('SKU')"
                                />
                                <button
                                    type="button"
                                    class="btn btn-link text-secondary dark:text-gray-700 hover:text-admin dark:hover:text-admin text-xl leading-none la la-plus mr-4"
                                ></button>
                            </label>
                            <table class="table table-admin mt-5 w-full">
                                <thead>
                                    <tr>
                                        <th class="text-left">SKU</th>
                                        <th class="text-left">
                                            {{ $t("Brand") }}
                                        </th>
                                        <th class="w-px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(
                                            related, key
                                        ) in product.related"
                                        :key="key"
                                    >
                                        <td>{{ related.sku }}</td>
                                        <td>{{ related.brand.name }}</td>
                                        <td>
                                            <button
                                                class="btn btn-outlined btn-danger ml-2 btn-icon rounded-full"
                                            >
                                                <span
                                                    class="la la-trash-alt"
                                                ></span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="xl:w-1/2">
                            <label class="label block mb-2" for="application">{{
                                $t("Application")
                            }}</label>
                            <div
                                class="flex flex-col lg:flex-row lg:space-x-1 space-y-1 lg:space-y-0"
                            >
                                <div class="custom-select lg:w-1/4">
                                    <select
                                        class="form-control"
                                        v-model="vehicle.year"
                                        @change="getModels"
                                    >
                                        <option selected disabled value="">
                                            {{ $t("Year") }}
                                        </option>
                                        <template
                                            v-for="(year, key) in years"
                                            :key="key"
                                        >
                                            <option :value="year">
                                                {{ year }}
                                            </option>
                                        </template>
                                    </select>
                                    <div
                                        class="custom-select-icon la la-caret-down"
                                    ></div>
                                </div>
                                <div class="custom-select lg:w-1/4">
                                    <select
                                        class="form-control"
                                        v-model="vehicle.make"
                                        @change="getModels"
                                    >
                                        <option selected disabled value="">
                                            {{ $t("Make") }}
                                        </option>
                                        <template
                                            v-for="(make, key) in makes"
                                            :key="key"
                                        >
                                            <option :value="make">
                                                {{ make }}
                                            </option>
                                        </template>
                                    </select>
                                    <div
                                        class="custom-select-icon la la-caret-down"
                                    ></div>
                                </div>
                                <div class="custom-select lg:w-1/4">
                                    <select
                                        class="form-control"
                                        :disabled="models.length < 1"
                                        v-model="vehicle.model"
                                    >
                                        <option
                                            selected
                                            disabled
                                            value=""
                                            id="model-prepend"
                                        >
                                            {{ $t("Model") }}
                                        </option>
                                        <template
                                            v-for="(model, key) in models"
                                            :key="key"
                                        >
                                            <option :value="model">
                                                {{ model }}
                                            </option>
                                        </template>
                                    </select>
                                    <div
                                        class="custom-select-icon la la-caret-down"
                                    ></div>
                                </div>
                                <div class="custom-select lg:w-1/4">
                                    <select
                                        class="form-control"
                                        v-model="vehicle.engine"
                                    >
                                        <option
                                            selected
                                            disabled
                                            value=""
                                            id="engine-prepend"
                                        >
                                            {{ $t("Engine") }}
                                        </option>
                                        <template
                                            v-for="(engine, key) in 20"
                                            :key="key"
                                        >
                                            <option :value="engine">
                                                {{ engine }}
                                            </option>
                                        </template>
                                    </select>
                                    <div
                                        class="custom-select-icon la la-caret-down"
                                    ></div>
                                </div>
                                <button
                                    class="btn btn-outlined btn-admin ml-2 btn-icon rounded-full"
                                >
                                    <span class="la la-plus"></span>
                                </button>
                            </div>

                            <table
                                class="table table-admin mt-5 w-full max-h-5"
                            >
                                <thead>
                                    <tr>
                                        <th class="text-left">
                                            {{ $t("Year") }}
                                        </th>
                                        <th class="text-left">
                                            {{ $t("Make") }}
                                        </th>
                                        <th class="text-left">
                                            {{ $t("Model") }}
                                        </th>
                                        <th class="text-left">
                                            {{ $t("Engine") }}
                                        </th>
                                        <th class="w-px"></th>
                                    </tr>
                                </thead>
                                <tbody class="overflow-y-auto h-5">
                                    <tr
                                        v-for="(
                                            catalog, key
                                        ) in product.catalogs"
                                        :key="key"
                                    >
                                        <td>{{ catalog.year.year }}</td>
                                        <td>{{ catalog.make.name }}</td>
                                        <td>{{ catalog.model.name }}</td>
                                        <td>
                                            {{
                                                catalog.engine !== null
                                                    ? engine
                                                    : "N/A"
                                            }}
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-outlined btn-danger ml-2 btn-icon rounded-full"
                                            >
                                                <span
                                                    class="la la-trash-alt"
                                                ></span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Recent -->
        <div class="lg:w-1/2 xl:w-1/4 lg:px-4 pt-5 lg:pt-0">
            <div class="relative card p-5">
                <h3>Costos</h3>
                <div class="mt-5">
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
                                @keyup="calculatePriceWoTax"
                            />
                        </div>
                    </div>
                    <div class="flex items-center mt-5">
                        <div class="w-1/4">
                            <label class="label block">{{
                                $t("Condition")
                            }}</label>
                        </div>
                        <div class="w-3/4 ml-2">
                            <div class="custom-select">
                                <select
                                    class="form-control"
                                    v-model="form.condition"
                                >
                                    <option value="new">{{ $t("New") }}</option>
                                    <option value="used">
                                        {{ $t("Used") }}
                                    </option>
                                    <option value="refurbished">
                                        {{ $t("Refurbished") }}
                                    </option>
                                </select>
                                <div
                                    class="custom-select-icon la la-caret-down"
                                ></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center mt-5">
                        <div class="w-1/4">
                            <label class="label block">{{ $t("Stock") }}</label>
                        </div>
                        <div class="w-3/4 ml-2">
                            <input
                                type="number"
                                class="form-control"
                                v-model.number="form.stock"
                                :class="{ 'is-invalid': errors.stock }"
                                min="0"
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
                </div>
                <div class="mt-5" v-if="form.isDirty">
                    <button
                        class="btn btn-admin mt-5 mr-2 uppercase"
                        :disabled="!form.isDirty"
                        @click="submit"
                    >
                        {{ $t("Save") }}
                    </button>
                    <button
                        class="btn btn-outlined btn-danger rounded-full mt-5 uppercase"
                        @click="form.reset()"
                    >
                        {{ $t("Cancel") }}
                    </button>
                </div>
            </div>

            <!-- Categories -->
            <div class="card mt-5 p-5">
                <h3>{{ $t("Categories") }}</h3>
                <div class="flex flex-col mt-5">
                    <label class="label block mb-1">{{ $t("Category") }}</label>
                    <div class="custom-select">
                        <select
                            class="form-control"
                            v-model="form.category"
                            @change="loadSubcategories"
                        >
                            <template
                                v-for="(category, key) in categories"
                                :key="key"
                            >
                                <option :value="category.name">
                                    {{ category.name }}
                                </option>
                            </template>
                        </select>
                        <div class="custom-select-icon la la-caret-down"></div>
                    </div>
                </div>
                <div class="flex flex-col mt-2" v-if="index !== null">
                    <label class="label block mb-1">{{
                        $t("Subcategory")
                    }}</label>
                    <div class="custom-select">
                        <select class="form-control" v-model="form.subcategory">
                            <template
                                v-for="(category, key) in categories[index]
                                    .children"
                                :key="key"
                            >
                                <option :value="category.name">
                                    {{ category.name }}
                                </option>
                            </template>
                        </select>
                        <div class="custom-select-icon la la-caret-down"></div>
                    </div>
                </div>
            </div>

            <!-- Tags -->
            <!-- <div class="card mt-5 p-5">
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
            </div> -->

            <!-- Featured Image -->
            <div class="card mt-5 p-5">
                <h3>{{ $t("Media Gallery") }}</h3>
                <div class="mt-5">
                    <Swiper
                        :slidesPerView="'auto'"
                        :spaceBetween="5"
                        :pagination="{
                            clickable: true,
                        }"
                        :navigation="true"
                        :modules="modules"
                    >
                        <SwiperSlide
                            v-for="(image, key) in product.media"
                            :key="key"
                            class="wrapper-img"
                        >
                            <img
                                :src="image.original_url"
                                :alt="image.file_name"
                                srcset=""
                                class="h-8 carousel-item"
                            />
                            <div class="action">
                                <button
                                    @click="removeImage"
                                    class="btn btn-danger btn-outlined rounded-full"
                                >
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <Link
                                    :href="
                                        route(
                                            'admin.catalogs.products.remove.file',
                                            {
                                                product: props.product.id,
                                                id: image.uuid,
                                            }
                                        )
                                    "
                                    class="hidden"
                                />
                            </div>
                        </SwiperSlide>
                    </Swiper>
                </div>
                <img :src="url" alt="" class="w-full" />
                <label
                    class="input-group text-base font-normal mt-5"
                    for="customFile"
                >
                    <div
                        class="file-name input-addon input-addon-prepend input-group-item w-full overflow-x-hidden"
                    >
                        {{ $t("No file chosen") }}
                    </div>
                    <input
                        id="customFile"
                        type="file"
                        class="hidden"
                        @change="customFileInput"
                        @input="upload.image = $event.target.files[0]"
                    />
                    <div class="input-group-item btn btn-admin uppercase">
                        <i class="fas fa-upload"></i>
                    </div>
                </label>
                <button
                    class="btn btn-admin mt-5 w-full"
                    :disabled="!upload.isDirty || upload.processing"
                    @click="uploadImage"
                >
                    <i
                        class="fad fa-spinner fa-spin mr-2"
                        v-if="upload.processing"
                    ></i>
                    {{ $t("Upload Image") }}
                </button>
            </div>
        </div>
    </div>
</template>
