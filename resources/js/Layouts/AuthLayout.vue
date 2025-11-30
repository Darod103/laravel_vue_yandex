<script setup>
</script>

<template>
    <div class="relative min-h-screen flex items-center justify-center overflow-hidden ">
        <video
            class="absolute top-0 left-0 w-full h-full object-cover"
            style="z-index: -1;"
            autoplay
            loop
            playsinline
            muted
        >
            <source :src="'/videos/bg.mp4'" type="video/mp4">

        </video>

        <div class="relative z-10">
            <slot />
        </div>
    </div>
</template>

<style scoped>

</style>
