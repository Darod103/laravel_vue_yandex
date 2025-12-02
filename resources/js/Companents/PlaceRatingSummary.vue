<script setup>
import full_star from "@/assets/full_star.svg"
import empty_star from "@/assets/empty_star.svg"

const props = defineProps({
    rating: {
        type: Number,
        default: 0
    },
    totalReviews: {
        type: Number,
        default: 0
    }
})

const fullStars = Math.floor(props.rating)
const emptyStars = 5 - fullStars
</script>

<template>
    <div
        class="bg-white rounded-3xl shadow-md shadow-slate-200 px-6 py-5 sm:px-8 sm:py-6 flex flex-col gap-4 w-full sm:w-72"
    >
        <div class="flex items-center gap-3">
      <span class="text-4xl font-semibold text-slate-800 leading-none">
        {{ Number(rating).toFixed(1) }}
      </span>

            <div class="flex items-center gap-1">
                <img
                    v-for="i in fullStars"
                    :key="'full-' + i"
                    :src="full_star"
                    class="w-7 h-7"
                    alt="star"
                />
                <img
                    v-for="i in emptyStars"
                    :key="'empty-' + i"
                    :src="empty_star"
                    class="w-7 h-7"
                    alt="empty star"
                />
            </div>
        </div>

        <div class="h-0.5 bg-slate-500"></div>

        <p class="font-main text-sm text-slate-800 font-semibold">
            Всего отзывов:
            <span class="font-normal">
        {{ totalReviews.toLocaleString('ru-RU') }}
      </span>
        </p>
    </div>
</template>

<style scoped>

</style>
