<template>
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <slot name="header"></slot>
    </div>
</header>

<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 sm:px-0">
            <div :class="!$slots.dataTable && 'animate-fade-in-down' ">
                <div class="shadow-md sm:rounded-md sm:overflow-hidden">
                    <div class="bg-white space-y-6" :class="!$slots.dataTable && 'px-4 py-5 sm:p-6'">
                        
                        <slot></slot>
                        
                        <template v-if="$slots.dataTable">
                            <slot name="dataTable"></slot>
                        </template>

                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6" v-if="$slots.footer">
                        <slot name="footer"></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</template>