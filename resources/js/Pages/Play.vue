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

    <div class="gf-page h-screen overflow-hidden">
        <div class="mx-auto flex h-full max-w-[1640px] flex-col px-4 py-5 sm:px-6 lg:px-8">
            <div class="mb-4 flex flex-col gap-3 border-b pb-4 xl:flex-row xl:items-center xl:justify-between" :style="{ borderColor: 'var(--gf-line)' }">
                <div class="flex min-w-0 items-center gap-3">
                    <div class="min-w-0">
                        <p class="gf-text-accent text-xs uppercase tracking-[0.28em]">GameFlux Play</p>
                        <h1 class="truncate text-xl font-semibold tracking-tight sm:text-2xl">
                            {{ selectedRom?.title || 'Selecciona un juego' }}
                        </h1>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2 text-xs">
                    <button
                        type="button"
                        class="gf-chip gf-chip-accent inline-flex h-9 items-center justify-center rounded-lg px-3 font-semibold transition"
                        :aria-expanded="isCatalogOpen"
                        aria-controls="play-catalog"
                        @click="isCatalogOpen = !isCatalogOpen"
                    >
                        {{ isCatalogOpen ? 'Ocultar catálogo' : 'Mostrar catálogo' }}
                    </button>
                    <span class="gf-chip gf-chip-success rounded-lg px-3 py-2">
                        {{ installedCount }} instalados
                    </span>
                    <span class="gf-chip gf-chip-warning rounded-lg px-3 py-2">
                        {{ missingCount }} pendientes
                    </span>
                    <span v-if="selectedRom" class="gf-chip rounded-lg px-3 py-2">
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

            <div v-if="!roms.length" class="gf-panel rounded-lg p-8 text-center gf-text-muted">
                No hay juegos publicos en la tabla `roms`.
            </div>

            <div v-else class="relative flex min-h-0 flex-1 gap-4 overflow-hidden">
                <aside
                    id="play-catalog"
                    class="gf-panel-strong fixed inset-y-0 left-0 z-40 h-full w-[86vw] max-w-sm border-r p-4 pt-20 shadow-2xl transition-[transform,width,opacity,padding,border] duration-300 lg:static lg:z-auto lg:h-full lg:max-w-none lg:shrink-0 lg:rounded-lg lg:border lg:p-4 lg:pt-4 lg:shadow-[0_0_30px_rgba(15,23,42,0.45)]"
                    :class="isCatalogOpen ? 'translate-x-0 lg:w-80' : '-translate-x-full lg:w-0 lg:overflow-hidden lg:border-0 lg:p-0 lg:opacity-0'"
                >
                    <div class="flex h-full min-h-0 flex-col">
                        <div class="mb-3 flex items-center justify-between gap-3">
                            <div>
                                <h2 class="text-base font-semibold">Catálogo</h2>
                                <p class="gf-text-subtle mt-1 text-xs">{{ roms.length }} juegos disponibles</p>
                            </div>
                        </div>

                        <div class="min-h-0 flex-1 space-y-2 overflow-y-auto pr-1">
                            <Link
                                v-for="rom in roms"
                                :key="rom.slug"
                                :href="route('play', { game: rom.slug })"
                                class="block rounded-lg border px-3 py-3 no-underline transition-all"
                                :class="rom.slug === selectedRom?.slug
                                    ? 'gf-chip-accent shadow-[0_0_18px_rgba(34,211,238,0.14)]'
                                    : 'gf-panel-soft gf-panel-soft-hover'"
                            >
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold">{{ rom.title }}</p>
                                        <p class="gf-text-subtle mt-1 text-[11px] uppercase tracking-[0.22em]">{{ rom.region || 'Región no indicada' }}</p>
                                    </div>
                                    <span
                                        class="shrink-0 rounded-md px-2 py-1 text-[10px] font-semibold"
                                        :class="rom.is_installed
                                            ? 'gf-chip-success'
                                            : 'gf-chip-warning'"
                                    >
                                        {{ rom.is_installed ? 'Instalado' : 'Falta' }}
                                    </span>
                                </div>

                                <p class="gf-text-muted mt-2 line-clamp-2 text-xs leading-5">
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

                <section class="gf-panel flex h-full min-h-0 min-w-0 flex-1 flex-col overflow-hidden rounded-lg">
                    <div v-if="selectedRom" class="flex flex-col gap-3 border-b px-4 py-3 xl:flex-row xl:items-center xl:justify-between" :style="{ borderColor: 'var(--gf-line)' }">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="truncate text-lg font-semibold tracking-tight">{{ selectedRom.title }}</h2>
                                <span
                                    class="rounded-md px-2 py-1 text-[11px] font-semibold"
                                    :class="selectedRom.is_installed
                                        ? 'gf-chip-success'
                                        : 'gf-chip-warning'"
                                >
                                    {{ selectedRom.is_installed ? 'ROM disponible' : 'Pendiente de copiar' }}
                                </span>
                            </div>
                            <p class="gf-text-muted mt-1 truncate text-sm">
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
                        class="gf-panel-strong flex min-h-0 flex-1 items-center justify-center px-6 text-center"
                    >
                        <div class="max-w-xl">
                            <div class="gf-chip gf-chip-accent mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-lg text-xl font-black shadow-[0_0_25px_rgba(56,189,248,0.22)]">
                                GF
                            </div>
                            <h3 class="text-xl font-semibold">
                                {{ selectedRom?.is_installed ? 'El emulador esta pendiente' : 'Falta copiar la ROM' }}
                            </h3>
                            <p class="gf-text-muted mt-3 text-sm leading-6">
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
