<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdateEmulatorPreferencesForm from './Partials/UpdateEmulatorPreferencesForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

/**
* Edit View
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-03-22
* 
* This file contains all the code for generate the edit area of Gameflux's project.
*/

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
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
});

defineOptions({
    layout: AuthenticatedLayout
});
</script>

<template>
    <Head title="Perfil · GameFlux" />
        <template>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="gf-title-gradient text-xl font-semibold leading-tight tracking-tight">
                        Configuración de perfil
                    </h2>
                    <p class="gf-text-subtle mt-1 text-xs">
                        Gestiona tu identidad y seguridad dentro de GameFlux.
                    </p>
                </div>
            </div>
        </template>

        <div class="gf-page px-4 py-10 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-5xl space-y-8">
                <div class="gf-panel rounded-3xl p-6 backdrop-blur-2xl sm:p-8">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                    />
                </div>

                <div class="gf-panel rounded-3xl p-6 backdrop-blur-2xl sm:p-8">
                    <UpdatePasswordForm />
                </div>

                <div class="gf-panel rounded-3xl p-6 backdrop-blur-2xl sm:p-8">
                    <UpdateEmulatorPreferencesForm
                        :emulator-preferences="emulatorPreferences"
                        :theme-presets="themePresets"
                        :selected-theme="selectedTheme"
                        :custom-palette="customPalette"
                        :palette-fields="paletteFields"
                        :theme-palette-defaults="themePaletteDefaults"
                        :custom-theme-key="customThemeKey"
                        :status="status"
                    />
                </div>

                <div class="gf-panel-strong rounded-3xl p-6 backdrop-blur-2xl sm:p-8">
                    <DeleteUserForm />
                </div>
            </div>
        </div>
</template>
