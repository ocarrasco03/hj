<script setup>
import tippy from "tippy.js";
import { computed, onMounted, onUnmounted, ref } from "vue";

const props = defineProps({
    buttonClasses: {
        default: () => {
            ["flex", "items-center", 'justify-center'];
        },
    },
    contentClases: {
        default: () => {
            [];
        },
    },
});

onMounted(() => {
    tippy('[data-toggle="dropdown-menu"]', {
        theme: "light-border",
        zIndex: 25,
        offset: [0, 8],
        arrow: false,
        placement: "bottom-start",
        interactive: true,
        allowHTML: true,
        animation: "shift-toward-extreme",
        content: (reference) => {
            let dropdownMenu = reference
                .closest(".dropdown")
                .querySelector(".dropdown-menu");
            dropdownMenu = dropdownMenu.outerHTML;
            return dropdownMenu;
        },
    });
});
</script>

<template>
    <div class="dropdown">
        <div>
            <button
                :class="buttonClasses"
                data-toggle="dropdown-menu"
            >
                <slot name="trigger" />
            </button>
        </div>
        <div class="dropdown-menu" :class="contentClases">
            <slot name="menu" />
        </div>
    </div>
</template>
