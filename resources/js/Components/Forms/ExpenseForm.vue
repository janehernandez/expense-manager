<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { map } from "lodash";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Select from "@/Components/Select.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
    expense: {
        type: Object,
    },
});

const categories = computed(() => {
    return map(usePage().props.categories, (category) => ({
        label: category.name,
        value: category.id,
    }));
});

const form = useForm({
    expense_category_id: props.expense?.expense_category_id || "",
    amount: props.expense?.amount || "",
    entry_date: props.expense?.entry_date || "",
});

const buttonLabel = computed(() => (props.category ? "Update" : "Save"));
const headerTitle = computed(() =>
    props.category ? "Update Expense" : "Add Expense"
);

const reset = () => {
    form.reset();
    form.clearErrors();
};

const emit = defineEmits(["close"]);

const resetModal = () => {
    reset();
    emit("close");
};

const submit = () => {
    const action = props.expense
        ? route("expenses.update", props.expense.id)
        : route("expenses.store");
    const method = props.expense ? "put" : "post";
    form[method](action, {
        preserveScroll: true,
        onSuccess: () => resetModal(),
    });
};

const deleteExpense = () => {
    console.log(props.expense.id);
    form.delete(route("expenses.destroy", props.expense.id), {
        preserveScroll: true,
        onSuccess: () => resetModal(),
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
            <div class="col-span-2 mt-2">
                <InputLabel for="role" value="Expense Category" />

                <Select
                    v-model="form.expense_category_id"
                    :options="categories"
                    :error="form.errors.expense_category_id"
                    default-label="Please select Expense Category"
                    class="mt-1 block w-3/4"
                />

                <InputError class="mt-2" :message="form.errors.role_id" />
            </div>

            <div class="col-span-2 mt-2">
                <InputLabel for="amount" value="Amount" />

                <TextInput
                    type="text"
                    name="amount"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Type amount"
                    v-model="form.amount"
                    required
                />

                <InputError class="mt-2" :message="form.errors.amount" />
            </div>

            <div class="col-span-2 mt-2">
                <InputLabel for="entry_date" value="Entry Date" />

                <TextInput
                    type="date"
                    name="entry_date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    v-model="form.entry_date"
                    required
                />

                <InputError class="mt-2" :message="form.errors.entry_date" />
            </div>
        </div>

        <div
            class="flex items-center"
            :class="[
                'flex',
                'items-center',
                props.expense ? 'justify-between' : 'justify-end',
            ]"
        >
            <DangerButton v-if="props.expense" @click="deleteExpense">
                Delete
            </DangerButton>
            <div>
                <SecondaryButton @click="cancel"> Cancel </SecondaryButton>
                <PrimaryButton class="text-white ml-2" @click="submit">
                    {{ buttonLabel }}
                </PrimaryButton>
            </div>
        </div>
    </div>
</template>
