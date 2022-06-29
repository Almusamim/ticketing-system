<script setup>
import Pagination from '@/Shared/Pagination'
import DataTable from '@/Shared/DataTable/List'

defineProps({
    users: Object,
    filters: Object,
    can: Object,
});

</script>

<template>
<Head title="Users" />
<Container>
    <template #header>
        <div class="flex justify-between">
            <div  id="tableListSearch"></div>
            <Link v-if="can.createUser" href="/users/create" class="flex items-center px-6 py-3 rounded bg-brand-300 text-brand-700 hover:text-brand-50 leading-4 font-semibold whitespace-nowrap hover:bg-brand-600 focus:bg-brand-700">
                Create User
            </Link>
        </div>
    </template>

    <template #dataTable>
        <div class="overflow-x-auto">
            <DataTable 
                path="users"
                :data="users.data"
                :filters="filters"
                :fields="['name', 'email', 'actions']"
                :showAvatar="true"
            />
        </div>
    </template>
    
    <template #footer>
        <div class="flex justify-between">
            <Pagination :links="users.links" class="mt-6" />
            <div>
                {{ users.total }}
            </div>
        </div>
    </template>
</Container>
</template>