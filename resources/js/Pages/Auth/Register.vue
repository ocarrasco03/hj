<script setup>
import SecondaryButton from '@/Components/SecondaryButton.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<script context="module">
import BreezeGuestLayout from '@/Layouts/Guest.vue';

export default{
    layout: BreezeGuestLayout,
}
</script>

<template>
        <Head title="Register" />

        <BreezeValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <BreezeLabel for="name" value="Nombre Completo" />
                <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <BreezeLabel for="email" value="Email" />
                <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <BreezeLabel for="password" value="Contraseña" />
                <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <BreezeLabel for="password_confirmation" value="Confirmar Contraseña" />
                <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-4 inline-flex justify-center items-center space-x-1">
                <BreezeCheckbox id="terms" class="focus:ring-0 focus:ring-transparent checked:ring-0 checked:ring-transparent" v-model="form.terms" required :checked="form.terms" />
                <BreezeLabel for="terms" value="Acepto Terminos y Condiciones" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <SecondaryButton class="flex-1" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Registrar
                </SecondaryButton>
            </div>

            <div class="flex items-center justify-center mt-4">
                <Link :href="route('login')" class="underline text-sm text-secondary-600 hover:text-gray-900">
                    &iquest;Ya tienes cuenta?
                </Link>
            </div>

            <div class="mt-10 flex items-center justify-center">
                <Link :href="route('terms')" class="font-bold text-xs text-secondary-500 hover:text-gray-900">
                    T&eacute;rminos y Condiciones
                </Link>
            </div>
        </form>
</template>
