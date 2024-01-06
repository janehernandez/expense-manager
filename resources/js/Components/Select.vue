<script>
export default {
    props: {
        hint: String,
        modelValue: [String, Number],
        error: String,
        options: {
            type: Object,
            required: true,
        },
        defaultLabel: {
            type: String,
            default: "Select",
        },
    },

    emits: ["update:modelValue", "change"],

    data() {
        return {
            selected: this.modelValue,
            optionList: null,
        };
    },

    watch: {
        modelValue(value) {
            this.selected = value;
        },
        selected(selected) {
            this.$emit("update:modelValue", selected);
            this.$emit("change", selected);
        },
        options: {
            handler(options) {
                this.optionList = [
                    { label: this.defaultLabel, value: "" },
                ].concat(options);
            },
            deep: true,
        },
    },

    mounted() {
        this.optionList = [{ label: this.defaultLabel, value: "" }].concat(
            this.options
        );
    },
};
</script>

<template>
    <div class="input-group mb-3">
        <select
            v-model="selected"
            :class="[error ? 'is-invalid' : '']"
            class="form-select rounded border"
        >
            <option
                v-for="option in optionList"
                :key="`${new Date().getTime()}-${option.label}-${option.value}`"
                :value="option.value"
            >
                {{ option.label }}
            </option>
        </select>

        <div v-if="hint" class="form-text w-100">
            {{ hint }}
        </div>
    </div>
</template>
