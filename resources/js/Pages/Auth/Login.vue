<script setup>
import AuthLayout from "../../Layouts/AuthLayout.vue";
import ThrottleModal from "../../Companents/ThrottleModal.vue";
import {Link, useForm, usePage} from "@inertiajs/vue3";
import {route} from "ziggy-js";
import {ref, watch} from "vue";

defineOptions({
    layout: AuthLayout
});
const page = usePage()

const form = useForm({
    email: '',
    password: ''
});

const showThrottle = ref(false)
const throttleSeconds = ref(null)

function submit() {
    form.post(route('login.store'))
}

function closeThrottle() {
    showThrottle.value = false
    throttleSeconds.value = null
}

watch(
    () => page.props.throttle?.seconds,
    (val) => {
        if (val != null) {
            throttleSeconds.value = val
            showThrottle.value = true
        } else {
            showThrottle.value = false
        }
    },
    { immediate: true }
)
</script>

<template>
    <div class="h-screen flex items-center justify-center">
        <div class="backdrop-blur-lg bg-white/0   border border-white/40 shadow-xl rounded-2xl p-8">
            <form class="space-y-6 w-80" @submit.prevent="submit">
                <h2 class="text-2xl font-semibold text-gray-600 text-center">Вход в аккаунт</h2>

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

                <div class="flex items-center justify-between text-sm">
                    <Link rel="stylesheet" :href="route('register.show')" class="text-indigo-400 hover:text-indigo-300 ">
                        Зарегистрироваться
                    </Link>
                    <Link type="button" class="text-indigo-400 hover:text-indigo-300 ">
                        Забыли пароль?
                    </Link>
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

    <ThrottleModal
        :show="showThrottle"
        :seconds="throttleSeconds || 0"
        @close="closeThrottle"
    />
</template>

<style scoped>

</style>
