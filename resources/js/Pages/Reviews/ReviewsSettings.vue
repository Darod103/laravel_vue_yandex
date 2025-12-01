<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import {route} from "ziggy-js";
import {watch} from "vue";

defineOptions({
    layout: AppLayout
});

const form = useForm({
    url: ''
})
function submit(){
    form.post(route('reviews.store'),{
        onFinish: () => {
            form.reset('url')
        }
    })
}

</script>

<template>
<div>
    <h2 class="font-main text-base font-medium mb-4">Подключить Яндекс</h2>
    <div class="mb-2">
        <span class=" helper-text font-main text-xs font-semibold">Укажите ссылку на Яндекс, пример </span>
        <a class="link-yandex font-main text-xs font-light underline" href="https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/">https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/</a>
    </div>
    <div class="flex flex-col gap-4">
        <input @input="form.clearErrors('url')" v-model="form.url"  type="text" class="yandex-input font-main text-sm" placeholder="Введите ссылку">
        <div v-if="form.errors.url" class="text-red-500 text-xs mt-1">
            {{ form.errors.url }}
        </div>
        <button @click="submit" class="w-32 h-7 bg-blue-500  text-white rounded-md flex items-center justify-center cursor-pointer hover:bg-blue-400">Сохранить</button>
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
