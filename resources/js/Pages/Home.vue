<script setup>
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import toastr from "toastr";
import HjApplicationLogo from "@/Components/ApplicationLogo.vue";
import HjSectionTitle from "@/Components/SectionTitle.vue";
import HjButton from "@/Components/Button.vue";
import HjInput from "@/Components/Input.vue";
import HjLabel from "@/Components/Label.vue";
import HjTextarea from "@/Components/Textarea.vue";
import { Inertia } from "@inertiajs/inertia";

let rate = Math.floor(Math.random() * 5);

const form = useForm({
    email: "",
    name: "",
    phone: "",
    subject: "",
    message: "",
});

const suscribe = useForm({
    email: "",
});

const submitContact = () => {
    form.post(route("contact.form"), {
        onFinish: () => {
            Inertia.on("success", (event) => console.log(event));
            form.reset();
            toastr["success"]("Mensaje enviado exitosamente", 'Success');

            toastr.options = {
                closeButton: false,
                debug: false,
                newestOnTop: false,
                progressBar: true,
                positionClass: "toast-top-right",
                preventDuplicates: false,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                timeOut: "5000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
            };
        },
    });
};
const submitSuscribe = () => {};
</script>

<template>
    <Head title="Inicio" />
    <HjSectionTitle :primary="true">
        <h4>Productos Sugeridos</h4>
    </HjSectionTitle>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <div
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 sm:gap-x-2 sm:gap-y-8 place-items-stretch"
        >
            <div
                class="flex flex-col px-4 space-y-4"
                v-for="(n, key) in 8"
                :key="key"
            >
                <div class="flex flex-grow w-full h-36 max-h-36 bg-white">
                    <HjApplicationLogo
                        class="block h-36 w-auto mx-auto"
                        :fill="'#000'"
                    />
                </div>
                <span class="font-bold text-2xl">
                    $
                    {{
                        Math.round(
                            1 +
                                (Math.random() / Math.max(Math.random())) *
                                    (5000 - 1),
                            2
                        )
                    }}
                </span>
                <div id="rate" class="flex flex-row space-x-1">
                    <template v-for="(i, key) in 5" :key="key">
                        <i v-if="i < n" class="fas fa-star text-yellow-500"></i>
                        <i v-else class="fal fa-star text-secondary-500"></i>
                    </template>
                </div>
                <h5 class="text-base font-bold">Disco ventilado BREMBO</h5>
                <p class="text-sm">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                    Ratione repudiandae corporis, ex in nesciunt eaque repellat
                    exercitationem sequi quia, nemo consequuntur quasi
                    perspiciatis. Veniam dignissimos rem, nesciunt asperiores
                    numquam tenetur.
                </p>
                <div class="self-end w-full">
                    <div class="grid grid-cols-2 gap-0 text-sm">
                        <Link
                            class="col-span-2 btn btn_primary text-center py-2 text-lg transition ease-in delay-150"
                        >
                            Ver mas
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <HjSectionTitle :primary="true">
        <h4>Sucursal Matriz</h4>
    </HjSectionTitle>
    <HjSectionTitle :primary="true">
        <h4>Nuestras Sucursales</h4>
    </HjSectionTitle>
    <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 divide-y divide-gray-500"
    >
        <div></div>
        <div class="py-5 px-5">
            <div
                class="bg-primary rounded-md shadow-md max-w-3xl mx-auto px-7 py-8"
            >
                <h2 class="font-bold text-xl">
                    Contactanos, dudas y sugerencias
                </h2>
                <form @submit.prevent="submitContact">
                    <div class="pt-1">
                        <div class="grid grid-rows-3 grid-flow-col gap-4">
                            <HjInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                placeholder="Nombre Completo"
                            />
                            <HjInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                placeholder="Email"
                                required
                            />
                            <HjInput
                                id="phone"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.phone"
                                placeholder="Teléfono"
                                required
                            />
                            <HjInput
                                id="subject"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.subject"
                                placeholder="Asunto"
                                required
                            />
                            <HjTextarea
                                class="block mt-1 w-full row-span-2"
                                name="message"
                                id="message"
                                placeholder="Mensaje"
                                v-model="form.message"
                            ></HjTextarea>
                        </div>
                    </div>
                    <div class="flex justify-end mt-7 items-center">
                        <HjButton>Enviar</HjButton>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <HjSectionTitle>
        <div class="flex justify-between items-center">
            <h5>Suscribete y recibe nuestra promociones</h5>
            <form class="flex space-x-1" @submit.prevent="">
                <HjInput
                    id="email"
                    type="email"
                    class="block w-full w-80"
                    v-model="suscribe.email"
                    placeholder="Email"
                    required
                />
                <HjButton>Enviar</HjButton>
            </form>
        </div>
    </HjSectionTitle>
</template>
