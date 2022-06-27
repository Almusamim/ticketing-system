<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import LoadingButton from '@/Shared/Form/LoadingButton'
import { PlusSmIcon } from '@heroicons/vue/solid'

let form = useForm({
    body: '',
    ticket_id: props.ticketId
});

const props = defineProps({
    data: {
        type: Array
    },
    ticketId: {
        type: [String, Number]
    },
})

let submit = () => {
    form.post('/comment', {
        preserveScroll: false,
        onSuccess: () => { 
            form.reset('body')
            scrollToView()
        },
    });
};

const scrollToView = () => {
    document.querySelector('#comment').scrollIntoView({ 
        behavior: "smooth",
        block: "end" 
    });
};
</script>

<template>
<div class="px-4 py-5 space-y-6 sm:p-6">
    <h3 class="text-2xl font-semibold flex items-center justify-between">
        Answers
        <a
            href="#comment"
            class="flex items-center text-sm py-1 px-4 rounded-sm text-white bg-gray-600 hover:bg-gray-700">
            <PlusSmIcon class="h-4 w-4"/>
            Reply
        </a>
    </h3>
    <div v-if="data.length < 0" class="text-center text-gray-600"> You don't have any comments </div>
    <div v-else v-for="comment in data" :key="comment.id">
        <div class="p-6 m-3 bg-white rounded shadow text-left">
            <p>{{ comment.body }}</p>
            <h5 class="font-bold">
                {{ comment.user.name }}
                @  <span class="font-semibold text-gray-400">{{ new Date(comment.user.created_at).toLocaleString('sv-SE') }}</span>
            </h5>
        </div>
    </div>

    <form @submit.prevent="submit" class="p-8 bg-black-900 rounded shadow-lg" id="comment">
        <textarea class="w-full h-full py-4 px-8 mb-3 bg-gray-100 shadow-inner rounded"
            v-model="form.body"
            rows="3"
            placeholder="Your comment here..."
        ></textarea>
        
        <div class="text-red-500 text-left -mt-3 mb-2 ml-2" v-if="form.errors.body">
            {{ form.errors.body.replace('body', "comment") }}
        </div>
        
        <LoadingButton typeof="submit" :disabled="form.processing" >
            Submit
        </LoadingButton>
    </form>
</div>
</template>