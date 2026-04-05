```vue
<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

/**
* Register View
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-03-17
* 
* This file contains all the code for generate the register area of Gameflux's project.
*/

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Crear cuenta · GameFlux" />

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
                <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl shadow-[0_0_40px_rgba(15,23,42,0.9)] p-8 transition duration-500 ease-out hover:border-cyan-400/60 hover:shadow-[0_0_60px_rgba(56,189,248,0.8)] hover:-translate-y-1 text-center">
                    <h1 class="text-2xl font-semibold tracking-tight mb-2">Crea tu perfil de jugador</h1>
                    <p class="text-sm text-slate-300 mb-6">Regístrate en GameFlux para guardar tus partidas y coleccionar tus títulos favoritos de Game Boy Advance.</p>
                    <form @submit.prevent="submit" class="space-y-5">
                        <div>
                            <InputLabel for="name" value="Nombre de jugador" class="text-xs font-medium uppercase tracking-wide text-slate-300"/>
                            <TextInput id="name" type="text" class="mt-1 block w-full rounded-2xl bg-slate-900/60 border-slate-700/70 text-sm placeholder-slate-500 focus:border-cyan-400 focus:ring-cyan-400 text-center" v-model="form.name" required autofocus autocomplete="name" placeholder="Ash Ketchum"/>
                            <InputError class="mt-2 text-xs" :message="form.errors.name"/>
                        </div>
                        <div>
                            <InputLabel for="email" value="Email" class="text-xs font-medium uppercase tracking-wide text-slate-300"/>
                            <TextInput id="email" type="email" class="mt-1 block w-full rounded-2xl bg-slate-900/60 border-slate-700/70 text-sm placeholder-slate-500 focus:border-cyan-400 focus:ring-cyan-400 text-center" v-model="form.email" required autocomplete="username" placeholder="trainer@gameflux.gg"/>
                            <InputError class="mt-2 text-xs" :message="form.errors.email"/>
                        </div>
                        <div>
                            <InputLabel for="password" value="Contraseña" class="text-xs font-medium uppercase tracking-wide text-slate-300"/>
                            <TextInput id="password" type="password" class="mt-1 block w-full rounded-2xl bg-slate-900/60 border-slate-700/70 text-sm placeholder-slate-500 focus:border-fuchsia-400 focus:ring-fuchsia-400 text-center" v-model="form.password" required autocomplete="new-password" placeholder="••••••••"/>
                            <InputError class="mt-2 text-xs" :message="form.errors.password"/>
                        </div>
                        <div>
                            <InputLabel for="password_confirmation" value="Confirmar contraseña" class="text-xs font-medium uppercase tracking-wide text-slate-300"/>
                            <TextInput id="password_confirmation" type="password" class="mt-1 block w-full rounded-2xl bg-slate-900/60 border-slate-700/70 text-sm placeholder-slate-500 focus:border-fuchsia-400 focus:ring-fuchsia-400 text-center" v-model="form.password_confirmation" required autocomplete="new-password" placeholder="Repite tu contraseña"/>
                            <InputError class="mt-2 text-xs" :message="form.errors.password_confirmation"/>
                        </div>
                        <div class="mt-4 flex items-center justify-end">
                            <PrimaryButton class="w-full justify-center rounded-full bg-gradient-to-r from-cyan-400 via-blue-500 to-fuchsia-500 text-xs font-semibold tracking-wide uppercase shadow-[0_0_25px_rgba(56,189,248,0.9)] hover:shadow-[0_0_40px_rgba(244,114,182,0.9)] hover:scale-[1.02] transition disabled:opacity-60 disabled:cursor-not-allowed" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                <span v-if="!form.processing">Crear cuenta</span>
                                <span v-else>Guardando datos…</span>
                            </PrimaryButton>
                        </div>
                    </form>
                    <p class="mt-6 text-[11px] text-center text-slate-400">GameFlux guarda tus estados de partida en la nube para que tu GBA virtual nunca se quede sin batería.</p>
                </div>
                <p class="mt-4 text-center text-sm text-slate-300">
                    ¿Ya tienes una cuenta?
                    <Link :href="route('login')" class="text-cyan-300 hover:text-cyan-100 font-medium">Entrar al portal</Link>
                </p>
            </div>
        </div>
    </GuestLayout>
</template>