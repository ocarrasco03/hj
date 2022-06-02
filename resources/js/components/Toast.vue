<script>
export default {
    props: {
        toast: Object,
    },
    data() {
        return {
            visible: false,
            timeout: null,
        };
    },
    watch: {
        toast: {
            deep: true,
            handler() {
                this.visible = true;
                if (this.timeout) {
                    clearTimeout(this.timeout);
                }
                this.timeout = setTimeout(() => (this.visible = false), 5000);
            },
        },
    },
};
</script>

<template>
    <transition name="slide-fade">
        <div
            v-if="toast && visible"
            id="toast-simple"
            class="fixed z-50 top-5 right-5 bg-opacity-75 flex items-center w-full max-w-xs p-4 space-x-4 text-gray-500 bg-white divide-x divide-gray-200 rounded-lg shadow-md dark:text-gray-400 dark:divide-gray-700 space-x dark:bg-gray-800"
            role="alert"
        >
            <div class="mr-2">
                <i
                    class="fal fa-check-circle text-success-900 text-lg"
                    v-if="toast.type === 'success'"
                ></i>
                <i
                    class="fal fa-exclamation-triangle text-warning-900 text-lg"
                    v-else-if="toast.type === 'warning'"
                ></i>
                <i
                    class="fal fa-times-circle text-danger-900 text-lg"
                    v-else
                ></i>
            </div>
            <div class="flex-1 pl-4 font-normal text-secondary-800">
                {{ toast.message }}
            </div>
            <div class="ml-2">
            <!-- <button @click="visible = false"
                class="align-top text-black hover:text-secondary-300 focus:outline-none focus:text-secondary-600"
            >
                <i class="fas fa-times text-sm"></i>
            </button> -->
        </div>
        </div>
    </transition>
</template>

<style>
.slide-fade-enter-active {
    transition: all 0.3s ease;
}
.slide-fade-leave-active {
    transition: all 0.4s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter,
.slide-fade-leave-to {
    transform: translateX(10px);
    opacity: 0;
}
</style>
