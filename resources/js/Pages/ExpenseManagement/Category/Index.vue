<script setup>
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import dayjs from "dayjs";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Table from "@/Components/Table.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import ExpenseCategoryForm from "@/Components/Forms/ExpenseCategoryForm.vue";

defineProps({
    categories: {
        type: Object,
    },
});

const createModal = ref(false);
const updateModal = ref(false);
const category = ref(null);

const showCreateModal = () => {
    createModal.value = true;
};
const showUpdateModal = (resource) => {
    updateModal.value = true;
    category.value = resource;
};

const closeModal = () => {
    if (updateModal.value) {
        category.value = null;
    }

    createModal.value = false;
    updateModal.value = false;
};

const columns = [
    { name: "Category", attribute: "name" },
    { name: "Description", attribute: "description" },
    { name: "Created at", attribute: "created_at" },
];
</script>

<template>
    <Head title="Expense Categories" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Expense Categories
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Table :resources="categories" :columns="columns">
                            <template #cell-name="{ resource }">
                                <div
                                    class="cursor-pointer hover:text-gray-600"
                                    @click="showUpdateModal(resource)"
                                >
                                    {{ resource.name }}
                                </div>
                            </template>
                            <template #cell-description="{ resource }">
                                <div
                                    class="cursor-pointer hover:text-gray-600"
                                    @click="showUpdateModal(resource)"
                                >
                                    {{ resource.description }}
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
                            <PrimaryButton
                                v-if="$page.props.auth.user.isAdmin"
                                @click="showCreateModal"
                            >
                                Add Category
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>

            <Modal :show="createModal" @close="closeModal">
                <ExpenseCategoryForm @close="closeModal" />
            </Modal>

            <Modal :show="updateModal" @close="closeModal">
                <ExpenseCategoryForm :category="category" @close="closeModal" />
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
