<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

/**
* Login View
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-03-16
* 
* This file contains all the code for generate the login area of Gameflux's project.
*/

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Iniciar sesión · GameFlux" />

        <div class="min-h-screen flex items-center justify-center px-4 relative overflow-hidden bg-slate-950 text-slate-100">
            <div class="pointer-events-none absolute inset-0">
                <div class="absolute -top-32 -left-24 h-72 w-72 bg-gradient-to-br from-cyan-500 via-blue-500 to-purple-600 opacity-40 blur-3xl"/>
                <div class="absolute -bottom-40 -right-20 h-80 w-80 bg-gradient-to-tr from-fuchsia-500 via-orange-400 to-yellow-300 opacity-40 blur-3xl"/>
            </div>
            <div class="pointer-events-none absolute inset-0 opacity-30 mix-blend-soft-light" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2240%22 height=%2240%22 viewBox=%220 0 40 40%22><rect width=%221%22 height=%221%22 fill=%22%23ffffff%22 opacity=%220.12%22/></svg>');"></div>
            <div class="relative z-10 w-full max-w-md">
                <div class="flex flex-col items-center mb-8">
                    <img src="/images/logo.jpg" alt="GameFlux" class="h-14 sm:h-16 md:h-28 lg:h-32 drop-shadow-[0_0_25px_rgba(59,130,246,0.75)]"/>
                    <p class="mt-3 text-sm tracking-[0.25em] uppercase text-slate-300 text-center">Web Game Boy Advance Emulator</p>
                </div>
                <div v-if="status" class="mb-4 text-sm font-medium text-emerald-400 text-center">{{ status }}</div>
                <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl shadow-[0_0_40px_rgba(15,23,42,0.9)] p-8 transition duration-500 ease-out hover:border-cyan-400/60 hover:shadow-[0_0_60px_rgba(56,189,248,0.8)] hover:-translate-y-1 text-center">
                    <h1 class="text-2xl font-semibold tracking-tight mb-2">Bienvenido de nuevo, Trainer</h1>
                    <p class="text-sm text-slate-300 mb-6">Inicia sesión para continuar tus partidas de Game Boy Advance en la nube.</p>
                    <form @submit.prevent="submit" class="space-y-5">
                        <div>
                            <InputLabel for="email" value="Email" class="text-xs font-medium uppercase tracking-wide text-slate-300"/>
                            <TextInput id="email" type="email" class="mt-1 block w-full rounded-2xl bg-slate-900/60 border-slate-700/70 text-sm placeholder-slate-500 focus:border-cyan-400 focus:ring-cyan-400 text-center" v-model="form.email" required autofocus autocomplete="username" placeholder="ash@gameflux.gg"/>
                            <InputError class="mt-2 text-xs" :message="form.errors.email"/>
                        </div>
                        <div>
                            <InputLabel for="password" value="Contraseña" class="text-xs font-medium uppercase tracking-wide text-slate-300"/>
                            <TextInput id="password" type="password" class="mt-1 block w-full rounded-2xl bg-slate-900/60 border-slate-700/70 text-sm placeholder-slate-500 focus:border-fuchsia-400 focus:ring-fuchsia-400 text-center" v-model="form.password" required autocomplete="current-password" placeholder="••••••••"/>
                            <InputError class="mt-2 text-xs" :message="form.errors.password"/>
                        </div>
                        <div class="mt-2 flex items-center justify-between text-xs text-slate-300">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <Checkbox name="remember" v-model:checked="form.remember"/>
                                <span>Recordarme en este dispositivo</span>
                            </label>
                            <Link v-if="canResetPassword" :href="route('password.request')" class="text-cyan-300 hover:text-cyan-200 hover:underline underline-offset-4">¿Olvidaste tu contraseña?</Link>
                        </div>
                        <div class="mt-4 flex items-center justify-end">
                            <PrimaryButton class="ms-4 w-full justify-center rounded-full bg-gradient-to-r from-cyan-400 via-blue-500 to-fuchsia-500 text-xs font-semibold tracking-wide uppercase shadow-[0_0_25px_rgba(56,189,248,0.9)] hover:shadow-[0_0_40px_rgba(244,114,182,0.9)] hover:scale-[1.02] transition disabled:opacity-60 disabled:cursor-not-allowed" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                <span v-if="!form.processing">Entrar al portal</span>
                                <span v-else>Cargando partida…</span>
                            </PrimaryButton>
                        </div>
                    </form>
                    <p class="mt-6 text-[11px] text-center text-slate-400">GameFlux guarda tus estados de partida en la nube para que tu GBA virtual nunca se quede sin batería.</p>
                </div>
                <p class="mt-4 text-center text-sm text-slate-300">
                    ¿Aún no tienes cuenta?
                    <Link :href="route('register')" class="text-cyan-300 hover:text-cyan-100 font-medium">Crear perfil de jugador</Link>
                </p>
            </div>
        </div>
    </GuestLayout>
</template>