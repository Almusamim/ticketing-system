<template>
    <nav class="bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <Logo />
                    </div>
                    <div class="hidden md:block">
                        
                        <div class="ml-10 flex items-baseline space-x-4">
                            
                            <Link aria-current="page" href="/"
                                class="bg-gray-900 text-white router-link-exact-active px-3 py-2 rounded-md text-sm font-medium">
                                Dashboard
                            </Link>
                            <Link href="/tickets"
                                class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                Tickets
                            </Link>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </nav>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        </div>
    </header>
    <slot />
</template>

<script setup>
import Logo  from "@/Shared/Logo";
</script>