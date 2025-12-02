<script setup>
import logo from '@/assets/logo.svg'
import vector from '@/assets/vector.svg'
import tools from '@/assets/tools.svg'
import {Link, usePage} from "@inertiajs/vue3";
import {computed, ref} from "vue";
import {route} from "ziggy-js";

const open = ref(false)
const page = usePage()
const hasPlace = computed(() => !!page.props.auth?.place?.id)
const emit = defineEmits(['toggle'])
</script>

<template>
    <aside class="sidebar flex flex-col gap-6 pt-2 p-5 sticky top-0 h-screen self-start ">
        <button class="flex items-center  -ml-2" @click="emit('toggle')">
            <img :src="vector" alt="menu" class="cursor-pointer">
        </button>
        <div class="ml-2">
            <Link :href="route('home')"><img :src="logo" alt="Logo" class="w-40"></Link>
        </div>
        <h1 class="sidebar-company__name font-main text-base font-bold ">{{ page.props.auth.user.name }}</h1>
        <div class="w-full">

            <button @click="open = !open" class="flex w-full  py-2 px-3 rounded-lg bg-white shadow-sm cursor-pointer hover:bg-gray-50">
                <img :src="tools" alt="menu" class="mr-2"> <span
                class="font-main sidebar-button__text text-base font-medium">Отзывы</span>
            </button>
            <ul v-if="open" class="ml-4 m-3 space-y-2 text-sm text-slate-700">
                <li
                    :class="[
                        'px-3 py-2 rounded-lg transition',
                        hasPlace ? 'cursor-pointer hover:bg-white' : 'opacity-50 cursor-not-allowed'
                    ]"
                >
                    <Link v-if="hasPlace" :href="route('reviews.index')" class="block w-full h-full">Отзывы</Link>
                    <span v-else class="block w-full h-full">Отзывы</span>
                </li>
                <li class="px-3 py-2 rounded-lg cursor-pointer hover:bg-white transition">
                    <Link :href="route('reviews.settings')" class="block w-full h-full">Настройка</Link>
                </li>
            </ul>
        </div>
    </aside>
</template>

<style scoped>
.sidebar {
    background: #F6F8FA;
}

.sidebar-company__name {
    color: #6C757D;

}

.sidebar-button__text {
    color: #363740;;
}

</style>
