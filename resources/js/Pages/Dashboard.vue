<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed, reactive, onMounted, onUnmounted } from 'vue';
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
    }
});

const formattedTime = computed(() => {
    const minutes = stats.total_minutes || 0;

    const h = Math.floor(minutes / 60);
    const m = minutes % 60;

    return `${h}h ${m}m`;
});

const stats = useStats();

stats.total_minutes = props.auth.user.stats?.total_minutes || 0;
stats.cloud_saves = props.auth.user.stats?.cloud_saves || 0;
stats.achievements_unlocked = props.auth.user.stats?.achievements_unlocked || 0;

defineOptions({
    layout: AuthenticatedLayout
});
</script>

<template>
        <Head title="Dashboard · GameFlux" />

        <div class="min-h-screen bg-slate-950 text-slate-100 relative overflow-hidden">
            <div class="pointer-events-none absolute inset-0">
                <div class="absolute -top-32 -left-24 h-72 w-72 bg-gradient-to-br from-cyan-500 via-blue-500 to-purple-600 opacity-40 blur-3xl"/>
                <div class="absolute -bottom-40 -right-20 h-80 w-80 bg-gradient-to-tr from-fuchsia-500 via-orange-400 to-yellow-300 opacity-40 blur-3xl"/>
            </div>
            <div class="pointer-events-none absolute inset-0 opacity-30 mix-blend-soft-light" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2240%22 height=%2240%22 viewBox=%220 0 40 40%22><rect width=%221%22 height=%221%22 fill=%22%23ffffff%22 opacity=%220.12%22/></svg>');"></div>
            
            <div class="relative z-10 px-4 py-8 max-w-6xl mx-auto">
                <div class="w-full max-w-2xl mx-auto mb-12">
                    <div class="flex flex-col items-center mb-8">
                        <img :src="props.auth?.user?.avatar_url" alt="Avatar" class="w-20 h-20 rounded-full border-4 border-white/20 shadow-[0_0_25px_rgba(59,130,246,0.75)] mb-4"/>
                        <h1 class="text-2xl font-semibold tracking-tight text-center mb-2">¡Hola, {{ props.auth.user.name.split(' ')[0] }}!</h1>
                        <p class="text-sm text-slate-300 text-center">Tu portal de emulación Game Boy Advance</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <button class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-gradient-to-r from-cyan-400 via-blue-500 to-fuchsia-500 text-white font-semibold tracking-wide uppercase text-sm shadow-[0_0_25px_rgba(56,189,248,0.9)] hover:shadow-[0_0_40px_rgba(244,114,182,0.9)] hover:scale-[1.02] transition-all disabled:opacity-60 disabled:cursor-not-allowed">Nueva partida</button>
                        <button class="w-full sm:w-auto px-6 py-3 rounded-2xl border border-white/10 bg-white/5 backdrop-blur-2xl text-slate-300 hover:border-cyan-400/60 hover:text-cyan-300 hover:shadow-[0_0_20px_rgba(56,189,248,0.6)] transition-all">Mis favoritos</button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl shadow-[0_0_40px_rgba(15,23,42,0.9)] p-8 transition duration-500 ease-out hover:border-cyan-400/60 hover:shadow-[0_0_60px_rgba(56,189,248,0.8)] hover:-translate-y-1 text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-[0_0_20px_rgba(16,185,129,0.6)]">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <p class="text-slate-400 text-xs uppercase tracking-wide mb-2">Partidas guardadas</p>
                        <p class="text-3xl font-bold text-slate-100">{{ stats.cloud_saves }}</p>
                        <p class="text-xs text-slate-500 mt-1">En la nube</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl shadow-[0_0_40px_rgba(15,23,42,0.9)] p-8 transition duration-500 ease-out hover:border-fuchsia-400/60 hover:shadow-[0_0_60px_rgba(244,114,182,0.8)] hover:-translate-y-1 text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-violet-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-[0_0_20px_rgba(168,85,247,0.6)]">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <p class="text-slate-400 text-xs uppercase tracking-wide mb-2">Horas jugadas</p>
                        <p class="text-3xl font-bold text-slate-100">{{ formattedTime }}</p>
                        <p class="text-xs text-slate-500 mt-1">Total emulador</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl shadow-[0_0_40px_rgba(15,23,42,0.9)] p-8 transition duration-500 ease-out hover:border-orange-400/60 hover:shadow-[0_0_60px_rgba(251,146,60,0.8)] hover:-translate-y-1 text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-[0_0_20px_rgba(251,191,36,0.6)]">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        <p class="text-slate-400 text-xs uppercase tracking-wide mb-2">Logros</p>
                        <p class="text-3xl font-bold text-slate-100">{{ stats.achievements_unlocked }}</p>
                        <p class="text-xs text-slate-500 mt-1">De - totales</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="w-full lg:max-w-2xl rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl shadow-[0_0_40px_rgba(15,23,42,0.9)] p-8">
                        <h2 class="text-2xl font-semibold tracking-tight mb-6 flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            Mis juegos recientes
                        </h2>
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-900/60 border border-slate-700/70 hover:border-cyan-400/60 hover:shadow-[0_0_20px_rgba(56,189,248,0.4)] transition-all group cursor-pointer">
                                <div class="w-16 h-20 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0">
                                    <span class="text-2xl">🟥</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-slate-200 truncate">Pokémon FireRed</p>
                                    <p class="text-sm text-slate-400">Última partida: hace 2h</p>
                                </div>
                                <div class="w-24 h-10 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center text-white font-semibold text-xs shadow-lg group-hover:scale-105 transition-transform">Continuar partida</div>
                            </div>
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-900/60 border border-slate-700/70 hover:border-fuchsia-400/60 hover:shadow-[0_0_20px_rgba(244,114,182,0.4)] transition-all group cursor-pointer">
                                <div class="w-16 h-20 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0">
                                    <span class="text-2xl">⭐</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-slate-200 truncate">Zelda: Minish Cap</p>
                                    <p class="text-sm text-slate-400">Última partida: hace 1 día</p>
                                </div>
                                <div class="w-24 h-10 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center text-white font-semibold text-xs shadow-lg group-hover:scale-105 transition-transform">Continuar partida</div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl shadow-[0_0_40px_rgba(15,23,42,0.9)] p-8">
                        <h2 class="text-2xl font-semibold tracking-tight mb-6 flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-fuchsia-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            Recomendaciones
                        </h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="group p-4 rounded-2xl bg-slate-900/60 border border-slate-700/70 hover:border-cyan-400/60 hover:shadow-[0_0_20px_rgba(56,189,248,0.4)] transition-all cursor-pointer">
                                <div class="w-full h-24 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl mb-3 shadow-lg flex items-center justify-center group-hover:scale-[1.02] transition-transform">
                                    <span class="text-2xl">🍄</span>
                                </div>
                                <p class="font-semibold text-slate-200 text-sm">Mario Kart GBA</p>
                                <p class="text-xs text-slate-500 mt-1">Clásico multijugador</p>
                            </div>
                            <div class="group p-4 rounded-2xl bg-slate-900/60 border border-slate-700/70 hover:border-orange-400/60 hover:shadow-[0_0_20px_rgba(251,146,60,0.4)] transition-all cursor-pointer">
                                <div class="w-full h-24 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl mb-3 shadow-lg flex items-center justify-center group-hover:scale-[1.02] transition-transform">
                                    <span class="text-2xl">🦎</span>
                                </div>
                                <p class="font-semibold text-slate-200 text-sm">Metroid Fusion</p>
                                <p class="text-xs text-slate-500 mt-1">Aventura sci-fi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>
