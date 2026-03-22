<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

/**
* Delete User Form Tpl
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-03-22
* 
* This file contains all the code for generate the delete user template of Gameflux's project.
*/

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-4">
        <header class="space-y-2">
            <h2 class="text-lg font-semibold text-red-400 tracking-tight">
                Eliminar cuenta
            </h2>

            <p class="text-sm text-slate-300">
                Al eliminar tu cuenta se borrarán permanentemente tus partidas, logros y cualquier dato asociado. Esta acción no se puede deshacer.
            </p>
        </header>

        <DangerButton
            class="rounded-2xl bg-gradient-to-r from-rose-500 to-red-500 border-0 px-4 py-2 text-sm font-semibold shadow-[0_0_18px_rgba(248,113,113,0.6)] hover:shadow-[0_0_26px_rgba(248,113,113,0.8)]"
            @click="confirmUserDeletion"
        >
            Eliminar cuenta
        </DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal" max-width="md">
            <div class="bg-slate-950 text-slate-100 rounded-3xl border border-red-500/40 shadow-[0_0_40px_rgba(248,113,113,0.6)] p-6 sm:p-7">
                <h2 class="text-lg font-semibold text-red-400 mb-2">
                    ¿Seguro que quieres borrar tu cuenta?
                </h2>

                <p class="text-sm text-slate-300">
                    Esta acción eliminará todos tus datos en GameFlux. Introduce tu contraseña para confirmar que quieres eliminar tu cuenta de forma permanente.
                </p>

                <div class="mt-6">
                    <InputLabel
                        for="password"
                        value="Contraseña"
                        class="sr-only"
                    />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full rounded-2xl border border-slate-700 bg-slate-900/80 text-slate-100 focus:border-red-400 focus:ring-red-400"
                        placeholder="Introduce tu contraseña"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <SecondaryButton
                        class="rounded-2xl border border-slate-600 bg-slate-800/80 text-slate-200 hover:border-slate-400 hover:bg-slate-700"
                        @click="closeModal"
                    >
                        Cancelar
                    </SecondaryButton>

                    <DangerButton
                        class="rounded-2xl bg-gradient-to-r from-rose-500 to-red-500 border-0 px-4 py-2 text-sm font-semibold shadow-[0_0_18px_rgba(248,113,113,0.6)] hover:shadow-[0_0_26px_rgba(248,113,113,0.8)]"
                        :class="{ 'opacity-40': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Eliminar definitivamente
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>