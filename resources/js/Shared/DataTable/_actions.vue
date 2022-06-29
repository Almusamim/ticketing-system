<script setup>
import { PencilAltIcon } from '@heroicons/vue/outline'
defineProps({
    data: {
        type: Object,
        required: true
    },
     can: {
        type: Object,
        // required: true
    },
    editLink: {
        type: String
    }
})
</script>

<template>
<div class="flex justify-end">
    <Link :href="`/${editLink}/${data.id}/edit`" v-if="data.is_owner || data.actions.edit">
        <span>Edit</span>
        <PencilAltIcon class="icon-size" />
    </Link>
</div>
</template>

<style lang="postcss">
a {
    @apply text-brand-600 hover:text-brand-900;
    span {
        @apply text-sm;
    }
}

.icon-size {
    @apply w-6 h-6;
}
</style>