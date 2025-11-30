<script setup>
import AuthLayout from "../../Layouts/AuthLayout.vue";
import {useForm} from "@inertiajs/vue3";
import {route} from "ziggy-js";


defineOptions({
    layout: AuthLayout
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
});

function submit() {
    form.post(route('register.store'));
}


</script>

<template>
    <div class="h-screen flex items-center justify-center">
        <div class="backdrop-blur-lg bg-white/0   border border-white/40 shadow-xl rounded-2xl p-8">
            <form class="space-y-6 w-80" @submit.prevent="submit">
                <h2 class="text-2xl font-semibold text-gray-600 text-center">Регистрация</h2>

                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-gray-600">Имя</label>
                    <input
                        id="name"
                        type="text"
                        autocomplete="name"
                        class="block w-full rounded-lg border border-white/40 bg-white/5 px-3 py-2 text-sm text-gray-700 placeholder:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent"
                        placeholder="Введите имя"
                        v-model="form.name"
                    >
                    <p v-if="form.errors.name" class="text-sm text-red-600">{{ form.errors.name }}</p>
                </div>

                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                    <input
                        id="email"
                        type="email"
                        autocomplete="email"
                        class="block w-full rounded-lg border border-white/40 bg-white/5 px-3 py-2 text-sm text-gray-700 placeholder:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent"
                        placeholder="you@example.com"
                        v-model="form.email"
                    >
                    <p v-if="form.errors.email" class="text-sm text-red-600">{{ form.errors.email }}</p>
                </div>

                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-gray-600">Пароль</label>
                    <input
                        id="password"
                        type="password"
                        autocomplete="current-password"
                        class="block w-full rounded-lg border border-white/40 bg-white/5 px-3 py-2 text-sm text-gray-700 placeholder:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent"
                        placeholder="Введите пароль"
                        v-model="form.password"
                    >
                    <p v-if="form.errors.password" class="text-sm text-red-600">{{ form.errors.password }}</p>
                </div>

                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-600">Подтвердите пароль</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        autocomplete="current-password"
                        class="block w-full rounded-lg border border-white/40 bg-white/5 px-3 py-2 text-sm text-gray-700 placeholder:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent"
                        placeholder="Введите пароль"
                        v-model="form.password_confirmation"
                    >
                    <p v-if="form.errors.password_confirmation" class="text-sm text-red-600">
                        {{ form.errors.password_confirmation }}</p>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-lg bg-indigo-500 px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 focus:ring-offset-transparent"
                >
                    Войти
                </button>
            </form>
        </div>
    </div>
</template>

<style scoped>

</style>
