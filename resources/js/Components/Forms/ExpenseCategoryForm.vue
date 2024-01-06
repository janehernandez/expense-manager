<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import TextInput from "@/Components/TextInput.vue";

const name = ref(null);

const props = defineProps({
    category: {
        type: Object,
    },
});

const form = useForm({
    name: props.category?.name || "",
    description: props.category?.description || "",
});

const buttonLabel = computed(() => (props.category ? "Update" : "Save"));
const headerTitle = computed(() =>
    props.category ? "Update Category" : "Add Category"
);

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

    if (props.category) {
        emit("close");
    }
};
const submit = () => {
    const action = props.category
        ? route("expense-categories.update", props.category.id)
        : route("expense-categories.store");
    const method = props.category ? "put" : "post";
    form[method](action, {
        preserveScroll: true,
        onSuccess: () => resetModal(),
        onError: () => name.value.focus(),
    });
};

const deleteCategory = () => {
    form.delete(route("expense-categories.destroy", props.category.id), {
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
                <InputLabel for="name" value="Display Name" />

                <TextInput
                    type="text"
                    name="name"
                    ref="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Type category name"
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
                    placeholder="Type description of the category"
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
                props.category ? 'justify-between' : 'justify-end',
            ]"
        >
            <DangerButton v-if="props.category" @click="deleteCategory">
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
