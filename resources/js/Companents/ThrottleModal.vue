<script setup>
import {computed, onBeforeUnmount, ref, watch} from "vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    seconds: {
        type: Number,
        default: 0
    }
});

const emit = defineEmits(["close"]);

const remaining = ref(props.seconds);
let timerId = null;

const stopTimer = () => {
    if (timerId !== null) {
        clearInterval(timerId);
        timerId = null;
    }
};

const startTimer = () => {
    stopTimer();
    if (!props.show || !props.seconds) return;

    remaining.value = props.seconds;
    timerId = window.setInterval(() => {
        if (remaining.value > 0) {
            remaining.value -= 1;
        } else {
            stopTimer();
        }
    }, 1000);
};

watch(
    () => props.show,
    (val) => {
        if (val) {
            startTimer();
        } else {
            stopTimer();
        }
    }
);

watch(
    () => props.seconds,
    () => {
        if (props.show) {
            startTimer();
        }
    }
);

onBeforeUnmount(stopTimer);

const formattedTime = computed(() => {
    const minutes = Math.floor(remaining.value / 60);
    const seconds = remaining.value % 60;
    const pad = (n) => n.toString().padStart(2, "0");
    return `${pad(minutes)}:${pad(seconds)}`;
});

const close = () => {
    stopTimer();
    emit("close");
};
</script>

<template>
    <teleport to="body">
        <transition name="fade">
            <div
                v-if="props.show"
                class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/70 backdrop-blur-sm px-4"
            >
                <div
                    class="relative w-full max-w-md overflow-hidden rounded-2xl border border-white/20 bg-white/10 p-6 shadow-2xl"
                >
                    <button
                        type="button"
                        class="absolute right-3 top-3 rounded-full bg-white/10 p-1 text-slate-200 transition hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 focus:ring-offset-slate-900/60"
                        @click="close"
                        aria-label="Закрыть"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>

                    <div class="flex flex-col gap-3 text-center text-slate-100">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-amber-400/20 text-amber-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 9v4" />
                                <path d="M12 17h.01" />
                                <path d="M21 19a9 9 0 1 0-18 0" />
                            </svg>
                        </div>

                        <h3 class="text-xl font-semibold">Слишком много попыток</h3>
                        <p class="text-sm text-slate-200/80">
                            Мы временно заблокировали вход, чтобы защитить аккаунт. Повторите позже.
                        </p>

                        <div class="flex flex-col items-center gap-2">
                            <span class="text-sm uppercase tracking-wide text-slate-200/80">Осталось</span>
                            <span class="text-3xl font-mono font-semibold text-amber-200">{{ formattedTime }}</span>
                        </div>

                        <button
                            type="button"
                            class="mt-2 w-full rounded-lg bg-white/15 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/25 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:ring-offset-2 focus:ring-offset-slate-900/60"
                            @click="close"
                        >
                            Понятно
                        </button>
                    </div>
                </div>
            </div>
        </transition>
    </teleport>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
