<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {computed} from "vue";

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

        <div v-else class="space-y-2">
            <h2 class="text-xl font-semibold">{{ props.place.name || 'Без названия' }}</h2>
            <div class="text-sm text-gray-700">
                <div>URL: {{ props.place.url }}</div>
                <div>Статус: {{ props.place.status }}</div>
                <div>Рейтинг: {{ props.place.rating ?? '—' }} ({{ props.place.total_reviews ?? 0 }} отзывов)</div>
                <div>Последний парс: {{ props.place.parsed_at ?? '—' }}</div>
            </div>

            <div class="mt-4">
                <h3 class="text-lg font-medium mb-2">Отзывы</h3>
                <div v-if="props.reviews.length === 0" class="text-sm text-gray-600">
                    Отзывов пока нет.
                </div>
                <ul v-else class="space-y-3">
                    <li v-for="review in props.reviews" :key="review.id" class="rounded-lg border border-gray-200 p-3">
                        <div class="flex items-center justify-between">
                            <div class="font-semibold">{{ review.author }}</div>
                            <div class="text-sm text-gray-500">{{ review.rating ?? '—' }}</div>
                        </div>
                        <div class="text-xs text-gray-500">{{ review.raw_date }}</div>
                        <div class="mt-2 text-sm">{{ review.text }}</div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
