<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

/**
* Achievements View
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-03-18
* 
* This file contains all the code for generate the achievements view of Gameflux's project.
*/

interface Achievement {
    id: number;
    name: string;
    description: string;
    icon?: string | null;
    points?: number | null;
    unlocked: boolean;
    unlocked_at?: string | null;
}

interface Props {
    achievements: Achievement[];
}

defineProps<Props>();

const formatDate = (value?: string | null) => {
    if (!value) return 'Pendiente';

    return new Date(value).toLocaleDateString('es-ES', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    });
};

const stateClasses = (unlocked: boolean) => {
    return unlocked
        ? 'border-cyan-400/20 bg-cyan-400/10 text-cyan-300'
        : 'border-white/10 bg-white/5 text-slate-400';
};

const stateLabel = (unlocked: boolean) => {
    return unlocked ? 'Desbloqueado' : 'Bloqueado';
};

const stateGlow = (unlocked: boolean) => {
    return unlocked
        ? 'shadow-[0_0_30px_rgba(56,189,248,0.14)] hover:border-cyan-400/30'
        : 'hover:border-white/20';
};

const iconFallback = (achievement: Achievement) => {
    return achievement.icon || '🏆';
};

defineOptions({
    layout: AuthenticatedLayout
});
</script>

<template>
    <Head title="Logros · GameFlux" />
        <div class="min-h-screen bg-slate-950 px-4 py-8 text-slate-100 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl space-y-8">
                <section class="grid gap-4 lg:grid-cols-[1.35fr_0.85fr_0.85fr]">
                    <div class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-[radial-gradient(circle_at_top_right,_rgba(56,189,248,0.16),_transparent_40%),linear-gradient(180deg,rgba(15,23,42,.88),rgba(2,6,23,.96))] p-7 shadow-[0_0_40px_rgba(15,23,42,0.8)]">
                        <div class="absolute right-0 top-0 h-44 w-44 rounded-full bg-cyan-400/10 blur-3xl"></div>

                        <div class="relative space-y-4">
                            <div class="inline-flex rounded-full border border-cyan-400/20 bg-cyan-400/10 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.28em] text-cyan-300">
                                Logros
                            </div>

                            <div>
                                <h1 class="text-3xl font-black tracking-tight text-white sm:text-4xl">
                                    Logros del jugador
                                </h1>
                                <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-400">
                                    Consulta tu progreso, revisa qué recompensas ya has desbloqueado y cuáles siguen pendientes.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-6 backdrop-blur-xl">
                        <p class="text-xs uppercase tracking-[0.28em] text-slate-400">Progreso</p>
                        <p class="mt-3 text-3xl font-black text-cyan-300">
                            {{ achievements.filter((a) => a.unlocked).length }}
                        </p>
                        <p class="mt-2 text-sm text-slate-500">Logros desbloqueados</p>
                        <div class="mt-6 h-px bg-white/10"></div>
                        <p class="mt-5 text-sm text-slate-400">
                            Sigue completando retos para subir tu nivel.
                        </p>
                    </div>

                    <div class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-6 backdrop-blur-xl">
                        <p class="text-xs uppercase tracking-[0.28em] text-slate-400">Total</p>
                        <p class="mt-3 text-3xl font-black text-white">
                            {{ achievements.length }}
                        </p>
                        <p class="mt-2 text-sm text-slate-500">Logros disponibles</p>
                    </div>
                </section>

                <section class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-5 shadow-[0_0_35px_rgba(15,23,42,0.75)] backdrop-blur-2xl sm:p-6">
                    <div class="mb-5 flex items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-white">Colección</h3>
                            <p class="text-sm text-slate-400">Consulta los logros disponibles.</p>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                        <article
                            v-for="achievement in achievements"
                            :key="achievement.id"
                            class="group rounded-[1.5rem] border p-5 transition"
                            :class="[stateClasses(achievement.unlocked), stateGlow(achievement.unlocked)]">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex h-14 w-14 items-center justify-center rounded-2xl border border-white/10 bg-slate-950/70 text-2xl">
                                        {{ iconFallback(achievement) }}
                                    </div>

                                    <div>
                                        <h4 class="text-base font-semibold text-white">
                                            {{ achievement.name }}
                                        </h4>
                                        <p class="mt-1 text-sm text-slate-400">
                                            {{ achievement.description }}
                                        </p>
                                    </div>
                                </div>

                                <span
                                    class="rounded-full border px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.22em]"
                                    :class="stateClasses(achievement.unlocked)">
                                    {{ stateLabel(achievement.unlocked) }}
                                </span>
                            </div>

                            <div class="mt-5 grid grid-cols-2 gap-3">
                                <div class="rounded-2xl border border-white/10 bg-slate-950/60 p-3">
                                    <p class="text-[11px] uppercase tracking-[0.22em] text-slate-500">Puntos</p>
                                    <p class="mt-1 text-sm font-semibold text-white">
                                        {{ achievement.points ?? 0 }}
                                    </p>
                                </div>

                                <div class="rounded-2xl border border-white/10 bg-slate-950/60 p-3">
                                    <p class="text-[11px] uppercase tracking-[0.22em] text-slate-500">Fecha</p>
                                    <p class="mt-1 text-sm font-semibold text-white">
                                        {{ formatDate(achievement.unlocked_at) }}
                                    </p>
                                </div>
                            </div>
                        </article>

                        <div
                            v-if="!achievements.length"
                            class="col-span-full rounded-[1.5rem] border border-dashed border-white/10 bg-white/[0.03] px-6 py-14 text-center">
                            <p class="text-lg font-semibold text-white">No hay logros todavía</p>
                            <p class="mt-2 text-sm text-slate-500">
                                Cuando el servidor envíe los datos, aparecerán aquí.
                            </p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    
</template>