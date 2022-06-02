<script setup>
const props = defineProps({
    headers: {
        type: Array,
        default: [],
    },
    values: Object,
});
const selected = ref([]);
</script>

<template>
    <table class="table table-admin w-full">
        <thead>
            <tr>
                <th class="w-px hidden md:table-cell">
                    <label class="admin-checkbox">
                        <input
                            type="checkbox"
                            :checked="selected.length > 0"
                            :partial="selected.length < values && selected.length > 0 ? true : null"
                            disabled
                        />
                        <span></span>
                    </label>
                </th>
                <th v-for="(head, key) in headers" :key="key">
                    {{ head }}
                </th>
            </tr>
        </thead>
    </table>
</template>
