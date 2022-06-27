<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import Layout  from '@/Shared/Layout'
import LoadingButton from '@/Shared/Form/LoadingButton'
import TextInput from '@/Shared/Form/TextInput'

let form = useForm({
    title: '',
    body: '',
    status: '',
    media: null,
});

let submit = () => {
    form.post('/tickets');
};
</script>

<template>
    <Head title="Create Ticket" />
    <Layout>

        <template #header>
            <div class="flex justify-between relative">
                <h1 class="text-3xl font-bold">
                    <Link class="text-brand-400 hover:text-brand-600" href="/tickets">Tickets</Link>
                    <span class="text-brand-400 font-medium"> / Create</span>
                </h1>
            </div>
        </template>

        <form @submit.prevent="submit">
            <div class="grid md:grid-cols-12 gap-5 p-4 m-2">
                <div class="md:col-span-8 p-4 border-1 border-gray-50">

                    <TextInput
                        v-model="form.title"
                        :error="form.errors.title" 
                        id="title"
                        label="Title"
                        class="pb-3 pr-6"
                    />
                    <div class="flex mb-4">
                        <div class="h-5">
                            <label for="status" class="font-medium text-gray-700 pr-3">Active</label>
                            <input type="checkbox" id="status" v-model="form.status"> 
                        </div>
                    </div>
                    <div>
                        <label for="about" class="block text-sm font-medium text-gray-700">Description</label>
                        <div class="mt-1">

                        <textarea
                            v-model="form.body"
                            :error="form.errors.body" 
                            id="body"
                            label="body"
                            rows="6"
                            class="p-3 pr-6 w-full border rounded-lg"></textarea>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-4 md:pt-0 p-2 border-1 border-gray-500 rounded">
                    <div>
                        <input 
                            multiple
                            type="file"
                            @input="form.media = $event.target.files"
                            class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm "
                        />
                        <div v-if="form.errors.media" class="text-red-700 mt-2 text-sm">{{ form.errors.media }}</div>

                        <progress v-if="form.progress" :value="form.progress.percentage" max="100" class="text-brand-300">
                            {{ form.progress.percentage }}%
                        </progress>          
                    </div>
                    <div class="flex justify-center mt-3">

                    </div>
                </div>
            </div>

            <div class="w-full flex justify-end">
                <LoadingButton :loading="form.processing" class="btn-brand" type="submit">
                    Submit Ticket
                </LoadingButton>
            </div>
        </form>

        <template #footer>
        </template>

    </Layout>
</template>



