<script setup>
import { Head } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";
import dayjs from "dayjs";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Table from "@/Components/Table.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import RoleForm from "@/Components/Roles/RoleForm.vue";

defineProps({
    roles: {
        type: Object,
    },
});

const createModal = ref(false);

const showCreateModal = () => {
    createModal.value = true;
};

const closeModal = () => {
    createModal.value = false;
};

const columns = [
    { name: "Role", attribute: "name" },
    { name: "Description", attribute: "description" },
    { name: "Created at", attribute: "created_at" },
];
</script>

<template>
    <Head title="Roles" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Table :resources="roles" :columns="columns">
                            <template #cell-created_at="{ resource }">
                                {{
                                    dayjs(resource.created_at).format(
                                        "YYYY-MM-DD"
                                    )
                                }}
                            </template>
                        </Table>

                        <div class="flex items-center justify-center mt-6">
                            <PrimaryButton
                                v-if="$page.props.auth.user.isAdmin"
                                @click="showCreateModal"
                            >
                                Create New Role
                            </PrimaryButton>

                            <Modal :show="createModal" @close="closeModal">
                                <RoleForm />
                            </Modal>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
