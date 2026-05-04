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
        ? 'gf-chip-accent'
        : 'gf-chip';
};

const stateLabel = (unlocked: boolean) => {
    return unlocked ? 'Desbloqueado' : 'Bloqueado';
};

const stateGlow = (unlocked: boolean) => {
    return unlocked
        ? 'gf-panel-hover-accent shadow-[0_0_30px_rgba(56,189,248,0.14)]'
        : 'gf-panel-hover-secondary';
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
        <div class="gf-page min-h-screen px-4 py-8 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl space-y-8">
                <section class="grid gap-4 lg:grid-cols-[1.35fr_0.85fr_0.85fr]">
                    <div class="gf-panel-hero relative overflow-hidden rounded-[2rem] p-7">
                        <div class="gf-page-orb-primary absolute right-0 top-0 h-44 w-44 rounded-full"></div>

                        <div class="relative space-y-4">
                            <div class="gf-chip gf-chip-accent inline-flex rounded-full px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.28em]">
                                Achievements
                            </div>

                            <div>
                                <h1 class="text-3xl font-black tracking-tight sm:text-4xl">
                                    Logros del jugador
                                </h1>
                                <p class="gf-text-muted mt-3 max-w-2xl text-sm leading-6">
                                    Consulta tu progreso, revisa qué recompensas ya has desbloqueado y cuáles siguen pendientes.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="gf-panel rounded-[2rem] p-6 backdrop-blur-xl">
                        <p class="gf-text-subtle text-xs uppercase tracking-[0.28em]">Progreso</p>
                        <p class="gf-text-accent mt-3 text-3xl font-black">
                            {{ achievements.filter((a) => a.unlocked).length }}
                        </p>
                        <p class="gf-text-subtle mt-2 text-sm">Logros desbloqueados</p>
                        <div class="gf-divider mt-6 h-px"></div>
                        <p class="gf-text-muted mt-5 text-sm">
                            Sigue completando retos para subir tu nivel.
                        </p>
                    </div>

                    <div class="gf-panel rounded-[2rem] p-6 backdrop-blur-xl">
                        <p class="gf-text-subtle text-xs uppercase tracking-[0.28em]">Total</p>
                        <p class="mt-3 text-3xl font-black">
                            {{ achievements.length }}
                        </p>
                        <p class="gf-text-subtle mt-2 text-sm">Logros disponibles</p>
                        <div class="gf-divider mt-6 h-px"></div>
                        <p class="gf-text-muted mt-5 text-sm">
                            Recompensas de progreso y juego.
                        </p>
                    </div>
                </section>

                <section class="gf-panel rounded-[2rem] p-5 backdrop-blur-2xl sm:p-6">
                    <div class="mb-5 flex items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold">Colección</h3>
                            <p class="gf-text-muted text-sm">Consulta los logros disponibles.</p>
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
                                        class="gf-panel-strong flex h-14 w-14 items-center justify-center rounded-2xl text-2xl">
                                        {{ iconFallback(achievement) }}
                                    </div>

                                    <div>
                                        <h4 class="text-base font-semibold">
                                            {{ achievement.name }}
                                        </h4>
                                        <p class="gf-text-muted mt-1 text-sm">
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
                                <div class="gf-panel-strong rounded-2xl p-3">
                                    <p class="gf-text-subtle text-[11px] uppercase tracking-[0.22em]">Puntos</p>
                                    <p class="mt-1 text-sm font-semibold">
                                        {{ achievement.points ?? 0 }}
                                    </p>
                                </div>

                                <div class="gf-panel-strong rounded-2xl p-3">
                                    <p class="gf-text-subtle text-[11px] uppercase tracking-[0.22em]">Fecha</p>
                                    <p class="mt-1 text-sm font-semibold">
                                        {{ formatDate(achievement.unlocked_at) }}
                                    </p>
                                </div>
                            </div>
                        </article>

                        <div
                            v-if="!achievements.length"
                            class="gf-panel-soft col-span-full rounded-[1.5rem] border-dashed px-6 py-14 text-center">
                            <p class="text-lg font-semibold">No hay logros todavía</p>
                            <p class="gf-text-subtle mt-2 text-sm">
                                Cuando el servidor envíe los datos, aparecerán aquí.
                            </p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    
</template>
