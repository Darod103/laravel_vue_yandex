<script setup>
import exit from '@/assets/exit.png'
import {Link} from "@inertiajs/vue3";
import {route} from "ziggy-js";

</script>

<template>
    <Link
        :href="route('logout')"
        method="post"
        as="button"
        type="button"
        class="px-3 py-2 rounded text-sm cursor-pointer"
    >
      <img :src="exit" alt="logout">
    </Link>
</template>

<style scoped>

</style>
