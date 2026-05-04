<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
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
    savedGames: {
        type: Array,
        default: () => [],
    },
});

const stats = useStats();

stats.total_minutes = props.auth.user.stats?.total_minutes || 0;
stats.cloud_saves = props.savedGames.length;
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

const svgToDataUri = (svg) => `data:image/svg+xml;utf8,${encodeURIComponent(svg)}`;

const recommendations = [
    {
        title: 'The Legend of Zelda: The Minish Cap',
        subtitle: 'Aventura, mazmorras y magia',
        href: route('play', { game: 'the-legend-of-zelda-the-minish-cap' }),
        borderClass: 'hover:border-emerald-400/60 hover:shadow-[0_0_20px_rgba(52,211,153,0.38)]',
        image: svgToDataUri(`
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 360">
                <defs>
                    <linearGradient id="sky" x1="0" x2="1" y1="0" y2="1">
                        <stop offset="0" stop-color="#134e4a"/>
                        <stop offset="0.55" stop-color="#166534"/>
                        <stop offset="1" stop-color="#facc15"/>
                    </linearGradient>
                    <radialGradient id="glow" cx="50%" cy="42%" r="44%">
                        <stop offset="0" stop-color="#fef08a" stop-opacity="0.95"/>
                        <stop offset="1" stop-color="#fef08a" stop-opacity="0"/>
                    </radialGradient>
                </defs>
                <rect width="640" height="360" fill="url(#sky)"/>
                <circle cx="420" cy="110" r="135" fill="url(#glow)"/>
                <path d="M0 242 C90 186 158 208 234 166 C334 112 410 152 484 112 C545 80 588 88 640 54 L640 360 L0 360 Z" fill="#052e16" opacity="0.88"/>
                <path d="M0 284 C92 246 190 262 276 224 C384 176 485 200 640 142 L640 360 L0 360 Z" fill="#064e3b"/>
                <path d="M108 126 L170 282 L46 282 Z" fill="#14532d"/>
                <path d="M528 106 L594 282 L460 282 Z" fill="#14532d"/>
                <path d="M319 70 L346 132 L412 138 L362 181 L378 246 L319 212 L260 246 L276 181 L226 138 L292 132 Z" fill="#fde68a" opacity="0.9"/>
                <path d="M310 93 L334 147 L392 153 L348 190 L362 247 L310 217 L258 247 L272 190 L228 153 L286 147 Z" fill="#f59e0b" opacity="0.55"/>
                <path d="M314 122 L314 252" stroke="#f8fafc" stroke-width="15" stroke-linecap="round"/>
                <path d="M314 122 L292 164 L336 164 Z" fill="#e0f2fe"/>
                <path d="M270 184 L358 184" stroke="#fbbf24" stroke-width="18" stroke-linecap="round"/>
                <path d="M286 254 C286 226 342 226 342 254 L342 292 L286 292 Z" fill="#0f766e"/>
                <path d="M298 258 L330 258 L330 292 L298 292 Z" fill="#facc15"/>
            </svg>
        `),
    },
    {
        title: 'Mario Kart: Super Circuit',
        subtitle: 'Carreras arcade a toda velocidad',
        href: route('play', { game: 'mario-kart-super-circuit' }),
        borderClass: 'hover:border-red-400/60 hover:shadow-[0_0_20px_rgba(248,113,113,0.38)]',
        image: svgToDataUri(`
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 360">
                <defs>
                    <linearGradient id="sunset" x1="0" x2="1" y1="0" y2="1">
                        <stop offset="0" stop-color="#38bdf8"/>
                        <stop offset="0.52" stop-color="#f97316"/>
                        <stop offset="1" stop-color="#dc2626"/>
                    </linearGradient>
                    <linearGradient id="road" x1="0" x2="1">
                        <stop offset="0" stop-color="#111827"/>
                        <stop offset="0.5" stop-color="#475569"/>
                        <stop offset="1" stop-color="#111827"/>
                    </linearGradient>
                </defs>
                <rect width="640" height="360" fill="url(#sunset)"/>
                <circle cx="518" cy="82" r="52" fill="#fef3c7" opacity="0.95"/>
                <path d="M0 166 C94 126 171 138 260 112 C362 82 438 121 640 70 L640 360 L0 360 Z" fill="#166534" opacity="0.86"/>
                <path d="M0 250 C132 170 210 198 320 180 C443 160 520 184 640 126 L640 360 L0 360 Z" fill="#22c55e"/>
                <path d="M250 164 C220 220 190 280 148 360 L492 360 C448 280 418 220 388 164 Z" fill="url(#road)"/>
                <path d="M314 180 L306 216 M296 244 L284 298 M275 326 L268 360" stroke="#f8fafc" stroke-width="12" stroke-linecap="round" opacity="0.88"/>
                <path d="M214 282 C250 230 386 230 426 282 L452 314 C420 338 230 338 188 314 Z" fill="#ef4444"/>
                <path d="M246 252 C272 222 368 222 396 252 L376 276 L266 276 Z" fill="#fde047"/>
                <circle cx="238" cy="316" r="34" fill="#020617"/>
                <circle cx="402" cy="316" r="34" fill="#020617"/>
                <circle cx="238" cy="316" r="15" fill="#94a3b8"/>
                <circle cx="402" cy="316" r="15" fill="#94a3b8"/>
                <path d="M90 194 H154 V226 H90 Z M122 226 H186 V258 H122 Z M454 190 H518 V222 H454 Z M486 222 H550 V254 H486 Z" fill="#f8fafc" opacity="0.9"/>
                <path d="M90 194 H122 V226 H90 Z M154 226 H186 V258 H154 Z M454 190 H486 V222 H454 Z M518 222 H550 V254 H518 Z" fill="#020617" opacity="0.88"/>
            </svg>
        `),
    },
];

const formatSavedAt = (date) => {
    if (!date) return 'Sin fecha registrada';

    return new Intl.DateTimeFormat('es-ES', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    }).format(new Date(date));
};

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
                    <Link
                        :href="route('play')"
                        class="w-full rounded-2xl bg-gradient-to-r from-cyan-400 via-blue-500 to-fuchsia-500 px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-[0_0_25px_rgba(56,189,248,0.9)] transition-all hover:scale-[1.02] hover:shadow-[0_0_40px_rgba(244,114,182,0.9)] disabled:cursor-not-allowed disabled:opacity-60 sm:w-auto"
                    >
                        Nueva partida
                    </Link>

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
                    <p class="mt-1 text-xs text-slate-500">De 6 totales</p>
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
                        <span class="truncate">Partidas guardadas</span>
                    </h2>

                    <div v-if="savedGames.length" class="space-y-4 min-w-0">
                        <Link
                            v-for="save in savedGames"
                            :key="save.id"
                            :href="save.rom.play_url"
                            class="flex min-w-0 items-center gap-4 rounded-2xl border border-slate-700/70 bg-slate-900/60 p-4 no-underline transition-all hover:border-cyan-400/60 hover:shadow-[0_0_20px_rgba(56,189,248,0.4)]"
                        >
                            <div class="flex h-20 w-16 shrink-0 overflow-hidden rounded-xl border border-white/10 bg-gradient-to-br from-purple-500 to-pink-600 shadow-lg">
                                <img
                                    v-if="save.rom.cover_image"
                                    :src="save.rom.cover_image"
                                    :alt="`Carátula de ${save.rom.title}`"
                                    class="h-full w-full object-cover"
                                />
                                <div v-else class="flex h-full w-full items-center justify-center text-sm font-black text-white">
                                    GF
                                </div>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="truncate font-semibold text-slate-200">{{ save.rom.title }}</p>
                                <p class="truncate text-sm text-slate-400">{{ save.save_name }}</p>
                                <p class="truncate text-xs text-slate-500">Guardada: {{ formatSavedAt(save.updated_at) }}</p>
                            </div>

                            <div class="shrink-0 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 px-4 py-2 text-xs font-semibold text-white shadow-lg transition-transform hover:scale-105">
                                Continuar
                            </div>
                        </Link>
                    </div>

                    <div v-else class="rounded-2xl border border-dashed border-slate-700/70 bg-slate-900/40 p-6 text-center">
                        <p class="text-sm font-semibold text-slate-200">Todavía no hay partidas guardadas</p>
                        <p class="mt-2 text-sm leading-6 text-slate-400">
                            Cuando guardes una partida desde el emulador aparecerá aquí para continuarla rápido.
                        </p>
                        <Link
                            :href="route('play')"
                            class="mt-4 inline-flex rounded-xl bg-cyan-400/10 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-cyan-200 transition hover:bg-cyan-400/15"
                        >
                            Ir al catálogo
                        </Link>
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
                        <Link
                            v-for="game in recommendations"
                            :key="game.title"
                            :href="game.href"
                            class="group rounded-2xl border border-slate-700/70 bg-slate-900/60 p-4 no-underline transition-all min-w-0"
                            :class="game.borderClass"
                        >
                            <div class="mb-3 h-28 w-full overflow-hidden rounded-xl bg-slate-950 shadow-lg transition-transform group-hover:scale-[1.02]">
                                <img
                                    :src="game.image"
                                    :alt="`Imagen recomendada de ${game.title}`"
                                    class="h-full w-full object-cover"
                                />
                            </div>
                            <p class="truncate text-sm font-semibold text-slate-200">{{ game.title }}</p>
                            <p class="truncate text-xs text-slate-500 mt-1">{{ game.subtitle }}</p>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
