

<script setup>
import { onMounted, ref } from 'vue';
// import { v4 as uuid } from 'uuid'

defineProps({
    label: {
        type: String,
        default: ''
    },
    type: {
      type: String,
      default: 'text',
    },
    id: {
      type: String,
    },
    error: String,
    modelValue: String,
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div :class="$attrs.class">
        <label v-if="label" class="form-label" :for="id">{{ label }}:</label>
        <input
            ref="input"
            v-bind="{ ...$attrs, class: null }"
            :id="id"
            :class="{ error: error }"
            :type="type"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        >
        <div v-if="error" class="errorMessage" :id="`${uuid}-error`" aria-live="assertive">
            {{ error }}
        </div>
    </div>

</template>

<style lang="postcss" scoped>

input {
    @apply p-2 leading-normal block w-full border text-gray-700 bg-white font-sans rounded text-left appearance-none relative focus:border-brand-500 focus:ring;
}

</style>