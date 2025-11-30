<script setup>
import menu from '@/assets/menu.svg'
const emit = defineEmits(['toggle'])
</script>

<template>
    <button
        type="button"
        @click="emit('toggle')"
        class="absolute top-2 left-2 z-50 w-10 h-10 flex items-center justify-center rounded-lg bg-white shadow-md"
    >
        <img :src="menu" alt="menu" class="w-5 h-5 object-contain">
    </button>
</template>
