<script setup>
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import dayjs from "dayjs";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Table from "@/Components/Table.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import ExpenseForm from "@/Components/Forms/ExpenseForm.vue";

defineProps({
    userExpenses: {
        type: Object,
    },
});

const createModal = ref(false);
const updateModal = ref(false);
const expense = ref(null);

const showCreateModal = () => {
    createModal.value = true;
};
const showUpdateModal = (resource) => {
    updateModal.value = true;
    expense.value = resource;
};

const closeModal = () => {
    if (updateModal.value) {
        expense.value = null;
    }

    createModal.value = false;
    updateModal.value = false;
};

const columns = [
    { name: "Expense Category", attribute: "expense_category.name" },
    { name: "Amount", attribute: "amount" },
    { name: "Entry Date", attribute: "entry_date" },
    { name: "Created at", attribute: "created_at" },
];
</script>

<template>
    <Head title="Expenses" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Expenses
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Table :resources="userExpenses" :columns="columns">
                            <template
                                #cell-expense_category.name="{ resource }"
                            >
                                <div
                                    class="cursor-pointer hover:text-gray-600"
                                    @click="showUpdateModal(resource)"
                                >
                                    {{ resource.expense_category.name }}
                                </div>
                            </template>
                            <template #cell-amount="{ resource }">
                                <div
                                    class="cursor-pointer hover:text-gray-600"
                                    @click="showUpdateModal(resource)"
                                >
                                    $ {{ resource.amount }}
                                </div>
                            </template>
                            <template #cell-entry_date="{ resource }">
                                <div
                                    class="cursor-pointer hover:text-gray-600"
                                    @click="showUpdateModal(resource)"
                                >
                                    {{ resource.entry_date }}
                                </div>
                            </template>
                            <template #cell-created_at="{ resource }">
                                <div
                                    class="cursor-pointer hover:text-gray-600"
                                    @click="showUpdateModal(resource)"
                                >
                                    {{
                                        dayjs(resource.created_at).format(
                                            "YYYY-MM-DD"
                                        )
                                    }}
                                </div>
                            </template>
                        </Table>

                        <div class="flex items-center justify-center mt-6">
                            <PrimaryButton @click="showCreateModal">
                                Add Expense
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>
            <Modal :show="createModal" @close="closeModal">
                <ExpenseForm @close="closeModal" />
            </Modal>
            <Modal :show="updateModal" @close="closeModal">
                <ExpenseForm :expense="expense" @close="closeModal" />
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
