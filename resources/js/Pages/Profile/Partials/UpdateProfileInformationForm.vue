<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

/**
* Update Profile Information Form Tpl
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-03-22
* 
* This file contains all the code for generate the update profile information template of Gameflux's project.
*/

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <section class="space-y-4">
        <header class="space-y-1">
            <h2 class="text-lg font-semibold text-slate-100 tracking-tight">
                Información del perfil
            </h2>

            <p class="text-sm text-slate-300">
                Actualiza tu nombre de entrenador y el correo asociado a tu cuenta GameFlux.
            </p>
        </header>

        <form
            @submit.prevent="form.patch(route('profile.update'))"
            class="mt-4 space-y-5"
        >
            <div>
                <InputLabel for="name" value="Nombre" class="text-slate-200" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full rounded-2xl border border-slate-700 bg-slate-900/80 text-slate-100 focus:border-cyan-400 focus:ring-cyan-400"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Correo electrónico" class="text-slate-200" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full rounded-2xl border border-slate-700 bg-slate-900/80 text-slate-100 focus:border-fuchsia-400 focus:ring-fuchsia-400"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null" class="pt-1">
                <p class="mt-2 text-sm text-amber-300">
                    Tu correo todavía no ha sido verificado.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="ml-1 rounded-md text-sm text-cyan-300 underline hover:text-cyan-200 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 focus:ring-offset-slate-900"
                    >
                        Reenviar correo de verificación.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-emerald-400"
                >
                    Se ha enviado un nuevo enlace de verificación a tu correo.
                </div>
            </div>

            <div class="flex items-center gap-4 pt-2">
                <PrimaryButton
                    :disabled="form.processing"
                    class="rounded-2xl bg-gradient-to-r from-cyan-400 via-blue-500 to-fuchsia-500 border-0 px-6 py-2 text-sm font-semibold shadow-[0_0_20px_rgba(56,189,248,0.7)] hover:shadow-[0_0_28px_rgba(244,114,182,0.8)]"
                >
                    Guardar cambios
                </PrimaryButton>

            </div>
        </form>
    </section>
</template>