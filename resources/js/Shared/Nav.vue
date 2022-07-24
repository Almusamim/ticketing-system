<script>
import Logo  from '@/Shared/Logo.vue'
export default {
  components: {
        Logo,
    },
    methods: {
        isUrl(...urls) {
            let currentUrl = this.$page.url.substr(1)
            if (urls[0] === '') {
                return currentUrl === ''
            }
            return urls.filter((url) => currentUrl.startsWith(url)).length
        },
    },
}
</script>

<template>
<nav class="bg-brand-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <Logo />
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <Link aria-current="page" href="/" class="nav-link" :class="isUrl('') && 'nav-link-active'">
                            Dashboard
                        </Link>
                        <Link href="/tickets" class="nav-link" :class="isUrl('tickets') && 'nav-link-active'">
                            Tickets
                        </Link>
                        <Link href="/users" class="nav-link" :class="isUrl('users') && 'nav-link-active'">
                            Users
                        </Link>
                    </div>
                </div>
            </div>

            <div class="flex">
                <Link href="/logout" method="post" as="button" class="nav-link">Log Out</Link>
            </div>
        </div>
    </div>
</nav>
</template>

<style lang="postcss" scoped>
a {
    @apply text-white;
}

.nav-link {
    @apply px-3 py-2 rounded-md bg-brand-600 hover:bg-brand-700 text-brand-200 hover:text-brand-100 text-sm font-medium transition-all;
}
.nav-link-active {
    @apply bg-brand-700 text-white;
}
</style>