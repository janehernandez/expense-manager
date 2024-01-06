<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Table from "@/Components/Table.vue";

const props = defineProps({
    summary: {
        type: Object,
    },
    categories: {
        type: Array,
    },
    percentages: {
        type: Array,
    },
});

const columns = [
    { name: "Expense Categories", attribute: "category" },
    { name: "total", attribute: "total_amount" },
];

const series = ref(props.percentages);
const chartOptions = {
    labels: props.categories,
    responsive: [
        {
            breakpoint: 480,
            options: {
                chart: {
                    width: 200,
                },
                legend: {
                    position: "bottom",
                },
            },
        },
    ],
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 flex flex-row">
                        <!-- Table Container -->
                        <div class="flex-1">
                            <Table
                                :resources="props.summary"
                                :columns="columns"
                            >
                                <template #cell-total_amount="{ resource }">
                                    $ {{ resource.total_amount }}
                                </template>
                            </Table>
                        </div>

                        <!-- Chart Container -->
                        <div class="flex-1 flex items-center justify-center">
                            <apexchart
                                type="pie"
                                :width="500"
                                :options="chartOptions"
                                :series="series"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
