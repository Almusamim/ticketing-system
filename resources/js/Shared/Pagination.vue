<script setup>
defineProps({
    links: Array
})
</script>

<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap">
            <template v-for="(link, key) in links">
                
                <div v-if="link.url === null" 
                    :key="key" 
                    class="inactive" 
                    v-html="link.label"
                />
                
                <Link v-else
                    :key="`link-${key}`"
                    :class="{ 'active': link.active }"
                    :href="link.url"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>

<style lang="postcss" scoped>

a, .inactive {
    @apply flex items-center mb-3 mr-2 px-4 py-3 leading-4 text-sm;
}

a {
    @apply bg-white border rounded text-gray-400
        focus:text-brand-500 focus:border-brand-500 focus:border-brand-500
        hover:bg-brand-100 hover:border-brand-500 ;
}
.active {
    @apply bg-brand-100 border-brand-300 text-brand-500 font-bold;
}

.inactive {
    @apply text-gray-300 border rounded;
    cursor: default;
}

</style>