<script setup>

import full_star from "@/assets/full_star.svg"
import empty_star from "@/assets/empty_star.svg"
import yandex_logo from "@/assets/yandex_logo.svg"
import {computed} from "vue";

const props = defineProps({
    review: {
        type: Object,
        required: true,
    },
    place:{
        type:Object,
        required:true
    }
})

const rating = computed(() => Number(props.review.rating) || 0)
const fullStars = computed(() => Math.floor(rating.value))
const emptyStars = computed(() => 5 - fullStars.value)
function formatDate(date) {
    if (!date) return '—'
    return new Date(date).toLocaleDateString('ru-RU')
}
</script>

<template>
    <div class="rounded-[32px] bg-white shadow-2xl drop-shadow-slate-300 px-5 py-5 sm:px-8 sm:py-6">
        <div class="rounded-[28px] bg-slate-50 px-5 py-5 sm:px-8 sm:py-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between sm:gap-4">
                <div class="flex flex-wrap items-center gap-3 text-slate-800">
                    <span class="text-base font-semibold sm:text-lg">
                        {{ formatDate(review.date_iso) }}
                    </span>

                    <div class="flex items-center gap-2 text-base font-semibold sm:text-lg">
                        <span class="truncate max-w-[12rem] sm:max-w-none">{{ props.place.name }}</span>
                        <a :href="props.place.url" target="_blank" rel="noopener noreferrer">
                            <img
                                :src="yandex_logo"
                                alt="Локация"
                                class="w-3 h-4"
                            />
                        </a>
                    </div>
                </div>

                <!-- рейтинг со звёздами -->
                <div class="flex items-center gap-2">
                    <div class="flex gap-1">
                        <img
                            v-for="i in fullStars"
                            :key="'full-' + i"
                            :src="full_star"
                            class="w-4 h-4 sm:w-5 sm:h-5"
                            alt="star"
                        />
                        <img
                            v-for="i in emptyStars"
                            :key="'empty-' + i"
                            :src="empty_star"
                            class="w-4 h-4 sm:w-5 sm:h-5"
                            alt="empty star"
                        />
                    </div>
                </div>
            </div>

            <div class="mt-4 flex flex-wrap items-center gap-3 text-slate-900">
                <span class="text-lg font-semibold sm:text-xl">
                  {{ review.author }}
                </span>
                <span class="text-sm sm:text-base">
                  {{ review.phone ?? '' }}
                </span>
            </div>

            <p class="mt-4 text-sm leading-relaxed text-slate-900 sm:text-base">
                {{ review.text }}
            </p>
        </div>
    </div>
</template>

<style scoped>

</style>
