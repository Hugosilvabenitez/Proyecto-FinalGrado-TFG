<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

/**
* Play View
*
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-03-18
*
* This file contains all the code for generate the play area of Gameflux's project.
*/

const props = defineProps({
    roms: {
        type: Array,
        default: () => [],
    },
    selectedRom: {
        type: Object,
        default: null,
    },
    emulatorReady: {
        type: Boolean,
        default: false,
    },
    romsPath: {
        type: String,
        default: '',
    },
});

const installedCount = computed(() => props.roms.filter((rom) => rom.is_installed).length);
const missingCount = computed(() => props.roms.length - installedCount.value);
const iframeSrc = computed(() => props.selectedRom?.launch_url ?? null);
const isCatalogOpen = ref(true);

defineOptions({
    layout: AuthenticatedLayout,
});
</script>

<template>
    <Head title="Play · GameFlux" />

    <div class="h-screen overflow-hidden bg-slate-950 text-slate-100">
        <div class="mx-auto flex h-full max-w-[1640px] flex-col px-4 py-5 sm:px-6 lg:px-8">
            <div class="mb-4 flex flex-col gap-3 border-b border-white/10 pb-4 xl:flex-row xl:items-center xl:justify-between">
                <div class="flex min-w-0 items-center gap-3">
                    <div class="min-w-0">
                        <p class="text-xs uppercase tracking-[0.28em] text-cyan-300/80">GameFlux Play</p>
                        <h1 class="truncate text-xl font-semibold tracking-tight text-white sm:text-2xl">
                            {{ selectedRom?.title || 'Selecciona un juego' }}
                        </h1>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2 text-xs">
                    <button
                        type="button"
                        class="inline-flex h-9 items-center justify-center rounded-lg border border-cyan-300/20 bg-cyan-300/10 px-3 font-semibold text-cyan-100 transition hover:border-cyan-300/40 hover:bg-cyan-300/15"
                        :aria-expanded="isCatalogOpen"
                        aria-controls="play-catalog"
                        @click="isCatalogOpen = !isCatalogOpen"
                    >
                        {{ isCatalogOpen ? 'Ocultar catálogo' : 'Mostrar catálogo' }}
                    </button>
                    <span class="rounded-lg border border-emerald-400/20 bg-emerald-500/10 px-3 py-2 text-emerald-200">
                        {{ installedCount }} instalados
                    </span>
                    <span class="rounded-lg border border-amber-400/20 bg-amber-500/10 px-3 py-2 text-amber-200">
                        {{ missingCount }} pendientes
                    </span>
                    <span v-if="selectedRom" class="rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-slate-300">
                        {{ selectedRom.region || 'Región no indicada' }}
                    </span>
                </div>
            </div>

            <div
                v-if="!emulatorReady"
                class="mb-4 rounded-lg border border-amber-400/25 bg-amber-500/10 px-4 py-3 text-sm leading-6 text-amber-100"
            >
                El catalogo ya funciona, pero el repositorio no trae todavia el emulador completo en `public/emulator/gbajs2/index.html`.
                En cuanto copies ahi los archivos reales de `gbajs2`, la seleccion quedara conectada.
            </div>

            <div v-if="!roms.length" class="rounded-lg border border-white/10 bg-slate-900/70 p-8 text-center text-slate-300">
                No hay juegos publicos en la tabla `roms`.
            </div>

            <div v-else class="relative flex min-h-0 flex-1 gap-4 overflow-hidden">
                <aside
                    id="play-catalog"
                    class="fixed inset-y-0 left-0 z-40 h-full w-[86vw] max-w-sm border-r border-white/10 bg-slate-950/98 p-4 pt-20 shadow-2xl transition-[transform,width,opacity,padding,border] duration-300 lg:static lg:z-auto lg:h-full lg:max-w-none lg:shrink-0 lg:rounded-lg lg:border lg:bg-slate-900/70 lg:p-4 lg:pt-4 lg:shadow-[0_0_30px_rgba(15,23,42,0.45)]"
                    :class="isCatalogOpen ? 'translate-x-0 lg:w-80' : '-translate-x-full lg:w-0 lg:overflow-hidden lg:border-0 lg:p-0 lg:opacity-0'"
                >
                    <div class="flex h-full min-h-0 flex-col">
                        <div class="mb-3 flex items-center justify-between gap-3">
                            <div>
                                <h2 class="text-base font-semibold">Catálogo</h2>
                                <p class="mt-1 text-xs text-slate-500">{{ roms.length }} juegos disponibles</p>
                            </div>
                        </div>

                        <div class="min-h-0 flex-1 space-y-2 overflow-y-auto pr-1">
                            <Link
                                v-for="rom in roms"
                                :key="rom.slug"
                                :href="route('play', { game: rom.slug })"
                                class="block rounded-lg border px-3 py-3 no-underline transition-all"
                                :class="rom.slug === selectedRom?.slug
                                    ? 'border-cyan-400/60 bg-cyan-400/10 shadow-[0_0_18px_rgba(34,211,238,0.14)]'
                                    : 'border-white/10 bg-white/[0.03] hover:border-white/20 hover:bg-white/10'"
                            >
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-slate-100">{{ rom.title }}</p>
                                        <p class="mt-1 text-[11px] uppercase tracking-[0.22em] text-slate-500">{{ rom.region || 'Región no indicada' }}</p>
                                    </div>
                                    <span
                                        class="shrink-0 rounded-md px-2 py-1 text-[10px] font-semibold"
                                        :class="rom.is_installed
                                            ? 'border border-emerald-400/20 bg-emerald-500/10 text-emerald-300'
                                            : 'border border-amber-400/20 bg-amber-500/10 text-amber-300'"
                                    >
                                        {{ rom.is_installed ? 'Instalado' : 'Falta' }}
                                    </span>
                                </div>

                                <p class="mt-2 line-clamp-2 text-xs leading-5 text-slate-400">
                                    {{ rom.description || 'Sin descripcion.' }}
                                </p>
                            </Link>
                        </div>
                    </div>
                </aside>

                <div
                    v-if="isCatalogOpen"
                    class="fixed inset-0 z-30 bg-black/50 lg:hidden"
                    @click="isCatalogOpen = false"
                ></div>

                <section class="flex h-full min-h-0 min-w-0 flex-1 flex-col overflow-hidden rounded-lg border border-white/10 bg-slate-900/70 shadow-[0_0_30px_rgba(15,23,42,0.45)]">
                    <div v-if="selectedRom" class="flex flex-col gap-3 border-b border-white/10 px-4 py-3 xl:flex-row xl:items-center xl:justify-between">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="truncate text-lg font-semibold tracking-tight">{{ selectedRom.title }}</h2>
                                <span
                                    class="rounded-md px-2 py-1 text-[11px] font-semibold"
                                    :class="selectedRom.is_installed
                                        ? 'border border-emerald-400/20 bg-emerald-500/10 text-emerald-300'
                                        : 'border border-amber-400/20 bg-amber-500/10 text-amber-300'"
                                >
                                    {{ selectedRom.is_installed ? 'ROM disponible' : 'Pendiente de copiar' }}
                                </span>
                            </div>
                            <p class="mt-1 truncate text-sm text-slate-400">
                                {{ selectedRom.description || 'Sin descripcion disponible.' }}
                            </p>
                        </div>
                    </div>

                    <div
                        v-if="selectedRom?.is_installed && iframeSrc"
                        class="min-h-0 flex-1 bg-black"
                    >
                        <iframe
                            :src="iframeSrc"
                            :title="`Emulador ${selectedRom.title}`"
                            class="block h-full min-h-0 w-full bg-black"
                        ></iframe>
                    </div>

                    <div
                        v-else
                        class="flex min-h-0 flex-1 items-center justify-center bg-slate-950/50 px-6 text-center"
                    >
                        <div class="max-w-xl">
                            <div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-lg border border-cyan-300/30 bg-cyan-300/10 text-xl font-black text-cyan-100 shadow-[0_0_25px_rgba(56,189,248,0.22)]">
                                GF
                            </div>
                            <h3 class="text-xl font-semibold text-slate-100">
                                {{ selectedRom?.is_installed ? 'El emulador esta pendiente' : 'Falta copiar la ROM' }}
                            </h3>
                            <p class="mt-3 text-sm leading-6 text-slate-400">
                                <span v-if="selectedRom?.is_installed">
                                    El juego ya esta registrado, pero el emulador `gbajs2` no esta completo en el repositorio actual.
                                </span>
                                <span v-else>
                                    Copia el archivo `{{ selectedRom?.file_name }}` dentro de `{{ romsPath }}` para habilitar este juego.
                                </span>
                            </p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>
