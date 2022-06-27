<script setup>
import { Inertia } from '@inertiajs/inertia';
import { reactive, watch } from 'vue';
import debounce from 'lodash/debounce'
import Layout  from '@/Shared/Layout'
import Pagination from '@/Shared/Pagination'
import DataTable from '@/Shared/DataTable/List'
import LoadingButton from '@/Shared/Form/LoadingButton'

// TODO: move Datatable logic into its own component
let props = defineProps({
    tickets: Object,
    filters: Object,
    can: Object
});

let params = reactive({ 
    search: props.filters.search,
    sortby: props.filters.sortby,
    direction: props.filters.direction
})

watch(params, debounce(function () {
    Object.keys(params).forEach((name, key) => {
        // let ms = name != 'search' ? 0 : 300;
        // console.log(ms)
        if(params[key] == '')
        {
            delete params[key];
        }
    })

    Inertia.get('/tickets', params, { preserveState: true, replace: true });
}, 300))


function sortTable(field) {
    params.sortby = field;
    params.direction = params.direction === 'asc' ? 'desc' : 'asc';
}

</script>

<template>
<Layout>
    <Head Title="Tickets" />
    <template #header>
        <div class="flex justify-between">
            <input v-model="params.search" type="text" placeholder="Search..." class="border px-6 py-3 rounded-lg" />
            <Link href="/tickets/create" class="flex items-center px-6 py-3 rounded bg-brand-300 text-brand-700 hover:text-brand-50 leading-4 font-semibold whitespace-nowrap hover:bg-brand-600 focus:bg-brand-700">
                Create Ticket
            </Link>
        </div>
    </template>

    <template #dataTable>
        <div class="overflow-x-auto">
            <DataTable 
                :can="can"
                :data="tickets.data"
                :fields="['id', 'title', 'body', 'author', 'status', 'actions']"
                :showAvatar="true"
                editLink="tickets"
                @dataSortBy="sortTable"
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
</Layout>
</template>