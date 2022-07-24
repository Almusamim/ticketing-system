<script setup>
import FlashMessage from '@/Shared/FlashMessage.vue'
import Nav  from "@/Shared/Nav.vue";
</script>

<template>
    <FlashMessage />
    <Nav />

    <slot />


</template>

<style lang="postcss">

body {
    @apply bg-gray-100;
}

</style>
