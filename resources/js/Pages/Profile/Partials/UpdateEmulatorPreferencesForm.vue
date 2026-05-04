<script setup>
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';

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
    backgroundPresets: {
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
    supportsEmulatorBackground: {
        type: Boolean,
        default: false,
    },
    status: {
        type: String,
        default: '',
    },
});

const form = useForm({
    audio_volume: props.emulatorPreferences.audio_volume ?? 100,
    theme: props.selectedTheme ?? 'nebula',
    emulator_background: props.emulatorPreferences.emulator_background ?? 'nebula',
});

const selectBackground = (backgroundKey) => {
    form.emulator_background = backgroundKey;
};

const selectTheme = (themeKey) => {
    form.theme = themeKey;
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
                Apariencia y emulador
            </h2>

            <p class="text-sm" :style="{ color: 'var(--gf-muted)' }">
                Aquí hay dos ajustes distintos: uno cambia la apariencia general de la app y el otro solo el fondo que ves detrás del juego cuando abres el emulador.
            </p>
        </header>

        <form @submit.prevent="updatePreferences" class="space-y-6">
            <section class="space-y-3">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h3 class="gf-text-accent text-sm font-semibold uppercase tracking-[0.18em]">Paleta de la app</h3>
                        <p class="gf-text-subtle mt-1 text-xs">Cambia navegación, dashboard, blog, chat IA, play y el resto de pantallas autenticadas.</p>
                    </div>
                    <span class="gf-badge-accent rounded-full px-3 py-1 text-xs font-semibold">
                        {{ themePresets[form.theme]?.label || 'Personalizada' }}
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
                                <p class="gf-text-subtle mt-1 text-xs">Aplica la paleta a toda la interfaz autenticada.</p>
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

            <div
                v-if="!supportsEmulatorBackground"
                class="gf-info-warning rounded-2xl px-4 py-3 text-sm"
            >
                El volumen ya puede guardarse. El fondo del emulador quedará disponible en cuanto se aplique la migración pendiente de base de datos.
            </div>

            <section class="space-y-3">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h3 class="gf-text-accent text-sm font-semibold uppercase tracking-[0.18em]">Fondo del emulador</h3>
                        <p class="gf-text-subtle mt-1 text-xs">Solo cambia el lienzo que rodea al juego dentro del emulador. No modifica dashboard, blog ni el resto de la app.</p>
                    </div>
                    <span class="gf-badge-accent rounded-full px-3 py-1 text-xs font-semibold">
                        {{ backgroundPresets[form.emulator_background]?.label || 'Personalizado' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                    <button
                        v-for="(preset, key) in backgroundPresets"
                        :key="key"
                        type="button"
                        class="gf-choice-card overflow-hidden rounded-3xl text-left"
                        :class="form.emulator_background === key
                            ? 'gf-choice-card-active'
                            : ''"
                        :disabled="!supportsEmulatorBackground"
                        @click="selectBackground(key)"
                    >
                        <div class="aspect-[16/9] w-full" :style="{ background: preset.css }"></div>
                        <div class="flex items-center justify-between gap-3 px-4 py-3">
                            <div>
                                <p class="text-sm font-semibold" :style="{ color: 'var(--gf-text)' }">{{ preset.label }}</p>
                                <p class="gf-text-subtle mt-1 text-xs">Se aplicará al entrar en el emulador.</p>
                            </div>
                            <span
                                class="h-3 w-3 rounded-full border border-white/30"
                                :style="{ backgroundColor: preset.accent }"
                            ></span>
                        </div>
                    </button>
                </div>

                <InputError :message="form.errors.emulator_background" />
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
