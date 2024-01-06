<script setup>
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import dayjs from "dayjs";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Table from "@/Components/Table.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import UserForm from "@/Components/Forms/UserForm.vue";

defineProps({
    users: {
        type: Object,
    },
});

const createModal = ref(false);
const updateModal = ref(false);
const user = ref(null);

const emit = defineEmits(["close"]);

const showCreateModal = () => {
    createModal.value = true;
};
const showUpdateModal = (resource) => {
    updateModal.value = true;
    user.value = resource;
};

const closeModal = () => {
    if (updateModal.value) {
        user.value = null;
    }

    createModal.value = false;
    updateModal.value = false;
};

const columns = [
    { name: "Name", attribute: "name" },
    { name: "Email Address", attribute: "email" },
    { name: "Role", attribute: "roles" },
    { name: "Created at", attribute: "created_at" },
];
</script>

<template>
    <Head title="Users" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Table :resources="users" :columns="columns">
                            <template #cell-name="{ resource }">
                                <div
                                    class="cursor-pointer hover:text-gray-600"
                                    @click="showUpdateModal(resource)"
                                >
                                    {{ resource.name }}
                                </div>
                            </template>
                            <template #cell-email="{ resource }">
                                <div
                                    class="cursor-pointer hover:text-gray-600"
                                    @click="showUpdateModal(resource)"
                                >
                                    {{ resource.email }}
                                </div>
                            </template>
                            <template #cell-roles="{ resource }">
                                <div
                                    class="cursor-pointer hover:text-gray-600"
                                    @click="showUpdateModal(resource)"
                                >
                                    {{ resource.roles[0]?.name }}
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
                                Add User
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>

            <Modal :show="createModal" @close="closeModal">
                <UserForm @close="closeModal" />
            </Modal>

            <Modal :show="updateModal" @close="closeModal">
                <UserForm :user="user" @close="closeModal" />
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
