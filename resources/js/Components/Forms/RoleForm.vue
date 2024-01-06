<script setup>
import { useForm } from "@inertiajs/vue3";
import { nextTick, ref, computed } from "vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import TextInput from "@/Components/TextInput.vue";

const name = ref(null);

const props = defineProps({
    role: {
        type: Object,
    },
});

const form = useForm({
    name: props.role?.name || "",
    description: props.role?.description || "",
});

const buttonLabel = computed(() => (props.role ? "Update" : "Save"));
const headerTitle = computed(() => (props.role ? "Update Role" : "Add Role"));

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

    if (props.role) {
        emit("close");
    }
};
const submit = () => {
    const action = props.role
        ? route("roles.update", props.role.id)
        : route("roles.store");
    const method = props.role ? "put" : "post";
    form[method](action, {
        preserveScroll: true,
        onSuccess: () => resetModal(),
        onError: () => name.value.focus(),
        onFinish: () => resetModal(),
    });
};

const deleteRole = () => {
    form.delete(route("roles.destroy", props.role.id), {
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
                <InputLabel for="role" value="Display Name" />

                <TextInput
                    type="text"
                    name="name"
                    ref="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Type role name"
                    v-model="form.name"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>
            <div class="col-span-2 mt-2">
                <InputLabel for="description" value="Description" />

                <TextInput
                    type="text"
                    name="description"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Type description of the role"
                    v-model="form.description"
                    required
                />

                <InputError class="mt-2" :message="form.errors.description" />
            </div>
        </div>

        <div
            class="flex items-center"
            :class="[
                'flex',
                'items-center',
                props.role ? 'justify-between' : 'justify-end',
            ]"
        >
            <DangerButton v-if="props.role" @click="deleteRole">
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
