<script setup>
import BreezeButton from '@/Components/Button.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import OutlinedButton from '@/Components/OutlinedButtonSecondary.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    username: '',
    password: '',
    remember: false
});

const submit = () => {
    form.post(route('admin.login'), {
        onFinish: () => form.reset('password'),
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
        <Head title="Log in" />

        <BreezeValidationErrors class="mb-4" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <BreezeLabel for="username" value="Nombre de Usuario" />
                <BreezeInput id="username" type="text" class="mt-1 block w-full" v-model="form.username" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <BreezeLabel for="password" value="Contraseña" />
                <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <BreezeCheckbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                </label>
            </div>

            <div class="flex items-center justify-center mt-4">
                <SecondaryButton class="flex-1" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Iniciar
                </SecondaryButton>
            </div>
            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" :href="route('admin.password.request')" class="text-sm text-secondary-600 hover:text-gray-900">
                    &iquest;Olvidaste tu Contraseña?
                </Link>
            </div>
        </form>
</template>
