<script setup>
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

/**
* Update Emulator Preferences Form Tpl
*
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-05-04
*
* This file contains the code for updating the user's emulator preferences.
*/

const props = defineProps({
    emulatorPreferences: {
        type: Object,
        default: () => ({}),
    },
    themePresets: {
        type: Object,
        default: () => ({}),
    },
    selectedTheme: {
        type: String,
        default: 'nebula',
    },
    customPalette: {
        type: Object,
        default: () => ({}),
    },
    paletteFields: {
        type: Object,
        default: () => ({}),
    },
    themePaletteDefaults: {
        type: Object,
        default: () => ({}),
    },
    customThemeKey: {
        type: String,
        default: 'custom',
    },
    status: {
        type: String,
        default: '',
    },
});

const defaultPalette = {
    background: '#020617',
    surface: '#0f172a',
    text: '#f8fafc',
    accent: '#67e8f9',
    secondary: '#f472b6',
};

const normalizePalette = (palette) => ({
    ...defaultPalette,
    ...(palette ?? {}),
});

const form = useForm({
    audio_volume: props.emulatorPreferences.audio_volume ?? 100,
    theme: props.selectedTheme ?? 'nebula',
    emulator_background: props.emulatorPreferences.emulator_background ?? 'nebula',
    custom_palette: normalizePalette(props.customPalette),
});

const isCustomThemeActive = computed(() => (
    form.theme === props.customThemeKey
));

const activePresetLabel = computed(() => {
    if (isCustomThemeActive.value) {
        return 'Modo personalizado';
    }

    return props.themePresets[form.theme]?.label || 'Sin preset';
});

const customPreviewBackground = computed(() => (
    `radial-gradient(circle at top, color-mix(in srgb, ${form.custom_palette.accent} 24%, transparent), transparent 36%), linear-gradient(135deg, ${form.custom_palette.background} 0%, ${form.custom_palette.surface} 58%, ${form.custom_palette.secondary} 140%)`
));

const selectTheme = (themeKey) => {
    form.theme = themeKey;
};

const selectCustomTheme = () => {
    form.theme = props.customThemeKey;
};

const loadPresetIntoCustomPalette = (themeKey) => {
    form.custom_palette = normalizePalette(props.themePaletteDefaults[themeKey]);
    form.theme = props.customThemeKey;
};

const updatePaletteColor = (field, value) => {
    form.theme = props.customThemeKey;
    form.custom_palette = {
        ...form.custom_palette,
        [field]: value,
    };
};

const updatePreferences = () => {
    form.patch(route('profile.preferences.update'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <section class="space-y-5">
        <header class="space-y-1">
            <h2 class="text-lg font-semibold tracking-tight" :style="{ color: 'var(--gf-text)' }">
                Apariencia y sonido
            </h2>

            <p class="text-sm" :style="{ color: 'var(--gf-muted)' }">
                Elige una paleta ya preparada o crea la tuya a mano, y ajusta también el volumen de los juegos.
            </p>
        </header>

        <form @submit.prevent="updatePreferences" class="space-y-6">
            <section class="space-y-3">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h3 class="gf-text-accent text-sm font-semibold uppercase tracking-[0.18em]">Paletas predefinidas</h3>
                        <p class="gf-text-subtle mt-1 text-xs">Si no quieres complicarte, elige una combinación ya equilibrada para toda la app.</p>
                    </div>
                    <span class="gf-badge-accent rounded-full px-3 py-1 text-xs font-semibold">
                        {{ activePresetLabel }}
                    </span>
                </div>

                <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                    <button
                        v-for="(preset, key) in themePresets"
                        :key="key"
                        type="button"
                        class="gf-choice-card overflow-hidden rounded-3xl text-left"
                        :class="form.theme === key
                            ? 'gf-choice-card-active'
                            : ''"
                        @click="selectTheme(key)"
                    >
                        <div class="aspect-[16/9] w-full" :style="{ background: preset.shell_background }"></div>
                        <div class="flex items-center justify-between gap-3 px-4 py-3">
                            <div>
                                <p class="text-sm font-semibold" :style="{ color: 'var(--gf-text)' }">{{ preset.label }}</p>
                                <p class="gf-text-subtle mt-1 text-xs">Base lista para todas las vistas.</p>
                            </div>
                            <span
                                class="h-3 w-3 rounded-full border border-white/30"
                                :style="{ backgroundColor: preset.accent }"
                            ></span>
                        </div>
                    </button>

                </div>

                <InputError :message="form.errors.theme" />
            </section>

            <section class="gf-panel-strong space-y-4 rounded-3xl p-5">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="gf-text-secondary text-sm font-semibold uppercase tracking-[0.18em]">Personalización manual</h3>
                        <p class="gf-text-subtle mt-1 text-xs">Aquí montas tu propia paleta. Al tocar cualquier color, se guarda como tema personalizado.</p>
                    </div>
                    <span class="gf-chip gf-chip-secondary rounded-full px-3 py-1 text-xs font-semibold">
                        {{ isCustomThemeActive ? 'Activa' : 'Lista para editar' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 gap-4 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,1.4fr)]">
                    <button
                        type="button"
                        class="gf-choice-card overflow-hidden rounded-3xl text-left"
                        :class="isCustomThemeActive
                            ? 'gf-choice-card-active'
                            : ''"
                        @click="selectCustomTheme"
                    >
                        <div class="aspect-[16/9] w-full" :style="{ background: customPreviewBackground }"></div>
                        <div class="flex items-center justify-between gap-3 px-4 py-3">
                            <div>
                                <p class="text-sm font-semibold" :style="{ color: 'var(--gf-text)' }">Tu paleta personalizada</p>
                                <p class="gf-text-subtle mt-1 text-xs">Actívala cuando quieras usar tus propios colores en toda la interfaz.</p>
                            </div>
                            <span
                                class="h-3 w-3 rounded-full border border-white/30"
                                :style="{ backgroundColor: form.custom_palette.accent }"
                            ></span>
                        </div>
                    </button>

                    <div class="space-y-3">
                        <div>
                            <h4 class="text-sm font-semibold" :style="{ color: 'var(--gf-text)' }">Partir de una base</h4>
                            <p class="gf-text-subtle mt-1 text-xs">Si quieres, carga una paleta predefinida en tu modo manual y retócala después.</p>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <button
                                v-for="(preset, key) in themePresets"
                                :key="`custom-base-${key}`"
                                type="button"
                                class="gf-chip rounded-full px-3 py-2 text-xs font-semibold transition hover:opacity-90"
                                @click="loadPresetIntoCustomPalette(key)"
                            >
                                Usar base {{ preset.label }}
                            </button>
                        </div>

                        <p class="gf-text-subtle text-xs">
                            Tu paleta manual se conserva aunque pruebes presets rápidos arriba.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-5">
                    <label
                        v-for="(field, key) in paletteFields"
                        :key="key"
                        class="gf-panel-soft flex min-h-28 flex-col justify-between rounded-2xl p-3"
                    >
                        <span>
                            <span class="block text-sm font-semibold" :style="{ color: 'var(--gf-text)' }">{{ field.label }}</span>
                            <span class="gf-text-subtle mt-1 block text-xs leading-5">{{ field.description }}</span>
                        </span>

                        <span class="mt-3 flex items-center gap-2">
                            <input
                                :value="form.custom_palette[key]"
                                type="color"
                                class="h-10 w-12 cursor-pointer rounded-lg border-0 bg-transparent p-0"
                                @input="updatePaletteColor(key, $event.target.value)"
                            >
                            <span class="gf-input min-w-0 flex-1 rounded-lg px-2 py-2 font-mono text-xs uppercase">
                                {{ form.custom_palette[key] }}
                            </span>
                        </span>
                    </label>
                </div>

                <InputError :message="form.errors.custom_palette" />
                <InputError :message="form.errors['custom_palette.background']" />
                <InputError :message="form.errors['custom_palette.surface']" />
                <InputError :message="form.errors['custom_palette.text']" />
                <InputError :message="form.errors['custom_palette.accent']" />
                <InputError :message="form.errors['custom_palette.secondary']" />
            </section>

            <section class="gf-panel-strong rounded-3xl p-5">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h3 class="gf-text-secondary text-sm font-semibold uppercase tracking-[0.18em]">Volumen de los juegos</h3>
                        <p class="gf-text-subtle mt-1 text-xs">Se aplicará automáticamente cuando abras cualquier juego.</p>
                    </div>
                    <span class="text-lg font-semibold" :style="{ color: 'var(--gf-secondary)' }">{{ form.audio_volume }}%</span>
                </div>

                <input
                    :value="form.audio_volume"
                    type="range"
                    min="0"
                    max="100"
                    step="1"
                    class="mt-4 block w-full"
                    :style="{ accentColor: 'var(--gf-secondary)' }"
                    @input="form.audio_volume = Number($event.target.value)"
                >

                <div class="gf-text-subtle mt-2 flex items-center justify-between text-[11px] uppercase tracking-[0.18em]">
                    <span>Silencio</span>
                    <span>Máximo</span>
                </div>

                <InputError :message="form.errors.audio_volume" class="mt-3" />
            </section>

            <div class="flex items-center gap-4 pt-1">
                <PrimaryButton
                    :disabled="form.processing"
                    class="rounded-2xl border-0 px-6 py-2 text-sm font-semibold"
                >
                    Guardar preferencias
                </PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful || status === 'emulator-preferences-updated'" class="text-sm text-emerald-400">
                        Preferencias del emulador actualizadas.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
