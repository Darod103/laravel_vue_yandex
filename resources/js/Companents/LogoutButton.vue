<script setup>

import {Link} from "@inertiajs/vue3";
import {route} from "ziggy-js";

</script>

<template>
    <Link
        :href="route('logout')"
        method="post"
        as="button"
        type="button"
        class="px-3 py-2 rounded bg-gray-200 hover:bg-gray-300 text-sm"
    >
        Выйти
    </Link>
</template>

<style scoped>

</style>
