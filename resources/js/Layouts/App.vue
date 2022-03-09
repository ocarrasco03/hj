<script setup>
import { ref } from 'vue';
import { Link } from "@inertiajs/inertia-vue3";
import HjApplicationLogo from "@/Components/ApplicationLogo.vue";
import HjNavLink from '@/Components/NavLink.vue';
import HjResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';


const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="min-h-screen bg-white flex flex-col">
        <!-- Navigation Manu -->
        <nav class="bg-gradient-to-b from-black via-secondary to-secondary-500 border-b border-yellow-500">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                            <Link :href="route('home')"
                            class="flex items-center text-center flex-col px-3 hover:text-white text-primary rounded-full">
                                <i class="fal fa-shopping-cart text-4xl"></i>
                                <span class="text-center text-base">Carrito</span>
                            </Link>
                        </template>
                        <Link v-if="!$page.props.auth.user" :href="route('register')" class="flex items-center text-center flex-col px-3 text-primary hover:text-white transition">
                            <i class="fal fa-sign-in text-4xl"></i>
                            <span class="text-base">Registro</span>
                        </Link>
                    </div>
                </div>
            </div>
            <div class="bg-yellow-500 shadow-md">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-12">
                        <div class="flex">
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <HjNavLink :href="route('home')" :active="route().current('home')">
                                    Inicio
                                </HjNavLink>
                                <HjNavLink :href="route('dashboard')" :active="route().current('dashboard')">
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
                        <HjResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
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
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white divide-y divide-gray-400">
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
                                <Link :href="'https://www.facebook.com/hjautopartesMX'"
                                    class="social-link">
                                    <i class="fab fa-facebook-f"></i>
                                </Link>
                                <Link :href="'#'"
                                    class="social-link">
                                    <i class="fab fa-linkedin-in"></i>
                                </Link>
                                <Link :href="'#'"
                                    class="social-link">
                                    <i class="fab fa-twitter"></i>
                                </Link>
                                <Link :href="'#'"
                                    class="social-link">
                                    <i class="fab fa-youtube"></i>
                                </Link>
                            </div>
                        </div>

                    </div>
                    <div class="text-xs space-y-5">
                        <span class="text-primary text-sm font-bold pb-4">Nosotros</span>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum numquam officiis necessitatibus a quis
                            unde ex cum fugiat dicta. Possimus fugit suscipit nisi natus deserunt voluptate perspiciatis ipsam
                            similique nam.</p>
                    </div>
                    <div class="text-xs space-y-5">
                        <span class="text-primary text-sm font-bold pb-4">Acceso Rápido</span>
                        <ul class="list-none space-y-2">
                            <li>
                                <Link :href="route('home')" class="text-white transition delay-100 ease-in">Inicio</Link>
                            </li>
                            <li>
                                <Link :href="route('home')"
                                    class="text-white transition delay-100 ease-in">Corporativo</Link>
                            </li>
                            <li>
                                <Link :href="route('home')" class="text-white transition delay-100 ease-in">Tips
                                    Técnicos</Link>
                            </li>
                            <li>
                                <Link :href="route('home')" class="text-white transition delay-100 ease-in">Facturación</Link>
                            </li>
                            <li>
                                <Link :href="route('home')" class="text-white transition delay-100 ease-in">Terminos y
                                    Condiciones</Link>
                            </li>
                            <li>
                                <Link :href="route('home')" class="text-white transition delay-100 ease-in">Políticas de
                                    Garantia</Link>
                            </li>
                            <li>
                                <Link :href="route('home')" class="text-white transition delay-100 ease-in">Aviso de
                                    Privacidad</Link>
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
