<script setup>
import yandex_logo from "@/assets/yandex_logo.svg"
import AppLayout from "@/Layouts/AppLayout.vue";
import {computed} from "vue";
import PlaceRatingSummary from "@/Companents/PlaceRatingSummary.vue";
import Review from "@/Companents/Review.vue";

defineOptions({
    layout: AppLayout
});

const props = defineProps({
    place: {
        type: Object,
        default: null,
    },
    reviews: {
        type: Array,
        default: () => [],
    },
});

const hasPlace = computed(() => !!props.place);
</script>

<template>
    <div class="space-y-4">
        <div v-if="!hasPlace" class="text-sm text-gray-600">
            Место ещё не подключено.
        </div>

        <div v-else class="flex flex-col gap-6 lg:flex-row lg:items-start">
            <div class="flex-1 space-y-4">
                <div class="inline-flex items-center gap-2 bg-white rounded-lg shadow-md shadow-slate-200 px-2 py-1">
                    <img
                        :src="yandex_logo"
                        alt="Yandex Maps"
                        class="w-4 h-4"
                    >
                    <a
                        :href="props.place.url"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-xs hover:underline"
                    >
                        Яндекс Карты
                    </a>
                </div>
                <div class="flex flex-col gap-5">
                    <Review
                        v-for="review in props.reviews"
                        :key="review.id"
                        :review="review"
                        :place="props.place"
                    />
                </div>
            </div>

            <div class="w-full lg:w-auto lg:sticky lg:top-4">
                <PlaceRatingSummary
                    :totalReviews="place.total_reviews"
                    :rating="Number(props.place.rating)"
                />
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
