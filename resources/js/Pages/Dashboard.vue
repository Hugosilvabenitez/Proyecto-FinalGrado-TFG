<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useStats } from '@/state/statsStore';

/**
* Dashboard View
*
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-03-18
*
* This file contains all the code for generate the dashboard area of Gameflux's project.
*/

const props = defineProps({
    auth: {
        type: Object,
    },
});

const stats = useStats();

stats.total_minutes = props.auth.user.stats?.total_minutes || 0;
stats.cloud_saves = props.auth.user.stats?.cloud_saves || 0;
stats.achievements_unlocked = props.auth.user.stats?.achievements_unlocked || 0;

const formattedTime = computed(() => {
    const minutes = stats.total_minutes || 0;
    const h = Math.floor(minutes / 60);
    const m = minutes % 60;

    return `${h}h ${m}m`;
});

const firstName = computed(() => {
    return props.auth?.user?.name?.split(' ')?.[0] || 'Trainer';
});

defineOptions({
    layout: AuthenticatedLayout,
});
</script>

<template>
    <Head title="Dashboard · GameFlux" />

    <div class="min-h-screen overflow-x-hidden bg-slate-950 text-slate-100 relative">
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -top-32 -left-24 h-72 w-72 bg-gradient-to-br from-cyan-500 via-blue-500 to-purple-600 opacity-40 blur-3xl"></div>
            <div class="absolute -bottom-40 -right-20 h-80 w-80 bg-gradient-to-tr from-fuchsia-500 via-orange-400 to-yellow-300 opacity-40 blur-3xl"></div>
        </div>

        <div
            class="pointer-events-none absolute inset-0 opacity-30 mix-blend-soft-light"
            style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2240%22 height=%2240%22 viewBox=%220 0 40 40%22><rect width=%221%22 height=%221%22 fill=%22%23ffffff%22 opacity=%220.12%22/></svg>');"
        ></div>

        <div class="relative z-10 mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="mx-auto mb-12 w-full max-w-2xl">
                <div class="mb-8 flex flex-col items-center">
                    <img
                        :src="props.auth?.user?.avatar_url"
                        alt="Avatar"
                        class="mb-4 h-20 w-20 rounded-full border-4 border-white/20 shadow-[0_0_25px_rgba(59,130,246,0.75)] object-cover"
                    />
                    <h1 class="mb-2 text-center text-2xl font-semibold tracking-tight text-slate-100">
                        ¡Hola, {{ firstName }}!
                    </h1>
                    <p class="text-center text-sm text-slate-300">
                        Tu portal de emulación Game Boy Advance
                    </p>
                </div>

                <div class="flex flex-col justify-center gap-3 sm:flex-row">
                    <button
                        class="w-full rounded-2xl bg-gradient-to-r from-cyan-400 via-blue-500 to-fuchsia-500 px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-[0_0_25px_rgba(56,189,248,0.9)] transition-all hover:scale-[1.02] hover:shadow-[0_0_40px_rgba(244,114,182,0.9)] disabled:cursor-not-allowed disabled:opacity-60 sm:w-auto"
                    >
                        Nueva partida
                    </button>

                    <button
                        class="w-full rounded-2xl border border-white/10 bg-white/5 px-6 py-3 text-sm text-slate-300 backdrop-blur-2xl transition-all hover:border-cyan-400/60 hover:text-cyan-300 hover:shadow-[0_0_20px_rgba(56,189,248,0.6)] sm:w-auto"
                    >
                        Mis favoritos
                    </button>
                </div>
            </div>

            <div class="mb-12 grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="rounded-3xl border border-white/10 bg-white/5 p-6 text-center shadow-[0_0_40px_rgba(15,23,42,0.9)] backdrop-blur-2xl transition duration-500 ease-out hover:-translate-y-1 hover:border-cyan-400/60 hover:shadow-[0_0_60px_rgba(56,189,248,0.8)]">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-green-400 to-emerald-500 shadow-[0_0_20px_rgba(16,185,129,0.6)]">
                        <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                    <p class="mb-2 text-xs uppercase tracking-wide text-slate-400">Partidas guardadas</p>
                    <p class="text-3xl font-bold text-slate-100">{{ stats.cloud_saves }}</p>
                    <p class="mt-1 text-xs text-slate-500">En la nube</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-6 text-center shadow-[0_0_40px_rgba(15,23,42,0.9)] backdrop-blur-2xl transition duration-500 ease-out hover:-translate-y-1 hover:border-fuchsia-400/60 hover:shadow-[0_0_60px_rgba(244,114,182,0.8)]">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-purple-500 to-violet-600 shadow-[0_0_20px_rgba(168,85,247,0.6)]">
                        <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                    <p class="mb-2 text-xs uppercase tracking-wide text-slate-400">Horas jugadas</p>
                    <p class="text-3xl font-bold text-slate-100">{{ formattedTime }}</p>
                    <p class="mt-1 text-xs text-slate-500">Total emulador</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-6 text-center shadow-[0_0_40px_rgba(15,23,42,0.9)] backdrop-blur-2xl transition duration-500 ease-out hover:-translate-y-1 hover:border-orange-400/60 hover:shadow-[0_0_60px_rgba(251,146,60,0.8)]">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-yellow-400 to-orange-500 shadow-[0_0_20px_rgba(251,191,36,0.6)]">
                        <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            />
                        </svg>
                    </div>
                    <p class="mb-2 text-xs uppercase tracking-wide text-slate-400">Logros</p>
                    <p class="text-3xl font-bold text-slate-100">{{ stats.achievements_unlocked }}</p>
                    <p class="mt-1 text-xs text-slate-500">De - totales</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                <div class="w-full rounded-3xl border border-white/10 bg-white/5 p-8 shadow-[0_0_40px_rgba(15,23,42,0.9)] backdrop-blur-2xl min-w-0">
                    <h2 class="mb-6 flex items-center gap-3 text-2xl font-semibold tracking-tight">
                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 shadow-lg">
                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    fill-rule="evenodd"
                                    d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>
                        <span class="truncate">Mis juegos recientes</span>
                    </h2>

                    <div class="space-y-4 min-w-0">
                        <div class="flex min-w-0 items-center gap-4 rounded-2xl border border-slate-700/70 bg-slate-900/60 p-4 transition-all hover:border-cyan-400/60 hover:shadow-[0_0_20px_rgba(56,189,248,0.4)]">
                            <div class="flex h-20 w-16 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 shadow-lg">
                                <span class="text-2xl">🟥</span>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="truncate font-semibold text-slate-200">Pokémon FireRed</p>
                                <p class="truncate text-sm text-slate-400">Última partida: hace 2h</p>
                            </div>

                            <div class="shrink-0 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 px-4 py-2 text-xs font-semibold text-white shadow-lg transition-transform hover:scale-105">
                                Continuar
                            </div>
                        </div>

                        <div class="flex min-w-0 items-center gap-4 rounded-2xl border border-slate-700/70 bg-slate-900/60 p-4 transition-all hover:border-fuchsia-400/60 hover:shadow-[0_0_20px_rgba(244,114,182,0.4)]">
                            <div class="flex h-20 w-16 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-orange-500 to-red-600 shadow-lg">
                                <span class="text-2xl">⭐</span>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="truncate font-semibold text-slate-200">Zelda: Minish Cap</p>
                                <p class="truncate text-sm text-slate-400">Última partida: hace 1 día</p>
                            </div>

                            <div class="shrink-0 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 px-4 py-2 text-xs font-semibold text-white shadow-lg transition-transform hover:scale-105">
                                Continuar
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full rounded-3xl border border-white/10 bg-white/5 p-8 shadow-[0_0_40px_rgba(15,23,42,0.9)] backdrop-blur-2xl min-w-0">
                    <h2 class="mb-6 flex items-center gap-3 text-2xl font-semibold tracking-tight">
                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-r from-fuchsia-500 to-purple-600 shadow-lg">
                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="truncate">Recomendaciones</span>
                    </h2>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="group cursor-pointer rounded-2xl border border-slate-700/70 bg-slate-900/60 p-4 transition-all hover:border-cyan-400/60 hover:shadow-[0_0_20px_rgba(56,189,248,0.4)] min-w-0">
                            <div class="mb-3 flex h-24 w-full items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg transition-transform group-hover:scale-[1.02]">
                                <span class="text-2xl">🍄</span>
                            </div>
                            <p class="truncate text-sm font-semibold text-slate-200">Mario Kart GBA</p>
                            <p class="truncate text-xs text-slate-500 mt-1">Clásico multijugador</p>
                        </div>

                        <div class="group cursor-pointer rounded-2xl border border-slate-700/70 bg-slate-900/60 p-4 transition-all hover:border-orange-400/60 hover:shadow-[0_0_20px_rgba(251,146,60,0.4)] min-w-0">
                            <div class="mb-3 flex h-24 w-full items-center justify-center rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 shadow-lg transition-transform group-hover:scale-[1.02]">
                                <span class="text-2xl">🦎</span>
                            </div>
                            <p class="truncate text-sm font-semibold text-slate-200">Metroid Fusion</p>
                            <p class="truncate text-xs text-slate-500 mt-1">Aventura sci-fi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>