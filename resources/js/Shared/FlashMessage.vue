<script setup>
import { ref, watch } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'
import { CheckIcon, XIcon, ExclamationCircleIcon } from '@heroicons/vue/solid'

const show = ref(false)

watch(() => usePage().props.value.flash,
    (flash) => {
        // console.log(usePage())
        show.value = true
        setTimeout(() => {
            show.value = false
        }, 5000)
    }, { deep: true }
)
</script>


<template>
<div class="flash">
    <div v-if="$page.props.flash.success && show"
        class="flex items-center justify-between mb-8 max-w-3xl bg-green-500 rounded"
    >
        <div class="flex items-center">
            <CheckIcon class="flex-shrink-0 ml-4 mr-2 w-8 h-8 fill-white" />
            <div class="py-4 text-white text-sm font-medium">
                {{ $page.props.flash.success }}
            </div>
        </div>
        <button type="button" class="group mr-2 p-2" @click="show = false">
            <XIcon class="w-6 h-6 fill-green-800 group-hover:fill-white" />
        </button>
    </div>

    <div v-if="($page.props.flash.error || Object.keys($page.props.errors).length > 0) && show"
        class="flex items-center justify-between mb-8 max-w-3xl bg-red-500 rounded"
    >
        <div class="flex items-center">
            <ExclamationCircleIcon class="flex-shrink-0 ml-4 mr-2 w-8 h-8 fill-white" />
            <div v-if="$page.props.flash.error" class="py-4 text-white text-sm font-medium">
                {{ $page.props.flash.error }}
            </div>
            <div v-else class="py-4 text-white text-sm font-medium">
                <span v-if="Object.keys($page.props.errors).length === 1">There is one form error.</span>
                <span v-else>There are {{ Object.keys($page.props.errors).length }} form errors.</span>
            </div>
        </div>
        <button type="button" class="group mr-2 p-2" @click="show = false">
            <XIcon class="w-6 h-6 fill-red-800 group-hover:fill-white" />
        </button>
    </div>
</div>

</template>

<style scoped>
.flash {
    position: fixed;
    bottom: 10px;
    right: 25px;
    min-width: 245px;
    z-index: 1000;
}
</style>