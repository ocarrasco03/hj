<script setup>
import Modal from "./Modal.vue";
const emit = defineEmits(["close"]);
defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: "2xl",
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});
const close = () => {
    emit("close");
};
</script>

<template>
    <Modal
        :show="show"
        :max-width="maxWidth"
        :closeable="closeable"
        @close="close"
    >
        <div class="flex flex-shrink-0 items-center p-5 border-b border-gray-200">
            <slot name="title" />
        </div>
        <div class="m-5">
            <slot name="content" />
        </div>
        <div class="flex flex-shrink-0 p-5 border-t border-gray-200">
            <div class="flex ml-auto">
                <slot name="footer" />
            </div>
        </div>
    </Modal>
</template>
