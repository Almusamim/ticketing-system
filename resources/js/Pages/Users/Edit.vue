<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import Layout  from "@/Shared/Layout"
import BaseInput from '@/Shared/Form/BaseInput'
import LoadingButton from '@/Shared/Form/LoadingButton'

let props = defineProps({
    user: Object,
    errors: Object,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    is_admin: props.user.is_admin,
    avatar: null,
    _method: 'put'
})

function update() {
    Inertia.post(`/users/${props.user.id}`, form, {
        onSuccess: () => form.reset('password', 'avatar'),
    })
}

function destroy() {
    if (confirm('Are you sure you want to delete this user?')) {
        Inertia.delete(`/users/${props.user.id}`)
    }
}

// TODO
function restore() {
    if (confirm('Are you sure you want to restore this user?')) {
        Inertia.put(`/users/${props.user.id}/restore`)
    }
}

function deleteMedia(mediaId) {
    if (confirm('Are you sure you want to delete this file?')) {
        Inertia.get(`/media/${props.user.id}`, mediaId, { preserveState: true });
    }
}

</script>

<template>
<Head :title="`${form.name}`" />
<Layout>

    <template #header>
        <div class="flex justify-between relative">
            <h1 class="text-3xl font-bold">
                <Link class="text-brand-400 hover:text-brand-600" href="/users">Users</Link>
                <span class="text-brand-400 font-medium"> /</span>
                {{ form.name }}
            </h1>
            <img v-if="user.avatar" class="w-16 h-16 rounded-full my-[-16px]" :src="user.avatar" />
        </div>
    </template>

    <div class="max-w-4xl overflow-hidden">
        <p v-if="user.deleted_at" class="mb-6" @click="restore">
            This user has been deleted.
        </p>

        <form @submit.prevent="update">
            <div class="flex flex-wrap -mb-8 -mr-6 p-8">

                <BaseInput id="name" v-model="form.name" :error="errors.name" class="pb-8 pr-6 w-full lg:w-1/2"
                    label="First name" />

                <BaseInput id="email" v-model="form.email" :error="errors.email"
                    class="pb-8 pr-6 w-full lg:w-1/2" label="Email" />

                <BaseInput id="password" v-model="form.password" :error="errors.password"
                    class="pb-8 pr-6 w-full lg:w-1/2" type="password" autocomplete="new-password"
                    label="Password" />


                <!-- TODO -->
                <!-- <FileInput 
                    v-model="form.avatar"
                    :error="errors.avatar"
                    class="pb-8 pr-6 w-full lg:w-1/2"
                    type="file" accept="image/*"
                    label="avatar"
                /> -->

                <input type="file" @input="form.avatar = $event.target.files" accept="image/*" />
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                    {{ form.progress.percentage }}%
                </progress>
                {{ errors.avatar }}

            </div>
        </form>
    </div>

    <template #footer>
        <div class="flex items-center">
            <button v-if="!user.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button"
                @click="destroy">Delete User
            </button>
            <LoadingButton :loading="form.processing" class="btn-brand ml-auto" type="submit" @click="update">
                Update User
            </LoadingButton>
        </div>
    </template>

</Layout>
</template>


