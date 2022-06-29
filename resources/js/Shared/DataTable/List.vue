<script setup>
import { SortAscendingIcon, SortDescendingIcon } from '@heroicons/vue/solid'
import Avatar from '@/Shared/DataTable/_avatar'
import Action from '@/Shared/DataTable/_actions'

import { Inertia } from '@inertiajs/inertia';
import { reactive, watch } from 'vue';
import debounce from 'lodash/debounce'

let props = defineProps({
    data: Object,
    filters: Object,
    can: Object,

    fields: Array,
    path: String,
    notSortable: {
        type: Array,
        default: () => ['can', 'author', 'actions']
    },
    showAvatar: {
        type: Boolean,
        default: false
    }
})

let params = reactive({ 
    search: props.filters.search,
    sortby: props.filters.sortby,
    direction: props.filters.direction
})

watch(params, debounce(function () {
    Object.keys(params).forEach((name) => {
        params[name] == '' &&  delete params[name];
    })
    Inertia.get(props.path, params, { preserveState: true, replace: true });
}, 300))

// TODO fix Default orderby 
function sortTable(field) {
    params.sortby = field;
    params.direction = params.direction === 'asc' ? 'desc' : 'asc';
}

</script>

<template>
    <Teleport to="#tableListSearch">
        <input v-model="params.search" type="text" placeholder="Search..." class="border px-6 py-3 rounded-lg" />
    </Teleport>

    <table v-if="data.length">
        <thead>
            <tr>
                <template v-for="field in Object.keys(data[0])">
                    <template v-if="fields.includes(field)">
                        <th :key="field.id">
                            <span @click="sortTable(field)" v-if="!notSortable.includes(field)" class="flex font-bold">
                                {{ field }} 
                                <SortAscendingIcon class="w-4 h-4 ml-1" v-if="field == $page.props.filters.sortby && $page.props.filters.direction == 'asc'" />
                                <SortDescendingIcon class="w-4 h-4  ml-1"  v-if="field == $page.props.filters.sortby && $page.props.filters.direction == 'desc'" />
                            </span>
                            <template v-else-if="field != 'actions'">
                                {{ field }}
                            </template>
                        </th>
                    </template>
                </template>
            </tr>
        </thead>
        <tbody>
            <tr v-for="key of data.length">
                <template v-for="(fieldValue, propName, index) in data[--key]">
                    <template v-if="fields.includes(propName)">
                        <td :key="index">
                            <Avatar v-if="propName == 'name' && showAvatar" :data="data[key]" />
                            <Avatar v-else-if="propName == 'author'" :data="fieldValue" />
                            <div v-else-if="propName == 'status'" class="text-center">
                                <span class="text-4xl" :class="fieldValue == 1 ? 'text-green-500': 'text-red-500'">&#8226;</span>
                            </div>
                            <Action v-else-if="propName == 'actions'" :editLink="path" :data="data[key]" :can="can" />
                            <div v-else>{{ fieldValue }} </div>                            
                        </td>
                    </template>
                </template>
            </tr>
        </tbody>

    </table>

    <div v-else class="flex justify-center p-6 text-3xl font-bold text-brand-300">
        No results found
    </div>
</template>

<style lang="postcss" scoped>
table {
    @apply min-w-full leading-normal;
    
    thead {
        th {
            @apply px-5 py-6 border-b-2 border-brand-300 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider;
            span {
                cursor: pointer;
            }
        }
    }
    tbody {
        td {
            @apply px-5 py-5 border-b border-gray-200 bg-white text-sm;
        }
    }
}
</style>