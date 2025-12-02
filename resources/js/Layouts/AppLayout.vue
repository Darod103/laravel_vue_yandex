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
    <div class="min-h-screen flex relative">
        <div
            class="transition-transform duration-300 fixed inset-y-0 left-0 z-30 w-64 bg-[#F6F8FA] sm:w-64"
            :class="showSidebar ? 'translate-x-0' : '-translate-x-full'"
        >
            <Sidebar @toggle="toggleSidebar" />
        </div>

        <div
            v-if="showSidebar"
            class="fixed inset-0 z-20 bg-black/20 sm:hidden"
            @click="toggleSidebar"
        />

        <div class="flex-1 flex flex-col transition-all duration-300" :class="showSidebar ? 'sm:ml-64' : 'sm:ml-0'">
            <div class="h-16 border-b border-b-gray-400 flex items-center justify-end gap-3 pr-4 pl-4 sm:pl-9">
                <div v-if="!showSidebar">
                    <MenuToggleButton @toggle="toggleSidebar" />
                </div>
                <LogoutButton />
            </div>

            <div class="flex-1 py-4 px-5 sm:px-9 overflow-y-auto">
                <slot />
            </div>
        </div>
    </div>
</template>

<style scoped>


</style>
