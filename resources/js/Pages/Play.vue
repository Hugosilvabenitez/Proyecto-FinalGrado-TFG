<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

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

defineOptions({
    layout: AuthenticatedLayout,
});
</script>

<template>
    <Head title="Play · GameFlux" />

    <div class="min-h-screen bg-slate-950 px-4 py-8 text-slate-100 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.35em] text-cyan-300/80">Catalogo cerrado</p>
                    <h1 class="mt-3 text-3xl font-semibold tracking-tight sm:text-4xl">Juega solo a los 15 juegos que definas</h1>
                    <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-400 sm:text-base">
                        Ya no dependes de que cada usuario suba una ROM. Ahora `/play` consume el catalogo publico de la base de datos y busca los archivos en
                        <span class="font-medium text-slate-200">{{ romsPath }}</span>.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-3 text-sm sm:w-auto">
                    <div class="rounded-2xl border border-emerald-400/20 bg-emerald-500/10 px-4 py-3">
                        <p class="text-slate-400">Instalados</p>
                        <p class="mt-1 text-2xl font-semibold text-emerald-300">{{ installedCount }}</p>
                    </div>
                    <div class="rounded-2xl border border-amber-400/20 bg-amber-500/10 px-4 py-3">
                        <p class="text-slate-400">Pendientes</p>
                        <p class="mt-1 text-2xl font-semibold text-amber-300">{{ missingCount }}</p>
                    </div>
                </div>
            </div>

            <div
                v-if="!emulatorReady"
                class="mb-6 rounded-2xl border border-amber-400/25 bg-amber-500/10 px-5 py-4 text-sm leading-6 text-amber-100"
            >
                El catalogo ya funciona, pero el repositorio no trae todavia el emulador completo en `public/emulator/gbajs2/index.html`.
                En cuanto copies ahi los archivos reales de `gbajs2`, la seleccion quedara conectada.
            </div>

            <div v-if="!roms.length" class="rounded-3xl border border-white/10 bg-slate-900/70 p-8 text-center text-slate-300">
                No hay juegos publicos en la tabla `roms`.
            </div>

            <div v-else class="grid gap-6 xl:grid-cols-[380px_minmax(0,1fr)]">
                <aside class="rounded-3xl border border-white/10 bg-slate-900/70 p-5 shadow-[0_0_30px_rgba(15,23,42,0.6)]">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-lg font-semibold">Catalogo</h2>
                        <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-slate-400">
                            {{ roms.length }} juegos
                        </span>
                    </div>

                    <div class="space-y-3">
                        <Link
                            v-for="rom in roms"
                            :key="rom.slug"
                            :href="route('play', { game: rom.slug })"
                            class="block rounded-2xl border px-4 py-4 no-underline transition-all"
                            :class="rom.slug === selectedRom?.slug
                                ? 'border-cyan-400/60 bg-cyan-400/10 shadow-[0_0_20px_rgba(34,211,238,0.16)]'
                                : 'border-white/10 bg-white/5 hover:border-white/20 hover:bg-white/10'"
                        >
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-slate-100">{{ rom.title }}</p>
                                    <p class="mt-1 text-xs uppercase tracking-[0.25em] text-slate-500">{{ rom.region || 'Region no indicada' }}</p>
                                </div>
                                <span
                                    class="shrink-0 rounded-full px-2.5 py-1 text-[11px] font-semibold"
                                    :class="rom.is_installed
                                        ? 'border border-emerald-400/20 bg-emerald-500/10 text-emerald-300'
                                        : 'border border-amber-400/20 bg-amber-500/10 text-amber-300'"
                                >
                                    {{ rom.is_installed ? 'Instalado' : 'Falta ROM' }}
                                </span>
                            </div>

                            <p class="mt-3 line-clamp-2 text-sm leading-6 text-slate-400">
                                {{ rom.description || 'Sin descripcion.' }}
                            </p>

                            <p class="mt-3 text-xs text-slate-500">
                                Archivo esperado: {{ rom.file_name }}
                            </p>
                        </Link>
                    </div>
                </aside>

                <section class="rounded-3xl border border-white/10 bg-slate-900/70 p-5 shadow-[0_0_30px_rgba(15,23,42,0.6)]">
                    <div v-if="selectedRom" class="mb-5">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.35em] text-fuchsia-300/80">Juego seleccionado</p>
                                <h2 class="mt-3 text-2xl font-semibold tracking-tight">{{ selectedRom.title }}</h2>
                                <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-400">
                                    {{ selectedRom.description || 'Sin descripcion disponible.' }}
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-2 text-xs">
                                <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-slate-300">
                                    {{ selectedRom.region || 'Region sin definir' }}
                                </span>
                                <span
                                    class="rounded-full px-3 py-1.5 font-semibold"
                                    :class="selectedRom.is_installed
                                        ? 'border border-emerald-400/20 bg-emerald-500/10 text-emerald-300'
                                        : 'border border-amber-400/20 bg-amber-500/10 text-amber-300'"
                                >
                                    {{ selectedRom.is_installed ? 'ROM disponible' : 'Pendiente de copiar' }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-4 rounded-2xl border border-white/10 bg-slate-950/60 px-4 py-3 text-sm text-slate-400">
                            <span class="text-slate-200">Ruta esperada:</span> {{ romsPath }}/{{ selectedRom.file_name }}
                        </div>
                    </div>

                    <div
                        v-if="selectedRom?.is_installed && iframeSrc"
                        class="overflow-hidden rounded-3xl border border-white/10 bg-black shadow-[0_0_30px_rgba(2,6,23,0.8)]"
                    >
                        <iframe
                            :src="iframeSrc"
                            :title="`Emulador ${selectedRom.title}`"
                            class="block h-[820px] w-full bg-black"
                        ></iframe>
                    </div>

                    <div
                        v-else
                        class="flex min-h-[520px] items-center justify-center rounded-3xl border border-dashed border-white/15 bg-slate-950/50 px-6 text-center"
                    >
                        <div class="max-w-xl">
                            <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-3xl bg-gradient-to-br from-cyan-400 via-blue-500 to-fuchsia-500 text-2xl shadow-[0_0_25px_rgba(56,189,248,0.45)]">
                                🎮
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
