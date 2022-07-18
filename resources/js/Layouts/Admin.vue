<script setup>
import { onMounted, ref } from "vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import Toast from "@/Components/Toast";
import ApplicationLogo from "@/Components/ApplicationLogo";
import Dropdown from "@/Components/Cms/CustomDropdown";
import DropdownLink from "@/Components/Cms/DropdownLink";

const showingNavigationDropdown = ref(false);
const showSideBar = ref(true);

let viewportWidth;

const hideOverlay = () => {
    const overlayToRemove = document.querySelector(".overlay");

    if (!overlayToRemove) return;

    document.body.classList.remove("overlay-show");

    overlayToRemove.classList.remove("active");
    document.body.removeChild(overlayToRemove);
};

const showOverlay = (workspace) => {
    if (document.querySelector(".overlay")) return;

    document.body.classList.add("overlay-show");
    const overlay = document.createElement("div");
    if (workspace) {
        overlay.setAttribute("class", "overlay workspace");
    } else {
        overlay.setAttribute("class", "overlay");
    }

    document.body.appendChild(overlay);
    overlay.classList.add("active");
};

// Set/update the viewportWidth value
const setViewportWidth = () => {
    viewportWidth = window.innerWidth || document.documentElement.clientWidth;
};

const hideMenuDetail = () => {
    const menuBar = document.querySelector(".menu-bar");
    const menuItems = document.querySelector(".menu-items");
    if (menuBar !== null) {
        menuBar.querySelectorAll(".menu-detail.open").forEach((menuDetail) => {
            hideOverlay();

            if (!menuBar.classList.contains("menu-wide")) {
                menuDetail.classList.remove("open");
            }
        });
    }
};

const showMenuDetail = (event) => {
    const menuBar = document.querySelector(".menu-bar");
    const menuItems = document.querySelector(".menu-items");

    const menuLink = event.target.closest(".link");
    const menu = menuLink.dataset.target;
    const selectedMenu = menuBar.querySelector(menu);

    if (menuBar !== null) {
        if (!menuBar.classList.contains("menu-wide")) {
            if (selectedMenu) {
                showOverlay(true);
            } else {
                hideOverlay();
            }

            hideMenuDetail();

            if (selectedMenu) {
                showOverlay(true);
                selectedMenu.classList.add("open");
            } else {
                hideOverlay();
            }
        }
    }
};

// AnimateCSS
const animateCSS = (element, animation, prefix = "animate__") => {
    return new Promise((resolve, reject) => {
        const animationName = `${prefix}${animation}`;
        const node = element;

        node.classList.add(
            `${prefix}animated`,
            `${prefix}faster`,
            animationName
        );

        const handleAnimationEnd = (event) => {
            event.stopPropagation();
            node.classList.remove(
                `${prefix}animated`,
                `${prefix}faster`,
                animationName
            );
            resolve("Animation Ended.");
        };

        node.addEventListener("animationend", handleAnimationEnd, {
            once: true,
        });
    });
};

// Watch the viewport width
const watchWidth = () => {
    const sm = 640;
    const md = 768;
    const lg = 1024;
    const xl = 1280;

    const menuBar = document.querySelector(".menu-bar");

    // Hide Sidebar
    const hideSidebar = () => {
        const sidebar = document.querySelector(".sidebar");

        if (!sidebar) return;

        if (sidebar.classList.contains("open")) {
            sidebar.classList.remove("open");
            hideOverlay();
        }
    };

    if (viewportWidth < sm) {
        if (!menuBar) return;

        const openMenu = menuBar.querySelector(".menu-detail.open");

        if (!openMenu) {
            menuBar.classList.add("menu-hidden");
            document.documentElement.classList.add("menu-hidden");
            hideMenuDetail();
        }
    }

    if (viewportWidth > sm) {
        if (!menuBar) return;

        menuBar.classList.remove("menu-hidden");
        document.documentElement.classList.remove("menu-hidden");
    }

    if (viewportWidth > lg) {
        hideSidebar();
    }
};

onMounted(() => {
    const menuBar = document.querySelector(".menu-bar");
    if (menuBar !== null) {
        document.addEventListener("click", (event) => {
            if (
                !event.target.closest(".menu-items a") &&
                !event.target.closest(".menu-detail") &&
                !menuBar.classList.contains("menu-wide")
            ) {
                hideMenuDetail();
            }
        });
    }
    // On resize events, recalculate
    window.addEventListener(
        "resize",
        () => {
            setViewportWidth();
            watchWidth();
        },
        false
    );
    setViewportWidth();
    watchWidth();
});
</script>

<template>
    <div class="min-h-screen bg-gray-50 relative flex">
        <Toast :toast="$page.props.toast" />
        <header class="top-bar">
            <!-- Menu Toggler -->
            <button
                type="button"
                class="menu-toggler la la-bars"
                data-toggle="menu"
                @click="showSideBar = !showSideBar"
            ></button>

            <!-- Brand -->
            <!-- <span class="brand">HJ Autopartes</span> -->
            <!-- <Link :href="route('admin.dashboard')">
                <span class="brand">
                    <ApplicationLogo class="h-16 w-auto" :fill="'#000'" />
                </span>
            </Link> -->

            <!-- Search -->
            <form class="hidden md:block ml-10">
                <label class="form-control-addon-within rounded-full">
                    <input
                        type="text"
                        class="form-control border-none"
                        placeholder="Search"
                    />
                    <button
                        type="button"
                        class="btn btn-link text-gray-300 dark:text-gray-700 hover:text-primary dark:hover:text-primary text-xl leading-none mr-4 la la-search"
                    ></button>
                </label>
            </form>

            <!-- Right -->
            <div class="flex items-center ml-auto">
                <!-- Dark Mode -->
                <!-- <label
                    class="switch switch-outlined"
                    data-toggle="tooltip"
                    data-tippy-content="Toggle Dark Mode"
                >
                    <input id="darkModeToggler" type="checkbox" />
                    <span></span>
                </label> -->

                <!-- Notifications -->
                <Dropdown
                    buttonClasses="relative flex items-center h-full btn-link ml-1 px-2 text-2xl leading-none la la-bell"
                    width="80"
                    class="self-stretch"
                >
                    <template #trigger>
                        <span
                            class="absolute top-0 right-0 rounded-full border border-primary -mt-1 -mr-1 px-2 leading-tight text-xs font-body"
                            >3</span
                        >
                    </template>
                    <template #menu>
                        <div class="flex items-center px-5 py-2">
                            <h5 class="mb-0 uppercase">Notificaciones</h5>
                            <button
                                class="btn btn-outlined rounded-full btn-warning uppercase ml-auto"
                            >
                                Borrar
                            </button>
                        </div>
                        <hr />
                        <div
                            class="p-5 hover:bg-admin-100 dark:hover:bg-admin-900"
                        >
                            <a href="#">
                                <h6 class="uppercase">Heading One</h6>
                            </a>
                            <p>Lorem ipsum dolor, sit amet consectetur.</p>
                            <small>Today</small>
                        </div>
                        <hr />
                        <div
                            class="p-5 hover:bg-admin-100 dark:hover:bg-admin-900"
                        >
                            <a href="#">
                                <h6 class="uppercase">Heading Two</h6>
                            </a>
                            <p>Mollitia sequi dolor architecto aut deserunt.</p>
                            <small>Yesterday</small>
                        </div>
                        <hr />
                        <div
                            class="p-5 hover:bg-admin-100 dark:hover:bg-admin-900"
                        >
                            <a href="#">
                                <h6 class="uppercase">Heading Three</h6>
                            </a>
                            <p>Nobis reprehenderit sed quos deserunt</p>
                            <small>Last Week</small>
                        </div>
                    </template>
                </Dropdown>

                <!-- User Menu -->
                <Dropdown
                    buttonClasses="flex items-center ml-4 text-gray-700"
                    width="64"
                >
                    <template #trigger>
                        <span class="avatar">
                            <img :src="$page.props.auth.avatar" alt="" v-if="$page.props.auth.avatar" />
                        </span>
                    </template>
                    <template #menu>
                        <div class="p-5">
                            <h5 class="uppercase">
                                {{ $page.props.auth.user.name }}
                            </h5>
                            <p>Editor</p>
                        </div>
                        <hr />
                        <div class="p-5">
                            <a
                                href="#"
                                class="flex items-center text-gray-700 dark:text-gray-500 hover:text-admin dark:hover:text-admin"
                            >
                                <span
                                    class="la la-user-circle text-2xl leading-none mr-2"
                                ></span>
                                View Profile
                            </a>
                            <a
                                href="#"
                                class="flex items-center text-gray-700 dark:text-gray-500 hover:text-admin dark:hover:text-admin mt-5"
                            >
                                <span
                                    class="la la-key text-2xl leading-none mr-2"
                                ></span>
                                Change Password
                            </a>
                        </div>
                        <hr />
                        <div class="p-5">
                            <DropdownLink
                                :href="route('admin.logout')"
                                method="post"
                                as="button"
                            >
                                <span
                                    class="la la-power-off text-2xl leading-none mr-2"
                                ></span>
                                {{ $t("Logout") }}
                            </DropdownLink>
                        </div>
                    </template>
                </Dropdown>
            </div>
        </header>

        <!-- Sidebar -->
        <aside
            class="menu-bar menu-sticky"
            :class="{ 'menu-hidden': !showSideBar }"
        >
            <div class="menu-items">
                <!-- <div class="menu-header hidden">
                    <a href="#" class="flex items-center mx-8 mt-8">
                        <span class="avatar w-16 h-16">JD</span>
                        <div class="ltr:ml-4 rtl:mr-4 ltr:text-left rtl:text-right text-gray-700 dark:text-gray-500">
                            <h5>John Doe</h5>
                            <p class="mt-2">Editor</p>
                        </div>
                    </a>
                    <hr class="mx-8 my-4">
                </div> -->
                <Link
                    :href="route('admin.dashboard')"
                    class="link"
                    :class="{ active: route().current('admin.dashboard') }"
                    @click="hideMenuDetail"
                >
                    <span class="la la-laptop icon"></span>
                    <span class="title">Dashboard</span>
                </Link>
                <a
                    class="link"
                    :class="{ active: route().current('admin.sales.*') }"
                    data-target="[data-menu=sales]"
                    @click="showMenuDetail"
                    v-if="
                        $can('order.read') ||
                        $can('refound.read') ||
                        $can('cancelation.read') ||
                        $can('invoice.read')
                    "
                >
                    <span class="icon la la-store-alt"></span>
                    <span class="title">Ventas</span>
                </a>
                <a
                    class="link"
                    :class="{ active: route().current('admin.catalogs.*') }"
                    data-target="[data-menu=catalogs]"
                    @click="showMenuDetail"
                    v-if="
                        $can('product.read') ||
                        $can('bundle.read') ||
                        $can('category.read') ||
                        $can('vehicle.read') ||
                        $can('file.read')
                    "
                >
                    <span class="icon la la-book-open"></span>
                    <span class="title">Catalogos</span>
                </a>
                <Link
                    :href="route('admin.customers.customer.index')"
                    class="link"
                    :class="{
                        active: route().current('admin.customers.customer.*'),
                    }"
                    v-if="$can('customer.read')"
                >
                    <span class="icon la la-users"></span>
                    <span class="title">Clientes</span>
                </Link>
                <Link
                    class="link"
                    :class="{ active: route().current('admin.customers.customer.service.*') }"
                    v-if="$can('customer-service.read')"
                >
                    <span class="icon la la-sitemap"></span>
                    <span class="title">Servicio al Cliente</span>
                </Link>
                <a
                    class="link"
                    :class="{ active: route().current('admin.analytics.*') }"
                    data-target="[data-menu=analytics]"
                    @click="showMenuDetail"
                    v-if="$can('analytics.read')"
                >
                    <span class="icon la la-chart-area"></span>
                    <span class="title">Estad&iacute;sticas</span>
                </a>
                <a
                    class="link"
                    :class="{ active: route().current('admin.modules.*') }"
                    data-target="[data-menu=modules]"
                    @click="showMenuDetail"
                    v-if="$can('module.read')"
                >
                    <span class="icon la la-cubes"></span>
                    <span class="title">Modulos</span>
                </a>
                <a
                    class="link"
                    :class="{ active: route().current('admin.support.*') }"
                    data-target="[data-menu=support]"
                    @click="showMenuDetail"
                    v-if="
                        $can('support.read') ||
                        $can('log.read') ||
                        $can('terminal.read')
                    "
                >
                    <span class="icon la la-headset"></span>
                    <span class="title">Soporte</span>
                </a>
                <a
                    class="link"
                    :class="{ active: route().current('admin.settings.*') }"
                    data-target="[data-menu=settings]"
                    @click="showMenuDetail"
                    v-if="
                        $can('store.read') ||
                        $can('seo.read') ||
                        $can('tag.read') ||
                        $can('search.read') ||
                        $can('slider.read') ||
                        $can('user.read') ||
                        $can('role.read') ||
                        $can('permission.read') ||
                        $can('import.read') ||
                        $can('export.read') ||
                        $can('backup.read')
                    "
                >
                    <span class="icon la la-gears"></span>
                    <span class="title">Configuración</span>
                </a>
            </div>

            <!-- Sales -->
            <div class="menu-detail" data-menu="sales">
                <div class="menu-detail-wrapper">
                    <Link
                        :href="route('admin.sales.orders.index')"
                        :class="{
                            active: route().current('admin.sales.orders.*'),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('product.read')"
                    >
                        <span class="la la-shopping-cart"></span>
                        Pedidos
                    </Link>
                    <Link
                        href="#"
                        :class="{
                            active: route().current('admin.settings.info'),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('invoice.read')"
                    >
                        <span class="la la-file-invoice-dollar"></span>
                        Facturas
                    </Link>
                    <Link
                        href="#"
                        :class="{
                            active: route().current('admin.settings.info'),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('refound.read')"
                    >
                        <span class="hj hj-product-return"></span>
                        Devoluciones
                    </Link>
                </div>
            </div>

            <!-- Catalogs -->
            <div class="menu-detail" data-menu="catalogs">
                <div class="menu-detail-wrapper">
                    <Link
                        :href="route('admin.catalogs.products.index')"
                        :class="{
                            active: route().current(
                                'admin.catalogs.products.*'
                            ),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('product.read')"
                    >
                        <span class="la la-archive"></span>
                        Productos
                    </Link>
                    <Link
                        href="#"
                        :class="{
                            active: route().current('admin.catalogs.bundles.*'),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('bundle.read')"
                    >
                        <span class="la la-cubes"></span>
                        Paquetes
                    </Link>
                    <Link
                        href="#"
                        :class="{
                            active: route().current(
                                'admin.catalogs.categories.*'
                            ),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('category.read')"
                    >
                        <span class="la la-sitemap"></span>
                        Categorias
                    </Link>
                    <Link
                        href="#"
                        :class="{
                            active: route().current(
                                'admin.catalogs.vehicles.*'
                            ),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('vehicle.read')"
                    >
                        <span class="la la-car-alt"></span>
                        Vehiculos
                    </Link>
                    <Link
                        href="#"
                        :class="{
                            active: route().current('admin.catalogs.media.*'),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('file.read')"
                    >
                        <span class="la la-image"></span>
                        Archivos
                    </Link>
                </div>
            </div>

            <!-- Analytics -->
            <div class="menu-detail" data-menu="analytics">
                <div class="menu-detail-wrapper">
                    <Link
                        href="#"
                        :class="{
                            active: route().current('admin.settings.info'),
                        }"
                        @click="hideMenuDetail"
                    >
                        <span class="la la-archive"></span>
                        Productos
                    </Link>
                    <Link
                        href="#"
                        :class="{
                            active: route().current('admin.settings.info'),
                        }"
                        @click="hideMenuDetail"
                    >
                        <span class="la la-cubes"></span>
                        Ventas
                    </Link>
                    <Link
                        href="#"
                        :class="{
                            active: route().current('admin.settings.info'),
                        }"
                        @click="hideMenuDetail"
                    >
                        <span class="la la-sitemap"></span>
                        Visitas
                    </Link>
                    <Link
                        href="#"
                        :class="{
                            active: route().current('admin.settings.info'),
                        }"
                        @click="hideMenuDetail"
                    >
                        <span class="la la-car-alt"></span>
                        Clientes
                    </Link>
                    <Link
                        href="#"
                        :class="{
                            active: route().current('admin.settings.info'),
                        }"
                        @click="hideMenuDetail"
                    >
                        <span class="la la-image"></span>
                        Envios
                    </Link>
                </div>
            </div>

            <!-- Modules -->
            <div class="menu-detail" data-menu="modules">
                <div class="menu-detail-wrapper">
                    <h6 class="uppercase">Envios</h6>
                    <Link
                        :href="route('admin.settings.info')"
                        :class="{
                            active: route().current('admin.settings.info'),
                        }"
                        @click="hideMenuDetail"
                    >
                        <span class="lab la-fedex"></span>
                        FEDEX
                    </Link>
                    <Link
                        :href="route('admin.settings.info')"
                        :class="{
                            active: route().current('admin.settings.info'),
                        }"
                        @click="hideMenuDetail"
                    >
                        <span class="lab la-dhl"></span>
                        DHL
                    </Link>
                    <Link
                        :href="route('admin.settings.info')"
                        :class="{
                            active: route().current('admin.settings.info'),
                        }"
                        @click="hideMenuDetail"
                    >
                        <span class="lab la-ups"></span>
                        UPS
                    </Link>
                    <Link
                        :href="route('admin.settings.info')"
                        :class="{
                            active: route().current('admin.settings.info'),
                        }"
                        @click="hideMenuDetail"
                    >
                        <span class="hj hj-mercado-libre"></span>
                        Mercado Libre
                    </Link>
                    <Link
                        :href="route('admin.settings.info')"
                        :class="{
                            active: route().current('admin.settings.info'),
                        }"
                        @click="hideMenuDetail"
                    >
                        <span class="la la-shipping-fast"></span>
                        Otros
                    </Link>
                    <hr />
                    <h6 class="uppercase">Pagos</h6>
                    <Link
                        :href="route('admin.settings.info')"
                        :class="{
                            active: route().current('admin.settings.info'),
                        }"
                        @click="hideMenuDetail"
                    >
                        <span class="la la-cc-paypal"></span>
                        PayPal
                    </Link>
                    <!-- <Link :href="route('admin.settings.info')" :class="{'active': route().current('admin.settings.info')}" @click="hideMenuDetail">
                        <span class="la la-cc-visa"></span>
                        BBVA Bancomer
                    </Link> -->
                    <Link
                        :href="route('admin.settings.info')"
                        :class="{
                            active: route().current('admin.settings.info'),
                        }"
                        @click="hideMenuDetail"
                    >
                        <span class="hj hj-bbva"></span>
                        Bancomer
                    </Link>
                </div>
            </div>

            <!-- Support -->
            <div class="menu-detail" data-menu="support">
                <div class="menu-detail-wrapper">
                    <Link
                        :href="route('admin.support.ticket.index')"
                        :class="{
                            active: route().current(
                                'admin.support.ticket.index'
                            ),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('support.read')"
                    >
                        <span class="la la-life-ring"></span>
                        Tickets
                    </Link>
                    <Link
                        :href="route('admin.support.logs')"
                        :class="{
                            active: route().current('admin.settings.logs'),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('log.read')"
                    >
                        <span class="la la-history"></span>
                        Activity Log
                    </Link>
                    <Link
                        :href="route('admin.support.logs')"
                        :class="{
                            active: route().current('admin.settings.logs'),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('log.read')"
                    >
                        <span class="la la-bug"></span>
                        Logs
                    </Link>
                    <Link
                        :href="route('admin.support.console')"
                        :class="{
                            active: route().current('admin.support.console'),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('terminal.read')"
                    >
                        <span class="la la-terminal"></span>
                        Terminal
                    </Link>
                </div>
            </div>

            <!-- Settings -->
            <div class="menu-detail" data-menu="settings">
                <div class="menu-detail-wrapper">
                    <Link
                        :href="route('admin.settings.info')"
                        :class="{
                            active: route().current('admin.settings.info'),
                        }"
                        @click="hideMenuDetail"
                    >
                        <span class="la la-info-circle"></span>
                        Información del Sistema
                    </Link>
                    <hr />
                    <h6 class="uppercase">General</h6>
                    <Link
                        :href="route('admin.settings.info')"
                        :class="{
                            active: route().current('admin.settings.info'),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('store.read')"
                    >
                        <span class="la la-store"></span>
                        Tienda
                    </Link>
                    <Link
                        :href="route('admin.settings.info')"
                        :class="{
                            active: route().current('admin.settings.info'),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('seo.read')"
                    >
                        <span class="la la-bullseye"></span>
                        SEO
                    </Link>
                    <Link
                        :href="route('admin.settings.info')"
                        :class="{
                            active: route().current('admin.settings.info'),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('tag.read')"
                    >
                        <span class="la la-tags"></span>
                        Etiquetas
                    </Link>
                    <Link
                        :href="route('admin.settings.info')"
                        :class="{
                            active: route().current('admin.settings.info'),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('search.read')"
                    >
                        <span class="la la-search"></span>
                        Busqueda
                    </Link>
                    <Link
                        :href="route('admin.settings.general.slider.index')"
                        :class="{
                            active: route().current(
                                'admin.settings.general.slider.index'
                            ),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('slider.read')"
                    >
                        <span class="la la-images"></span>
                        Slider
                    </Link>
                    <hr />
                    <h6 class="uppercase">Avanzado</h6>
                    <Link
                        :href="route('admin.settings.advanced.users.index')"
                        :class="{
                            active: route().current(
                                'admin.settings.advanced.users.*'
                            ),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('user.read')"
                    >
                        <span class="la la-user-tie"></span>
                        Usuarios
                    </Link>
                    <Link
                        :href="
                            route(
                                'admin.settings.advanced.roles.permissions.index'
                            )
                        "
                        :class="{
                            active: route().current(
                                'admin.settings.advanced.roles.permissions.*'
                            ),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('role.read') || $can('permission.read')"
                    >
                        <span class="la la-user-tag"></span>
                        Roles y Permisos
                    </Link>
                    <Link
                        :href="route('admin.settings.advanced.import.index')"
                        :class="{
                            active: route().current(
                                'admin.settings.advanced.import.*'
                            ),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('import.read')"
                    >
                        <span class="la la-cloud-upload-alt"></span>
                        Importar
                    </Link>
                    <Link
                        :href="route('admin.settings.info')"
                        :class="{
                            active: route().current(
                                'admin.settings.advanced.export.*'
                            ),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('export.read')"
                    >
                        <span class="la la-cloud-download-alt"></span>
                        Exportar
                    </Link>
                    <Link
                        :href="route('admin.settings.info')"
                        :class="{
                            active: route().current(
                                'admin.settings.advanced.backup.*'
                            ),
                        }"
                        @click="hideMenuDetail"
                        v-if="$can('backup.read')"
                    >
                        <span class="la la-server"></span>
                        Respaldar
                    </Link>
                </div>
            </div>
        </aside>

        <!-- Content -->
        <main class="workspace">
            <slot></slot>
            <footer class="mt-auto">
                <div class="footer-admin">
                    <span class="uppercase"
                        >© {{ new Date().getFullYear() }} HJ ACCO AUTOPARTES SA
                        DE CV</span
                    >
                    <nav class="ml-auto">
                        <Link
                            class="text-admin hover:text-admin-700"
                            v-text="$t('Support')"
                        />
                        <span class="divider">|</span>
                        <Link
                            class="text-admin hover:text-admin-700"
                            v-text="$t('Docs')"
                        />
                    </nav>
                </div>
            </footer>
        </main>
    </div>
</template>
