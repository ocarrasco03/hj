<template>
<Head title="Cambiar Contraseña" />
<div class="container py-7 lg:flex">
    <nav class="lg:w-1/4">
        <div class="rounded bg-secondary-500 text-yellow-500 py-3">
            <Link :href="route('profile')" class="flex items-center justify-start flex-1 hover:bg-primary-500 hover:text-secondary-500 px-4 py-2 w-full">
                <span class="la la-user text-2xl leading-none mr-2"></span>{{ $t('My Profile') }}
            </Link>
            <Link :href="route('profile.change.password')" class="flex items-center justify-start flex-1 bg-primary-500 text-secondary-500 hover:text-secondary-500 px-4 py-2 w-full">
                <span class="la la-key text-2xl leading-none mr-2"></span>{{ $t('Change Password') }}
            </Link>
            <hr class="border-yellow-100 my-2">
            <Link :href="route('profile.addresss')" class="flex items-center justify-start flex-1 hover:bg-primary-500 hover:text-secondary-500 px-4 py-2 w-full">
                <span class="las la-map-marked-alt text-2xl leading-none mr-2"></span>{{ $t('Addresses') }}
            </Link>
            <Link class="flex items-center justify-start flex-1 hover:bg-primary-500 hover:text-secondary-500 px-4 py-2 w-full">
                <span class="la la-dolly text-2xl leading-none mr-2"></span>{{ $t('Orders') }}
            </Link>
            <hr class="border-yellow-100 my-2">
            <Link :href="route('logout')" method="post" as="button" class="flex items-center justify-start flex-1 hover:bg-primary-500 hover:text-secondary-500 px-4 py-2 w-full">
                <span class="la la-power-off text-2xl leading-none mr-2"></span>{{ $t('Logout') }}
            </Link>
        </div>
    </nav>
    <div class="lg:w-3/4 lg:ml-5 lg:mt-0 mt-4">
        <BreezeValidationErrors class="mb-4" />
        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <div class="card rounded-sm border border-secondary-500">
            <div class="bg-secondary-500 px-5 py-3 text-yellow-500 border border-secondary-500">
                {{ $t('Change Password') }}
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
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';

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
