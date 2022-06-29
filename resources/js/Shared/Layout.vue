<script setup>
import FlashMessage from '@/Shared/FlashMessage'
import Nav  from "@/Shared/Nav";
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
