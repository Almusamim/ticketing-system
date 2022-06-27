<script setup>
defineProps({
    data: Object
})

function nameInitials(string) {
    let name = string.split(' '),
        initials = name[0].substring(0, 1).toUpperCase();
    
    if (name.length > 1) {
        initials += name[name.length - 1].substring(0, 1).toUpperCase();
    }
    return initials;
}

</script>

<template>
<div class="flex">
    <div class="flex-shrink-0 w-10 h-10">
        <img 
            class="w-full h-full rounded-full" 
            v-if="data['avatar']" 
            :src="data['avatar']"
            :alt="data.name"
        />
        <div v-else class="avatar-placeholder">
            {{ nameInitials(data.name) }}
        </div>
    </div>
    <div class="ml-3 " >
        <p class="text-gray-900 whitespace-no-wrap ">
            {{ data.name }}
        </p>
        <p class="text-gray-600 whitespace-no-wrap text-xs">
            ID {{data['id']}}
        </p>
    </div>
</div>
</template>

<style lang="postcss" scoped>
.avatar-placeholder {
    @apply flex-shrink-0 w-10 h-10 relative flex justify-center items-center rounded-full bg-brand-500 text-lg text-white uppercase;
    cursor: default;
}
</style>