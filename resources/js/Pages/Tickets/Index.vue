<script setup>
import Pagination from '@/Shared/Pagination'
import DataTable from '@/Shared/DataTable/List'

defineProps({
    tickets: Object,
    filters: Object,
    can: Object
});
</script>

<template>
<Head title="Tickets" />
<Container>
    <template #header>
        <div class="flex justify-between">
            <div  id="tableListSearch"></div>
            <Link href="/tickets/create" class="flex items-center px-6 py-3 rounded bg-brand-300 text-brand-700 hover:text-brand-50 leading-4 font-semibold whitespace-nowrap hover:bg-brand-600 focus:bg-brand-700">
                Create Ticket
            </Link>
        </div>
    </template>

    <template #dataTable>
        <div class="overflow-x-auto">
            <DataTable 
                path="tickets"
                :data="tickets.data"
                :filters="filters"
                :fields="['id', 'title', 'author', 'status', 'actions']"
                :showAvatar="true"
            />
        </div>
    </template>
    
    <template #footer>
        <div class="flex justify-between">
            <Pagination :links="tickets.links" class="mt-6" />
            <div class="p-3 font-bold text-sm">
                Total: {{ tickets.total }}
            </div>
        </div>
    </template>
</Container>
</template>