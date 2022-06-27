<script setup>
defineProps({
    loading: Boolean,
})
</script>

<template>
    <button :disabled="loading"
        class="flex items-center px-6 py-3 rounded bg-brand-600 text-white text-sm leading-4 font-bold whitespace-nowrap hover:bg-orange-400 focus:bg-orange-400">
        <div v-if="loading" 
            style="border-top-color:transparent"
            class="w-4 h-4 mr-2 border-2 border-brand-700 border rounded-full animate-spin">
        </div>
            <slot />
    </button>
</template>