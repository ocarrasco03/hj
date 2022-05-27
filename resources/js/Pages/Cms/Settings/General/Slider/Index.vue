<script setup>
import { onMounted, ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import draggable from "vuedraggable";
import Slider from "@/Components/Slider";

const props = defineProps({
    sliders: Object,
});

const form = useForm({
    image: null,
});

const updateForm = useForm({
    slides: props.sliders.data.media,
});

const submit = () => {
    form.post(route("admin.settings.general.slider.store", { slider: 1 }), {
        preserveScroll: true,
        preserveState: false,
    });
};

const update = () => {
    updateForm.put(
        route("admin.settings.general.slider.update", { slider: 1 }),
        {
            onSuccess: () => updateForm.reset(),
            onFinish: () => updateForm.reset(),
        }
    );
};

const deleteSlide = (index) => {
    updateForm.slides.splice(index, 1);
    document.getElementById(`delete-${index}`).click();
};

const upload = () => {
    document.getElementById("uploadFile").click();
};

const dragover = event => {
    event.preventDefault();
    /**
     * Add some visual  fluff to show the user can drop its files
     */
    if (!event.currentTarget.classList.contains('dropzone'))
    {
        //
    }
}

const dragleave = event => {
    /**
     * Clean up
     */
}

const drop = event => {
    event.preventDefault()
    document.getElementById("uploadFile").files = event.dataTransfer.files;
    form.image = event.dataTransfer.files;
    submit();
}
</script>

<script context="module">
import AdminLayout from "@/Layouts/Admin.vue";

export default {
    layout: AdminLayout,
};
</script>

<template>
    <Head title="Slider" />

    <!-- Breadcrumb -->
    <section class="breadcrumb">
        <h1>Sliders</h1>
        <ul>
            <li>
                <Link :href="route('admin.dashboard')">
                    <span class="la la-home"></span>
                </Link>
            </li>
            <li class="divider la la-arrow-right"></li>
            <li>
                <Link v-text="'Configuraci&oacute;n'" />
            </li>
            <li class="divider la la-arrow-right"></li>
            <li>
                <Link v-text="'General'" />
            </li>
            <li class="divider la la-arrow-right"></li>
            <li>Sliders</li>
        </ul>
    </section>
    <Slider :images="sliders.data.media" :delay="1500" />

    <div class="card w-full p-4 mt-5">
        <form @submit.prevent="update">
            <draggable
                v-model="updateForm.slides"
                tag="transition-group"
                handle=".handle"
                item-key="uuid"
            >
                <template #item="{ element, index }">
                    <div class="flex space-x-4 p-2 hover:shadow rounded-sm">
                        <div
                            class="flex items-center justify-center text-lg handle hover:cursor-move"
                        >
                            <i class="la la-bars"></i>
                        </div>
                        <img :src="element.preview_url" class="max-h-32" />
                        <div class="flex flex-col justify-end">
                            <span class="uppercase">{{
                                element.extension
                            }}</span>
                            <small class="uppercase">{{ element.size }}</small>
                            <!-- <span class="hover:underline cursor-pointer">
                                <i class="mr-2 la la-cloud-download-alt"></i>
                                {{ $t("Download") }}
                            </span> -->
                        </div>
                        <div
                            class="flex flex-col flex-1 items-end justify-between"
                        >
                            <button
                                type="button"
                                @click="deleteSlide(index)"
                                class="btn btn-icon btn-danger btn-outlined rounded-full"
                            >
                                <i class="la la-trash"></i>
                            </button>
                            <Link
                                :href="
                                    route(
                                        'admin.settings.general.slider.delete',
                                        {
                                            slider: 1,
                                            uuid: element.uuid,
                                        }
                                    )
                                "
                                method="delete"
                                as="button"
                                class="hidden"
                                :id="`delete-${index}`"
                            />
                            <div class="w-full">
                                <label for="name">{{ $t('Name') }}</label>
                                <input
                                    id="name"
                                    v-model="element.name"
                                    class="form-control"
                                    type="text"
                                />
                            </div>
                        </div>
                    </div>
                </template>
            </draggable>
            <div
                class="flex items-center justify-end mt-5"
                v-if="updateForm.isDirty"
            >
                <button type="submit" class="btn btn-admin">
                    {{ $t("Save") }}
                </button>
            </div>
        </form>

        <form @submit.prevent="submit" :disabled="form.processing">
            <div
                id="uploadFileZone"
                class="dropzone my-5 cursor-pointer"
                :class="{'bg-gray-100 cursor-not-allowed': form.processing}"
                @click="upload"
                @drop="drop"
                @dragover="dragover"
                @dragleave="dragleave"
                :disabled="form.processing"
            >
                <h3>{{ $t('Drop files here to upload') }}</h3>
                <input
                    type="file"
                    @input="form.image = $event.target.files[0]"
                    id="uploadFile"
                    @change="submit"
                    class="hidden"
                    multiple
                    :disabled="form.processing"
                />
            </div>
        </form>
    </div>
</template>
