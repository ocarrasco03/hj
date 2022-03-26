<script setup>
import { ref } from 'vue';
import { Link } from "@inertiajs/inertia-vue3";
import HjApplicationLogo from "@/Components/ApplicationLogo.vue";
import HjNavLink from '@/Components/NavLink.vue';
import HjResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import Toast from '@/Components/Toast.vue';

const showingNavigationDropdown = ref(false);

</script>

<template>
    <div class="min-h-screen bg-white flex flex-col">
        <Toast :toast="$page.props.toast" />
        <!-- Navigation Manu -->
        <nav class="bg-gradient-to-b from-black via-secondary to-secondary-500 z-10">
            <div class="container">
                <div class="flex justify-between py-3 h-32">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <Link :href="route('home')" class="flex items-center justify-center">
                            <HjApplicationLogo class="block h-20 w-auto" />
                        </Link>
                    </div>
                    <!-- Auth Section -->
                    <div class="shrink-0 flex items-center space-x-1">
                        <Link v-if="!$page.props.auth.user" :href="route('login')" class="flex items-center text-center flex-col px-3 text-primary hover:text-white transition">
                            <i class="fal fa-user-circle text-4xl"></i>
                            <span class="text-base">Login</span>
                        </Link>
                        <template v-else>
                            <Link v-if="$page.props.auth.user" :href="route('login')" class="flex items-center text-center flex-col px-3 text-primary hover:text-white transition">
                                <i class="fal fa-user-circle text-4xl"></i>
                                <span class="text-base">{{ $page.props.auth.user.name }}</span>
                            </Link>
                            <Link :href="route('cart')"
                            class="flex items-center text-center flex-col px-3 hover:text-white text-primary rounded-full">
                                <i class="fal fa-shopping-cart text-4xl"></i>
                                <span class="text-center text-base">Carrito</span>
                                <span v-if="$page.props.cartTotalItems > 0" class="absolute ml-12 -mt-1 z-10 bg-white text-secondary-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-200 dark:text-yellow-900">{{ $page.props.cartTotalItems }}</span>
                            </Link>
                        </template>
                        <Link v-if="!$page.props.auth.user" :href="route('register')" class="flex items-center text-center flex-col px-3 text-primary hover:text-white transition">
                            <i class="fal fa-sign-in text-4xl"></i>
                            <span class="text-base">Registro</span>
                        </Link>
                    </div>
                </div>
            </div>
            <div class="bg-yellow-500 shadow-lg border border-primary-500">
                <!-- Primary Navigation Menu -->
                <div class="container">
                    <div class="flex justify-between h-12">
                        <div class="flex flex-auto">
                            <div class="hidden space-x-8 sm:-my-px sm:flex flex-auto">
                                <HjNavLink class="bg-gray-100 w-full max-w-xs items-center justify-center font-bold text-center hover:border-0 hover:border-transparent">
                                    Catalogo Electrónico
                                </HjNavLink>
                                <HjNavLink :href="route('home')" :active="route().current('home')">
                                    Inicio
                                </HjNavLink>
                                <HjNavLink :href="route('corporate')" :active="route().current('corporate')">
                                    Corporativo
                                </HjNavLink>
                                <HjNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Catálogo
                                </HjNavLink>
                                <HjNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Tips Tecnicos
                                </HjNavLink>
                            </div>
                        </div>
                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-black hover:text-gray-900 focus:outline-none transition">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <HjResponsiveNavLink :href="route('home')" :active="route().current('home')">
                            Inicio
                        </HjResponsiveNavLink>
                        <HjResponsiveNavLink :href="route('corporate')" :active="route().current('corporate')">
                            Corporativo
                        </HjResponsiveNavLink>
                        <HjResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Catálogo
                        </HjResponsiveNavLink>
                        <HjResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Tips Tecnicos
                        </HjResponsiveNavLink>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Section -->
        <main class="flex-1">
            <slot></slot>
        </main>
        <!-- Footer -->
        <footer class="footer">
            <div class="container text-white divide-y divide-gray-400">
                <div class="grid grid-cols-1 gap-4 py-5 sm:grid-cols-2 md:grid-cols-4">
                    <div class="flex flex-shrink flex-col content-between">
                        <Link :href="route('home')" class="flex items-center justify-center">
                            <HjApplicationLogo class="block h-24 w-auto" />
                        </Link>
                        <div>
                            <div class="mt-10">
                                <h5 class="text-yellow-500">
                                    Siguenos:
                                </h5>
                            </div>
                            <div class="flex flex-row mt-2">
                                <a href="https://www.facebook.com/hjautopartesMX" target="_blank"
                                    class="social-link">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://www.instagram.com/hjautopartes/" target="_blank"
                                    class="social-link">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <!-- <a href="#" target="_blank"
                                    class="social-link">
                                    <i class="fab fa-twitter"></i>
                                </a> -->
                                <!-- <a href="#" target="_blank"
                                    class="social-link">
                                    <i class="fab fa-youtube"></i>
                                </a> -->
                            </div>
                        </div>

                    </div>
                    <div class="text-xs space-y-5">
                        <span class="text-primary text-sm font-bold pb-4">Nosotros</span>
                        <p class="text-justify">Somos una empresa 100% Mexicana líder en: Innovación, desarrollo, fabricación y comercialización de autopartes en el mercado global, con presencia en mercados INTERNACIONALES como Estados Unidos, Colombia, Guatemala, Costa Rica, El Salvador, Perú, Ecuador, Venezuela, Chile, Brasil, Bolivia, Canadá, Líbano, Israel, etc. Consolidando cada una de nuestras marcas como líderes indiscutibles en cada uno de sus segmentos, forjando valor a través de nuestra cadena productiva única en el mercado de autopartes; generando excelentes niveles de rentabilidad para nuestros clientes.</p>
                    </div>
                    <div class="text-xs space-y-5">
                        <span class="text-primary text-sm font-bold pb-4">Acceso Rápido</span>
                        <ul class="list-none space-y-2">
                            <li>
                                <Link :href="route('home')" class="text-white transition delay-100 ease-in">Inicio</Link>
                            </li>
                            <li>
                                <Link :href="route('corporate')"
                                    class="text-white transition delay-100 ease-in">Corporativo</Link>
                            </li>
                            <li>
                                <Link :href="route('home')" class="text-white transition delay-100 ease-in">Tips T&eacute;cnicos</Link>
                            </li>
                            <li>
                                <a href="https://hjautopartes.sucfdi.mx" target="_blank" class="text-white transition delay-100 ease-in">Facturaci&oacute;n</a>
                            </li>
                            <li>
                                <Link :href="route('terms')" class="text-white transition delay-100 ease-in">Terminos y Condiciones</Link>
                            </li>
                            <li>
                                <Link :href="route('warranty')" class="text-white transition delay-100 ease-in">Políticas de Garantia</Link>
                            </li>
                            <li>
                                <Link :href="route('policy')" class="text-white transition delay-100 ease-in">Aviso de Privacidad</Link>
                            </li>
                        </ul>
                    </div>
                    <div class="text-xs space-y-5" itemscope itemtype="https://schema.org/Organization">
                        <span class="text-primary text-sm font-bold pb-4">Contactanos</span>
                        <ul class="list-none">
                            <li class="mb-2">
                                <div class="flex space-x-2">
                                    <div class="text-primary"><i class="fas fa-map-marker-alt"></i></div>
                                    <address itemprop="location">
                                        Blvd. Los Alamos #195 int A, Nogales Sonora
                                    </address>
                                </div>
                            </li>
                            <li class="mb-2">
                                <div class="flex space-x-2">
                                    <div class="text-primary flex-shrink-0">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <span>
                                        <Link :href="'tel:+526311011300'" itemprop="telephone" class="text-white">631 101 1300</Link>
                                    </span>
                                </div>
                            </li>
                            <li class="mb-2">
                                <div class="flex space-x-2">
                                    <div class="text-primary"><i class="fas fa-map-marker-alt"></i></div>
                                    <span>
                                        <Link itemprop="email" :href="'mailto:atencionaclientes@hjautopartes.com.mx'"
                                            class="text-white">atencionaclientes@hjautopartes.com.mx</Link>
                                    </span>
                                </div>
                            </li>
                        </ul>
                        <img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/cc-badges-ppppcmcvdam.png"
                            alt="Pay with PayPal, PayPal Credit or any major credit card" style="width: 100%"
                            class="mt-2" />
                    </div>
                </div>
                <div class="py-6 text-center text-xs">
                    <span>
                        Todos los derechos reservados a
                        <Link :href="route('home')">HJ Autopartes</Link> &copy;
                        {{ new Date().getFullYear() }}
                    </span>
                </div>
            </div>
        </footer>
    </div>
</template>
