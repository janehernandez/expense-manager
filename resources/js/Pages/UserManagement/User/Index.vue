<script setup>
import dayjs from "dayjs";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Table from "@/Components/Table.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
    users: {
        type: Object,
    },
});

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
                            <template #cell-roles="{ resource }">
                                {{ resource.roles[0].name }}
                            </template>
                            <template #cell-created_at="{ resource }">
                                {{
                                    dayjs(resource.created_at).format(
                                        "YYYY-MM-DD"
                                    )
                                }}
                            </template>
                        </Table>

                        <div class="flex items-center justify-center mt-6">
                            <button
                                v-if="$page.props.auth.user.isAdmin"
                                type="button"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            >
                                Add User
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
