require("./bootstrap");

import { createApp, h } from "vue";
import { createInertiaApp, usePage } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { i18nVue } from "laravel-vue-i18n";
import Layout from "@/Layouts/App.vue";
import { initFacebookSdk } from "@/facebook";
import Maska from "maska";
import SimpleTypeahead from "vue3-simple-typeahead";

/**
 * Styles
 */
import "vue3-simple-typeahead/dist/vue3-simple-typeahead.css";

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText ||
    "HJ Autopartes";

initFacebookSdk().then(
    createInertiaApp({
        title: (title) => `${title} - ${appName}`,
        resolve: (name) => {
            const page = require(`./Pages/${name}.vue`).default;
            if (page.layout === undefined && !name.startsWith("Public/")) {
                page.layout = Layout;
            }
            return page;
        },
        setup({ el, app, props, plugin }) {
            return createApp({ render: () => h(app, props) })
                .use(plugin)
                .use(i18nVue, {
                    resolve: (lang) => import(`../../lang/${lang}.json`),
                })
                .use(Maska)
                .use(SimpleTypeahead)
                .mixin({
                    methods: {
                        route,
                        $can: (permission) =>
                            usePage().props.value.permissions.indexOf(
                                permission
                            ) !== -1 || usePage().props.value.isSuperAdmin,
                        $formatPrice: (
                            number,
                            options = {
                                style: "currency",
                                currency: "MXN",
                                minimumFractionDigits: 2,
                            }
                        ) => Intl.NumberFormat("es-MX", options).format(number),
                        back: () => window.history.back(),
                        formatBytes: (size, decimals) => {
                            if (size == 0) return "0 Bytes";
                            let k = 1024,
                                dm = decimals || 2,
                                sizes = [
                                    "Bytes",
                                    "KB",
                                    "MB",
                                    "GB",
                                    "TB",
                                    "PB",
                                    "EB",
                                    "ZB",
                                    "YB",
                                ],
                                i = Math.floor(Math.log(size) / Math.log(k));
                            return (
                                parseFloat(
                                    (size / Math.pow(k, i)).toFixed(dm)
                                ) +
                                " " +
                                sizes[i]
                            );
                        },
                        $formatedDate: (
                            date,
                            options = {
                                year: "numeric",
                                month: "long",
                                day: "numeric",
                            }
                        ) =>
                            new Date(date).toLocaleDateString("es-MX", options),
                    },
                })
                .mount(el);
        },
    })
);

InertiaProgress.init({ color: "#f8a403", showSpinner: true });
