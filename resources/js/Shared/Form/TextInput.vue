<template>
    <div :class="$attrs.class">
        <label v-if="label" class="mb-2 block text-gray-700 font-bold select-none" :for="id">{{ label }}</label>

        <input :id="id" ref="input"
            v-bind="{ ...$attrs, class: null }"
            class="p-2 leading-normal block w-full border text-gray-700 bg-white font-sans rounded text-left appearance-none relative focus:border-indigo-400 focus:ring"
            :class="{ error: error }" :type="type" :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        />

        <div v-if="error" class="text-red-700 mt-2 text-sm">{{ error }}</div>
    </div>
</template>

<script>
// import { v4 as uuid } from 'uuid'
export default {
    inheritAttrs: false,
    props: {
        id: {
            type: String,
            required: true
        },
        type: {
            type: String,
            default: 'text',
        },
        error: String,
        label: String,
        modelValue: String,
    },
    // emits: ['update:modelValue'],
    methods: {
        focus() {
            this.$refs.input.focus()
        },
        select() {
            this.$refs.input.select()
        },
        setSelectionRange(start, end) {
            this.$refs.input.setSelectionRange(start, end)
        },
    },
}
</script>

