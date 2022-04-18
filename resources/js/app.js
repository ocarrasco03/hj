require("./bootstrap");

import { createApp, h } from "vue";
import { createInertiaApp, usePage } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import Layout from "@/Layouts/App.vue";
import { initFacebookSdk } from "@/facebook";

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
                .mixin({
                    methods: {
                        route,
                        $can: (permission) =>
                            usePage().props.value.permissions.indexOf(
                                permission
                            ) !== -1 || usePage().props.value.isSuperAdmin,
                    },
                })
                .mount(el);
        },
    })
);

InertiaProgress.init({ color: "#f8a403", showSpinner: true });
