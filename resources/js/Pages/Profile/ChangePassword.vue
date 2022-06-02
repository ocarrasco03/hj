<template>
<Head title="Cambiar Contraseña" />
<div class="container py-7 lg:flex">
    <ProfileMenu class="lg:w-1/4" />
    <div class="lg:w-3/4 lg:ml-4 lg:mt-0 mt-4">
        <BreezeValidationErrors class="mb-4" />
        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <div class="card rounded-sm border">
            <div class="bg-secondary-500 text-primary-500 px-5 py-4">
                    <h5>{{ $t("Change Password") }}</h5>
                </div>
            <form @submit.prevent="submit" class="p-5">
                <div>
                    <label for="password">{{ $t('Password') }}</label>
                    <input type="password" class="border-gray-500 border-2 focus:ring-0 rounded shadow-sm mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
                </div>
                <div class="mt-4">
                    <label for="password_confirmation">{{ $t('Confirm Password') }}</label>
                    <input type="password" class="border-gray-500 border-2 focus:ring-0 rounded shadow-sm mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
                </div>
                <div class="mt-4 flex items-center justify-end">
                    <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">{{ $t('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
</template>

<script setup>
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import BreezeValidationErrors from '@/Components/ValidationErrors';
import ProfileMenu from "@/Pages/Profile/ProfileMenu";

const form = useForm({
    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.post(route('profile.change.password'), {
        onSuccess: () => form.reset(),
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
}
</script>
