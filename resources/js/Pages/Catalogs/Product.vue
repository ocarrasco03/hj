<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Tabs from '@/Components/Tabs.vue';
import Tab from '@/Components/Tab.vue';
import axios from "axios";
import nprogress from "nprogress";
import { ref } from "vue";

defineProps({
    product: Object,
    rate: Number,
});

const toggling = ref(true);

const add = (target) => {
    //
}

const reduce = (target) => {
    //
}

</script>

<template>
    <Head :title="product.name" />
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col md:flex-row space-x-3">
            <div class="preview shrink-0">
                <img
                    id="main-image"
                    src="https://www.hjautopartes.com.mx/storage/uploads/2021-05-18/images/SC-739(0)_1621399447.jpg"
                    alt=""
                    srcset=""
                    height="450"
                    width="500"
                />
                <div class="flex flex-row">
                    <img
                        data-toggle="preview"
                        src="https://www.hjautopartes.com.mx/storage/uploads/2021-05-18/images/SC-739(0)_1621399447.jpg"
                        alt=""
                        srcset=""
                        height="95"
                        width="95"
                    />
                    <img
                        data-toggle="preview"
                        src="https://www.hjautopartes.com.mx/storage/uploads/2021-05-18/images/SC-739(1)_1621399447.jpg"
                        alt=""
                        srcset=""
                        height="95"
                        width="95"
                    />
                    <img
                        data-toggle="preview"
                        src="https://www.hjautopartes.com.mx/storage/uploads/2021-05-18/images/SC-739(2)_1621399447.jpg"
                        alt=""
                        srcset=""
                        height="95"
                        width="95"
                    />
                    <img
                        data-toggle="preview"
                        src="https://www.hjautopartes.com.mx/storage/uploads/2021-05-18/images/SC-739(3)_1621399447.jpg"
                        alt=""
                        srcset=""
                        height="95"
                        width="95"
                    />
                </div>
            </div>
            <div class="detail mx-auto">
                <h2>{{ product.name }}</h2>
                <h4 class="text-gray-500">SKU: {{ product.sku }}</h4>
                <div id="rate" class="flex flex-row space-x-1 mt-3">
                    <template v-for="(i, key) in 5" :key="key">
                        <i
                            v-if="i < rate"
                            class="fas fa-star text-yellow-500"
                        ></i>
                        <i v-else class="fal fa-star text-secondary-500"></i>
                    </template>
                </div>
                <h2 class="mt-3">$ {{ product.price }}</h2>
                <div class="mt-3">
                    <ul class="list-disc list-inside">
                        <li>Marca: Eagle BHP</li>
                        <li>Posicion: Front</li>
                        <li>Material: Hierro Fundido Gris</li>
                        <li>OEM: J3241950</li>
                    </ul>
                </div>
                <div class="mt-3">
                    <h4 class="text-secondary" v-if="product.stock > 0">
                        Disponible: {{ product.stock }}
                    </h4>
                    <h4 class="text-red-500" v-else>Sin Existencia</h4>
                </div>

                <div class="share mt-3 flex justify-between">
                    <span class="font-light text-black">Compartir:</span>
                    <div class="social-share flex flex-row space-x-7">
                        <a href="#" class="text-gray-400 hover:text-primary-900"
                            ><i class="fab fa-facebook-f"></i
                        ></a>
                        <a href="#" class="text-gray-400 hover:text-primary-900"
                            ><i class="fab fa-twitter"></i
                        ></a>
                        <a :href="`https://wa.me/?text=${route('product.show', {slug: product.slug})}`" class="text-gray-400 hover:text-primary-900" target="_blank"
                            ><i class="fab fa-whatsapp"></i
                        ></a>
                        <a href="#" class="text-gray-400 hover:text-primary-900"
                            ><i class="fab fa-linkedin-in"></i
                        ></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col tabs mt-3">
            <Tabs>
                <Tab :title="'Descripcion'" :class="'open'">
                    {{ product.description }}
                </Tab>
                <Tab :title="'Detalles'">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                    Expedita optio fugiat eveniet fugit tenetur voluptates
                    pariatur nisi totam velit! Vel ducimus soluta labore optio
                    blanditiis nesciunt, et ullam itaque voluptate. Lorem ipsum
                    dolor sit amet consectetur, adipisicing elit. Dolore eaque
                    natus, in a ab porro quae fugit alias cupiditate aut
                    repellat. Voluptas ut aliquid voluptatibus ab aut aspernatur
                    repellat cumque.
                </Tab>
                <Tab :title="'Aplicación'">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                    Quam fugit quasi, deserunt temporibus iste quisquam? Sequi
                    nulla deleniti consequatur corporis iure et possimus sed
                    doloremque, aliquid cum est quo reprehenderit. Lorem ipsum
                    dolor sit amet consectetur, adipisicing elit. Suscipit
                    repellat reiciendis itaque, consequatur quod nesciunt
                    laudantium accusamus commodi dicta praesentium iste autem
                    atque obcaecati veniam amet cumque sit sed eum? Lorem ipsum
                    dolor sit amet consectetur adipisicing elit. Ad quod autem
                    voluptatibus commodi facilis reiciendis, ducimus quaerat
                    quasi, tempora dicta unde consequuntur recusandae cupiditate
                    ut sunt at quae similique omnis. Lorem ipsum dolor sit amet
                    consectetur adipisicing elit. Quae, culpa qui. Voluptate
                    suscipit neque esse ipsam possimus similique quaerat labore
                    incidunt itaque exercitationem officia cum, placeat fuga
                    voluptatem. Et, esse.
                </Tab>
                <Tab :title="'Reseñas'">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                    Quam fugit quasi, deserunt temporibus iste quisquam? Sequi
                    nulla deleniti consequatur corporis iure et possimus sed
                    doloremque, aliquid cum est quo reprehenderit. Lorem ipsum
                    dolor sit amet consectetur, adipisicing elit. Suscipit
                    repellat reiciendis itaque, consequatur quod nesciunt
                    laudantium accusamus commodi dicta praesentium iste autem
                    atque obcaecati veniam amet cumque sit sed eum? Lorem ipsum
                    dolor sit amet consectetur adipisicing elit. Ad quod autem
                    voluptatibus commodi facilis reiciendis, ducimus quaerat
                    quasi, tempora dicta unde consequuntur recusandae cupiditate
                    ut sunt at quae similique omnis. Lorem ipsum dolor sit amet
                    consectetur adipisicing elit. Quae, culpa qui. Voluptate
                    suscipit neque esse ipsam possimus similique quaerat labore
                    incidunt itaque exercitationem officia cum, placeat fuga
                    voluptatem. Et, esse.
                </Tab>
            </Tabs>
        </div>
    </div>
</template>
