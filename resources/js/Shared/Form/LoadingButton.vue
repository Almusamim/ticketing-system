<script setup>
defineProps({
    loading: Boolean,
})
</script>

<template>
    <button :disabled="loading">
        <div v-if="loading" class="loader"></div>
            <slot />
    </button>
</template>

<style lang="postcss" scoped>

button {
    @apply flex justify-center items-center px-6 py-3 bg-brand-600 text-white text-sm leading-4 font-bold whitespace-nowrap rounded hover:bg-orange-400 focus:bg-orange-400;
    min-width: 120px;
    .loader {
        @apply w-4 h-4 mr-2 border-2 border-brand-700 border rounded-full animate-spin;
        border-top-color: transparent;
    }
}

</style>