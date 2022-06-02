<template>
    <nav>
        <div class="rounded bg-white text-secondary-500 py-3 shadow-sm border">
            <Link
                :href="route('profile')"
                class="flex items-center justify-start flex-1 text-secondary-500 hover:bg-primary-500 hover:text-secondary-500 px-4 py-2 w-full"
                :class="{'bg-primary-500 text-secondary-500': route().current('profile')}"
            >
                <span class="la la-user text-2xl leading-none mr-2"></span
                >{{ $t("My Profile") }}
            </Link>
            <Link
                :href="route('profile.change.password')"
                class="flex items-center justify-start flex-1 text-secondary-500 hover:bg-primary-500 hover:text-secondary-500 px-4 py-2 w-full"
                :class="{'bg-primary-500 text-secondary-500': route().current('profile.change.password')}"
            >
                <span class="la la-key text-2xl leading-none mr-2"></span>{{ $t("Change Password") }}
            </Link>
            <hr class="border-secondary-100 my-2" />
            <Link
                :href="route('profile.address')"
                class="flex items-center justify-start flex-1 text-secondary-500 px-4 py-2 w-full hover:bg-primary-500 hover:text-secondary-500"
                :class="{'bg-primary-500 text-secondary-500': route().current('profile.address')}"
            >
                <span
                    class="las la-map-marked-alt text-2xl leading-none mr-2"
                ></span
                >{{ $t("Addresses") }}
            </Link>
            <Link
                class="flex items-center justify-start flex-1 text-secondary-500 hover:bg-primary-500 hover:text-secondary-500 px-4 py-2 w-full"
            >
                <span class="la la-dolly text-2xl leading-none mr-2"></span
                >{{ $t("Orders") }}
            </Link>
            <hr class="border-secondary-100 my-2" />
            <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="flex items-center justify-start flex-1 hover:bg-primary-500 hover:text-secondary-500 px-4 py-2 w-full"
            >
                <span class="la la-power-off text-2xl leading-none mr-2"></span
                >{{ $t("Logout") }}
            </Link>
        </div>
    </nav>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";
</script>
