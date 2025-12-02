<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import {route} from "ziggy-js";
import {computed, onBeforeUnmount, onMounted, ref} from "vue";
import axios from "axios";


defineOptions({
    layout: AppLayout
});

const page = usePage()
const status = ref(page.props.place?.status || null)
const loading = computed(() => ['pending', 'processing'].includes(status.value))
let pollTimer = null

const startPoll = () => {
    if (pollTimer || !loading.value) return
    pollTimer = window.setInterval(async () => {
        try {
            const {data} = await axios.get(route('reviews.status'))
            status.value = data.status
            if (!loading.value) stopPoll()
        } catch (e) {
            stopPoll()
        }
    }, 3000)
}

const stopPoll = () => {
    if (pollTimer) {
        clearInterval(pollTimer)
        pollTimer = null
    }
}

onMounted(() => {
    if (loading.value) startPoll()
})

onBeforeUnmount(stopPoll)
const form = useForm({
    url: ''
})

function submit() {
    form.post(route('reviews.store'), {
        preserveScroll: true,
        onStart: () => {
            status.value = 'pending'
            startPoll()
        },
        onSuccess: () => form.reset('url'),
        onError: () => {
            form.reset('url')
            status.value = null
            stopPoll()
        }
    })
}

</script>

<template>
<div>

    <div v-if="loading" class="mb-2 flex items-center gap-2 text-sm text-gray-600">
        <span class="h-4 w-4 animate-spin rounded-full border-2 border-blue-500 border-t-transparent"></span>
        Обрабатываем…
    </div>
        <h2 class="font-main text-base font-medium mb-4">Подключить Яндекс</h2>
        <div class="mb-2">
            <span class=" helper-text font-main text-xs font-semibold">Укажите ссылку на Яндекс, пример </span>
            <a class="link-yandex font-main text-xs font-light underline"
               href="https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/">https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/</a>
        </div>
        <div class="flex flex-col gap-4">
            <input @input="form.clearErrors('url')" v-model="form.url" type="text"
                   class="yandex-input font-main text-sm" placeholder="Введите ссылку">
            <div v-if="form.errors.url" class="text-red-500 text-xs mt-1">
                {{ form.errors.url }}
            </div>
            <button
                @click="submit"
                :disabled="loading || form.processing"
                :class="[
                    'w-32 h-7 rounded-md flex items-center justify-center transition',
                    loading || form.processing
                        ? 'bg-blue-300 text-white opacity-60 cursor-not-allowed'
                        : 'bg-blue-500 text-white hover:bg-blue-400 cursor-pointer'
                ]"
            >
                Сохранить
            </button>
        </div>
    </div>
</template>

<style scoped>
.helper-text {
    color: #6C757D;
}

.link-yandex {
    color: #788397;
}

.yandex-input {
    width: 480px;
    height: 24px;
    border-radius: 6px;
    background: #fff;
    border: 1px solid #D1D5DB;
    padding: 4px 8px;
}
</style>
