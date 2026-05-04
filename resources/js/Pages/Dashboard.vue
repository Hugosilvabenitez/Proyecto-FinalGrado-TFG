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

    <div class="gf-page relative min-h-screen overflow-x-hidden">
        <div class="pointer-events-none absolute inset-0">
            <div class="gf-page-orb-primary absolute -top-32 -left-24 h-72 w-72"></div>
            <div class="gf-page-orb-secondary absolute -bottom-40 -right-20 h-80 w-80"></div>
        </div>

        <div class="gf-page-grid pointer-events-none absolute inset-0"></div>

        <div class="relative z-10 mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="gf-panel-hero mx-auto mb-12 w-full max-w-2xl rounded-[2rem] p-8 text-center backdrop-blur-2xl sm:p-10">
                <div class="mb-8 flex flex-col items-center">
                    <img
                        :src="props.auth?.user?.avatar_url"
                        alt="Avatar"
                        class="mb-4 h-20 w-20 rounded-full border-4 object-cover"
                        :style="{ borderColor: 'var(--gf-line-strong)', boxShadow: '0 0 25px var(--gf-accent-soft)' }"
                    />
                    <h1 class="mb-2 text-center text-2xl font-semibold tracking-tight">
                        ¡Hola, {{ firstName }}!
                    </h1>
                    <p class="gf-text-muted text-center text-sm">
                        Tu portal de emulación Game Boy Advance
                    </p>
                </div>

                <div class="flex flex-col justify-center gap-3 sm:flex-row">
                    <button
                        class="gf-button-primary w-full rounded-2xl px-6 py-3 text-sm font-semibold uppercase tracking-wide disabled:cursor-not-allowed disabled:opacity-60 sm:w-auto"
                    >
                        Nueva partida
                    </button>

                    <button
                        class="gf-button-secondary w-full rounded-2xl px-6 py-3 text-sm backdrop-blur-2xl sm:w-auto"
                    >
                        Mis favoritos
                    </button>
                </div>
            </div>

            <div class="mb-12 grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="gf-panel-soft gf-panel-hover-accent rounded-3xl p-6 text-center backdrop-blur-2xl">
                    <div class="gf-surface-accent mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl">
                        <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                    <p class="gf-text-subtle mb-2 text-xs uppercase tracking-wide">Partidas guardadas</p>
                    <p class="text-3xl font-bold">{{ stats.cloud_saves }}</p>
                    <p class="gf-text-subtle mt-1 text-xs">En la nube</p>
                </div>

                <div class="gf-panel-soft gf-panel-hover-secondary rounded-3xl p-6 text-center backdrop-blur-2xl">
                    <div class="gf-surface-secondary mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl">
                        <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                    <p class="gf-text-subtle mb-2 text-xs uppercase tracking-wide">Horas jugadas</p>
                    <p class="text-3xl font-bold">{{ formattedTime }}</p>
                    <p class="gf-text-subtle mt-1 text-xs">Total emulador</p>
                </div>

                <div class="gf-panel-soft gf-panel-hover-accent rounded-3xl p-6 text-center backdrop-blur-2xl">
                    <div class="gf-surface-mixed mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl">
                        <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            />
                        </svg>
                    </div>
                    <p class="gf-text-subtle mb-2 text-xs uppercase tracking-wide">Logros</p>
                    <p class="text-3xl font-bold">{{ stats.achievements_unlocked }}</p>
                    <p class="gf-text-subtle mt-1 text-xs">De - totales</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                <div class="gf-panel w-full min-w-0 rounded-3xl p-8 backdrop-blur-2xl">
                    <h2 class="mb-6 flex items-center gap-3 text-2xl font-semibold tracking-tight">
                        <div class="gf-surface-accent flex h-10 w-10 items-center justify-center rounded-2xl">
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
                        <div class="gf-panel-strong gf-panel-hover-accent flex min-w-0 items-center gap-4 rounded-2xl p-4">
                            <div class="gf-surface-mixed flex h-20 w-16 shrink-0 items-center justify-center rounded-xl">
                                <span class="text-2xl">🟥</span>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="truncate font-semibold">Pokémon FireRed</p>
                                <p class="gf-text-subtle truncate text-sm">Última partida: hace 2h</p>
                            </div>

                            <div class="gf-chip-success shrink-0 rounded-xl px-4 py-2 text-xs font-semibold transition-transform hover:scale-105">
                                Continuar
                            </div>
                        </div>

                        <div class="gf-panel-strong gf-panel-hover-secondary flex min-w-0 items-center gap-4 rounded-2xl p-4">
                            <div class="gf-surface-secondary flex h-20 w-16 shrink-0 items-center justify-center rounded-xl">
                                <span class="text-2xl">⭐</span>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="truncate font-semibold">Zelda: Minish Cap</p>
                                <p class="gf-text-subtle truncate text-sm">Última partida: hace 1 día</p>
                            </div>

                            <div class="gf-chip-success shrink-0 rounded-xl px-4 py-2 text-xs font-semibold transition-transform hover:scale-105">
                                Continuar
                            </div>
                        </div>
                    </div>
                </div>

                <div class="gf-panel w-full min-w-0 rounded-3xl p-8 backdrop-blur-2xl">
                    <h2 class="mb-6 flex items-center gap-3 text-2xl font-semibold tracking-tight">
                        <div class="gf-surface-secondary flex h-10 w-10 items-center justify-center rounded-2xl">
                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="truncate">Recomendaciones</span>
                    </h2>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="gf-panel-strong gf-panel-hover-accent group min-w-0 cursor-pointer rounded-2xl p-4">
                            <div class="gf-surface-accent mb-3 flex h-24 w-full items-center justify-center rounded-xl transition-transform group-hover:scale-[1.02]">
                                <span class="text-2xl">🍄</span>
                            </div>
                            <p class="truncate text-sm font-semibold">Mario Kart GBA</p>
                            <p class="gf-text-subtle mt-1 truncate text-xs">Clásico multijugador</p>
                        </div>

                        <div class="gf-panel-strong gf-panel-hover-secondary group min-w-0 cursor-pointer rounded-2xl p-4">
                            <div class="gf-surface-secondary mb-3 flex h-24 w-full items-center justify-center rounded-xl transition-transform group-hover:scale-[1.02]">
                                <span class="text-2xl">🦎</span>
                            </div>
                            <p class="truncate text-sm font-semibold">Metroid Fusion</p>
                            <p class="gf-text-subtle mt-1 truncate text-xs">Aventura sci-fi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
