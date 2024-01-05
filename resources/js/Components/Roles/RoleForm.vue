<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
</script>

<template>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">Add New Role</h2>

        <form class="p-4 md:p-5">
            <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">
                    <label
                        for="name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Name</label
                    >
                    <input
                        type="text"
                        name="name"
                        ref="roleInput"
                        id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Type role name"
                    />
                </div>
                <div class="col-span-2">
                    <label
                        for="description"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Description</label
                    >
                    <input
                        type="text"
                        name="description"
                        ref="description"
                        id="description"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Type description of the role"
                    />
                </div>
            </div>

            <PrimaryButton
                v-if="$page.props.auth.user.isAdmin"
                class="text-white inline-flex items-center"
            >
                Add
            </PrimaryButton>
        </form>
    </div>
</template>
