<script setup>
import {usePage} from "@inertiajs/vue3";
import {ref} from "vue";
import MenuToggleButton from "@/Companents/MenuToggleButton.vue";
import Sidebar from "../Companents/Sidebar.vue";
import LogoutButton from "@/Companents/LogoutButton.vue";

const showSidebar = ref(true)
const toggleSidebar = () => {
    showSidebar.value = !showSidebar.value
}
</script>

<template>
    <div class="min-h-screen flex">
        <MenuToggleButton
            v-if="!showSidebar"
            @toggle="toggleSidebar"
        />

        <div
            class="transition-all duration-300 overflow-hidden"
            :class="showSidebar ? 'w-64' : 'w-0'"
        >
        <Sidebar @toggle="toggleSidebar" />
    </div>

    <div class="flex-1 flex flex-col">

        <div class="h-16 border-b border-b-gray-400 flex justify-end items-center pr-4">
            <LogoutButton />
        </div>

        <div class="flex-1 py-4 px-9 overflow-y-auto">
            <slot />
        </div>
    </div>
    </div>
</template>

<style scoped>


</style>
