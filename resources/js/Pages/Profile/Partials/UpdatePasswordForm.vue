<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

/**
* Update Password Form Tpl
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-03-22
* 
* This file contains all the code for generate the update password template of Gameflux's project.
*/

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section class="space-y-4">
        <header class="space-y-1">
            <h2 class="text-lg font-semibold text-slate-100 tracking-tight">
                Actualizar contraseña
            </h2>

            <p class="text-sm text-slate-300">
                Usa una contraseña larga y única para mantener tu perfil de GameFlux seguro.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-4 space-y-5">
            <div>
                <InputLabel for="current_password" value="Contraseña actual" class="text-slate-200" />

                <TextInput
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    class="mt-1 block w-full rounded-2xl border border-slate-700 bg-slate-900/80 text-slate-100 focus:border-cyan-400 focus:ring-cyan-400"
                    autocomplete="current-password"
                />

                <InputError :message="form.errors.current_password" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <InputLabel for="password" value="Nueva contraseña" class="text-slate-200" />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full rounded-2xl border border-slate-700 bg-slate-900/80 text-slate-100 focus:border-fuchsia-400 focus:ring-fuchsia-400"
                        autocomplete="new-password"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="password_confirmation" value="Repite contraseña" class="text-slate-200" />

                    <TextInput
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        class="mt-1 block w-full rounded-2xl border border-slate-700 bg-slate-900/80 text-slate-100 focus:border-fuchsia-400 focus:ring-fuchsia-400"
                        autocomplete="new-password"
                    />

                    <InputError :message="form.errors.password_confirmation" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center gap-4 pt-2">
                <PrimaryButton
                    :disabled="form.processing"
                    class="rounded-2xl bg-gradient-to-r from-cyan-400 via-blue-500 to-fuchsia-500 border-0 px-6 py-2 text-sm font-semibold shadow-[0_0_20px_rgba(56,189,248,0.7)] hover:shadow-[0_0_28px_rgba(244,114,182,0.8)]"
                >
                    Guardar cambios
                </PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-emerald-400">
                        Contraseña actualizada.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>