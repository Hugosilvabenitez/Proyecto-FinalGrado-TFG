<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
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
});
</script>

<template>
    <Head title="Perfil · GameFlux" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold leading-tight bg-gradient-to-r from-cyan-400 via-blue-400 to-fuchsia-500 bg-clip-text text-transparent tracking-tight">
                        Configuración de perfil
                    </h2>
                    <p class="text-xs text-slate-400 mt-1">
                        Gestiona tu identidad y seguridad dentro de GameFlux.
                    </p>
                </div>
            </div>
        </template>

        <div class="py-10 px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-5xl space-y-8">
                <div class="rounded-3xl border border-white/10 bg-slate-900/80 backdrop-blur-2xl shadow-[0_0_35px_rgba(15,23,42,0.9)] p-6 sm:p-8">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                    />
                </div>

                <div class="rounded-3xl border border-white/10 bg-slate-900/80 backdrop-blur-2xl shadow-[0_0_35px_rgba(15,23,42,0.9)] p-6 sm:p-8">
                    <UpdatePasswordForm />
                </div>

                <div class="rounded-3xl border border-red-500/20 bg-slate-950/90 backdrop-blur-2xl shadow-[0_0_40px_rgba(127,29,29,0.6)] p-6 sm:p-8">
                    <DeleteUserForm />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>