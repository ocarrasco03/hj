<template>
    <nav class="tab-nav flex flex-col md:flex-row mx-auto border-0">
        <button
            class="nav-link h5 uppercase px-4 py-2 text-black hover:border-primary"
            :class="{'active': tab.props.class }"
            v-for="(tab, index) in tabs"
            :key="tab.props.title"
            @click="selectTab(index)"
            data-toggle="tab"
            :data-target="`#tab-${tab.props.title.toLowerCase()}`"
        >
            {{ tab.props.title }}
        </button>
    </nav>
    <div class="border border-gray-100 px-4 py-3 tab-content">
        <slot></slot>
    </div>
</template>

<script>
export default {
    data() {
        return {
            selectedIndex: 0,
            tabs: [],
            toggling: false,
        };
    },
    created() {
        this.tabs = this.$slots.default();
    },
    methods: {
        selectTab(i) {
            this.selectedIndex = i;

            const trigger = event.target.closest('[data-toggle="tab"]');
            const tabs = trigger.closest(".tabs");
            const activeTabTrigger = tabs.querySelector(".tab-nav .active");
            const activeTab = tabs.querySelector(".collapse.open");
            const targetedTab = tabs.querySelector(trigger.dataset.target);

            if (this.toggling) return;
            if (activeTabTrigger === trigger) return;

            // Trigger
            activeTabTrigger.classList.remove("active");
            trigger.classList.add("active");

            this.toggling = true;
            this.closeCollapse(activeTab, () => {
                this.openCollapse(targetedTab, () => {
                    this.toggling = false;
                });
            });
        },
        openCollapse(collapse, callback) {
            collapse.style.transitionProperty = "height, opacity";
            collapse.style.transitionDuration = "200ms";
            collapse.style.transitionTimingFunction = "ease-in-out";

            setTimeout(() => {
                collapse.style.height = collapse.scrollHeight + "px";
                collapse.style.opacity = 1;
            }, 200);

            collapse.addEventListener(
                "transitionend",
                () => {
                    collapse.classList.add("open");

                    collapse.style.removeProperty("height");
                    collapse.style.removeProperty("opacity");

                    collapse.style.removeProperty("transition-property");
                    collapse.style.removeProperty("transition-duration");
                    collapse.style.removeProperty("transition-timing-function");

                    if (typeof callback === "function") callback();
                },
                { once: true }
            );
        },
        closeCollapse(collapse, callback) {
            collapse.style.overflowY = "hidden";
            collapse.style.height = collapse.scrollHeight + "px";

            collapse.style.transitionProperty = "height, opacity";
            collapse.style.transitionDuration = "200ms";
            collapse.style.transitionTimingFunction = "ease-in-out";

            setTimeout(() => {
                collapse.style.height = 0;
                collapse.style.opacity = 0;
            }, 200);

            collapse.addEventListener(
                "transitionend",
                () => {
                    collapse.classList.remove("open");

                    collapse.style.removeProperty("overflow-y");
                    collapse.style.removeProperty("height");
                    collapse.style.removeProperty("opacity");

                    collapse.style.removeProperty("transition-property");
                    collapse.style.removeProperty("transition-duration");
                    collapse.style.removeProperty("transition-timing-function");

                    if (typeof callback === "function") callback();
                },
                { once: true }
            );
        },
    },
};
</script>
