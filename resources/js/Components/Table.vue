<script setup>
import { computed } from "vue";
import { split, size } from "lodash";

const props = defineProps({
    resources: {
        type: Array,
        required: true,
    },
    columns: {
        type: Array,
        required: true,
    },
});

const totalResources = computed(() => size(props.resources));
const totalColumns = computed(() => size(props.columns));

const getResourceAttribute = (resource, attribute) => {
    const nodes = split(attribute, ".");
    let key = resource;

    nodes.forEach((value) => {
        key = key[value] || "";
    });

    return key;
};
</script>

<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
                <tr>
                    <th
                        v-for="column in columns"
                        :key="`columns-${column.name}`"
                        scope="col"
                        class="px-6 py-3"
                    >
                        {{ column.name }}
                    </th>
                </tr>
            </thead>

            <tbody v-if="totalResources > 0">
                <tr v-for="resource in resources" :key="resource.id">
                    <td
                        v-for="column in columns"
                        :key="`cell-${resource.id}-${column.name}`"
                        class="px-6 py-4"
                    >
                        <slot
                            :name="`cell-${column.attribute}`"
                            v-bind="{ column, resource }"
                        >
                            {{
                                getResourceAttribute(resource, column.attribute)
                            }}
                        </slot>
                    </td>
                </tr>
            </tbody>

            <tbody v-else>
                <tr>
                    <td class="py-2 text-center" :colspan="totalColumns">
                        No Records Found
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
