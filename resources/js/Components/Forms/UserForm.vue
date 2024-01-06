<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import { map } from "lodash";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Select from "@/Components/Select.vue";

const name = ref(null);
const roles = computed(() => {
    return map(usePage().props.roles, (role) => ({
        label: role.name,
        value: role.id,
    }));
});

const props = defineProps({
    user: {
        type: Object,
    },
});

const form = useForm({
    name: props.user?.name || "",
    email: props.user?.email || "",
    role_id: props.user?.roles[0]?.id || "",
});

const buttonLabel = computed(() => (props.user ? "Update" : "Save"));
const headerTitle = computed(() => (props.user ? "Update User" : "Add User"));

const reset = () => {
    form.reset();
    form.clearErrors();
};

const emit = defineEmits(["close"]);

const resetModal = () => {
    reset();
    if (name.value) {
        name.value.focus();
    }

    emit("close");
};
const submit = () => {
    const action = props.user
        ? route("users.update", props.user.id)
        : route("users.store");

    const method = props.user ? "put" : "post";
    form[method](action, {
        preserveScroll: true,
        onSuccess: () => resetModal(),
        onError: () => name.value.focus(),
    });
};

const deleteUser = () => {
    form.delete(route("users.destroy", props.user.id), {
        preserveScroll: true,
        onSuccess: () => resetModal(),
        onError: () => name.value.focus(),
        onFinish: () => resetModal(),
    });
};

const cancel = () => {
    emit("close");
};
</script>

<template>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">{{ headerTitle }}</h2>

        <div class="grid gap-4 mb-4 grid-cols-2">
            <div class="mt-2 col-span-2">
                <InputLabel for="name" value="Name" />

                <TextInput
                    type="text"
                    name="name"
                    ref="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Enter your name"
                    v-model="form.name"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>
            <div class="col-span-2 mt-2">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    v-model="form.email"
                    required
                    autocomplete="username"
                    placeholder="Enter your email"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="col-span-2 mt-2">
                <InputLabel for="role" value="Role" />

                <Select
                    v-model="form.role_id"
                    :options="roles"
                    :error="form.errors.role_id"
                    default-label="Please select Role"
                    class="mt-1 block w-3/4"
                />

                <InputError class="mt-2" :message="form.errors.role_id" />
            </div>
        </div>

        <div
            class="flex items-center"
            :class="[
                'flex',
                'items-center',
                props.user && $page.props.auth.user.email !== props.user?.email
                    ? 'justify-between'
                    : 'justify-end',
            ]"
        >
            <DangerButton
                v-if="
                    props.user &&
                    $page.props.auth.user.email !== props.user?.email
                "
                @click="deleteUser"
            >
                Delete
            </DangerButton>
            <div>
                <SecondaryButton @click="cancel"> Cancel </SecondaryButton>
                <PrimaryButton
                    v-if="$page.props.auth.user.isAdmin"
                    class="text-white ml-2"
                    @click="submit"
                >
                    {{ buttonLabel }}
                </PrimaryButton>
            </div>
        </div>
    </div>
</template>
