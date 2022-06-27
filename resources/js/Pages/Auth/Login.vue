<script setup>
import { useForm } from '@inertiajs/inertia-vue3';

let form = useForm({
    email: '',
    password: '',
});
let submit = () => {
    form.post('/login');
};
</script>

<script>
export default {
    layout: null,
};
</script>

<template>
  <Head title="Log In" />
  <main class="grid place-items-center min-h-screen">
    <div class="w-full">

        <div
          class="bg-white rounded-lg shadow sm:max-w-md sm:w-full sm:mx-auto sm:overflow-hidden"
        >
          <div class="px-4 py-8 sm:px-10">
            <div class="relative mt-6">
              <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
              </div>
              <div class="relative flex justify-center text-sm leading-5">
                <span class="px-2 text-gray-500 bg-white">Login</span>
              </div>
            </div>
            <form @submit.prevent="submit">
                <div class="mt-6">
                <div class="w-full space-y-6">
                    <div class="w-full">
                    <div class="relative">

                        <input
                            type="email"
                            v-model="form.email"
                            name="email"
                            id="email"
                            class="rounded-lg border flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                            placeholder="E-mail"
                        />
                        <div v-if="form.errors.email" v-text="form.errors.email" class="text-red-500 text-xs mt-1"></div>

                    </div>
                    </div>
                    <div class="w-full">
                    <div class="relative">

                        <input
                            type="password"
                            v-model="form.password"
                            name="password"
                            id="password"
                            class="rounded-lg border flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                            placeholder="Password"
                        />
                        <div v-if="form.errors.password" v-text="form.errors.password" class="text-red-500 text-xs mt-1"></div>

                    </div>
                    </div>
                    <div>
                    <span class="block w-full rounded-md shadow-sm">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="btn"
                        >
                            Login
                        </button>
                    </span>
                    </div>
                </div>
                </div>
            </form>
          </div>
          <div class="px-4 py-6 border-t-2 border-gray-200 bg-gray-50 sm:px-10">
            <p class="text-xs leading-5 text-gray-500">
              <b>Admin</b> <code>admin@mail.com</code>, <code>password</code><br />
              <b>User</b> <code>user@mail.com</code>, <code>password</code>
            </p>
          </div>
        </div>

    </div>
  </main>
</template>


<style lang="postcss">
body {
    @apply bg-gray-100;
}

code {
 @apply px-1 rounded bg-gray-300;
}

.btn {
    @apply py-2 px-4 bg-brand-600 hover:bg-brand-700
        focus:ring-brand-500 focus:ring-offset-brand-200 text-white w-full
        transition ease-in duration-200 text-center text-base font-semibold
        shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg
        disabled:bg-brand-100 disabled:text-brand-200 disabled:border-brand-200 disabled:shadow-none;
}

</style>