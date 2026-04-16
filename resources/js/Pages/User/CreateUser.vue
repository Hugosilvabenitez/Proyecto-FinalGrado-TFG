<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

interface Role {
    id: number;
    name: string;
}

interface Props {
    roles: Role[];
}

const props = defineProps<Props>();

const form = useForm({
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
    roles: [] as number[],
});

const submit = () => {
    form.post('/users', {
        preserveScroll: true,
    });
};

const roleAccent = (roleName: string) => {
    const name = roleName.toLowerCase();

    if (name.includes('admin')) return 'border-fuchsia-400/20 bg-fuchsia-400/10 text-fuchsia-300';
    if (name.includes('mod')) return 'border-cyan-400/20 bg-cyan-400/10 text-cyan-300';
    if (name.includes('user')) return 'border-emerald-400/20 bg-emerald-400/10 text-emerald-300';

    return 'border-white/10 bg-white/5 text-slate-300';
};
</script>

<template>
    <Head title="Nuevo usuario · GameFlux" />

    <AuthenticatedLayout>
        <template #header>
            <div class="space-y-2">
                <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Administración</p>
                <h2 class="text-xl font-semibold leading-tight bg-gradient-to-r from-cyan-400 via-blue-400 to-fuchsia-500 bg-clip-text text-transparent tracking-tight">
                    Crear usuario
                </h2>
            </div>
        </template>

        <div class="min-h-screen bg-slate-950 px-4 py-8 text-slate-100 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl space-y-8">
                <section class="grid gap-4 lg:grid-cols-[1.35fr_0.85fr_0.85fr]">
                    <div class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-[radial-gradient(circle_at_top_right,_rgba(56,189,248,0.16),_transparent_40%),linear-gradient(180deg,rgba(15,23,42,.88),rgba(2,6,23,.96))] p-7 shadow-[0_0_40px_rgba(15,23,42,0.8)]">
                        <div class="absolute right-0 top-0 h-44 w-44 rounded-full bg-fuchsia-400/10 blur-3xl"></div>

                        <div class="relative space-y-4">
                            <div class="inline-flex rounded-full border border-cyan-400/20 bg-cyan-400/10 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.28em] text-cyan-300">
                                New account
                            </div>

                            <div>
                                <h1 class="text-3xl font-black tracking-tight text-white sm:text-4xl">
                                    Nuevo usuario
                                </h1>
                                <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-400">
                                    Crea una cuenta con roles, acceso y credenciales desde una interfaz limpia y liviana.
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-3 pt-2">
                                <Link
                                    href="/users"
                                    class="inline-flex items-center gap-2 rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-950 transition hover:scale-[1.01]">
                                    ← Volver
                                </Link>

                                <div class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-300">
                                    {{ roles.length }} roles disponibles
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-6 backdrop-blur-xl">
                        <p class="text-xs uppercase tracking-[0.28em] text-slate-400">Estado</p>
                        <p class="mt-3 text-3xl font-black text-cyan-300">Borrador</p>
                        <p class="mt-2 text-sm text-slate-500">Formulario listo para crear.</p>
                        <div class="mt-6 h-px bg-white/10"></div>
                        <p class="mt-5 text-sm text-slate-400">La cuenta se enviará al guardar.</p>
                    </div>

                    <div class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-6 backdrop-blur-xl">
                        <p class="text-xs uppercase tracking-[0.28em] text-slate-400">Roles</p>
                        <p class="mt-3 text-3xl font-black text-white">{{ roles.length }}</p>
                        <p class="mt-2 text-sm text-slate-500">Opciones asignables</p>
                        <div class="mt-6 h-px bg-white/10"></div>
                        <p class="mt-5 text-sm text-slate-400">Selecciona uno o varios perfiles.</p>
                    </div>
                </section>

                <section class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
                    <div class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-5 shadow-[0_0_35px_rgba(15,23,42,0.75)] backdrop-blur-2xl sm:p-6">
                        <form class="space-y-6" @submit.prevent="submit">
                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-200">
                                        Nombre de usuario
                                    </label>
                                    <input
                                        v-model="form.username"
                                        type="text"
                                        placeholder="ej: jugador123"
                                        class="w-full rounded-2xl border border-slate-700 bg-slate-950/80 px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30"
                                    />
                                    <p v-if="form.errors.username" class="mt-1 text-xs text-rose-400">
                                        {{ form.errors.username }}
                                    </p>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-200">
                                        Email
                                    </label>
                                    <input
                                        v-model="form.email"
                                        type="email"
                                        placeholder="ej: jugador@gameflux.com"
                                        class="w-full rounded-2xl border border-slate-700 bg-slate-950/80 px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30"/>
                                    <p v-if="form.errors.email" class="mt-1 text-xs text-rose-400">
                                        {{ form.errors.email }}
                                    </p>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-200">
                                        Contraseña
                                    </label>
                                    <input
                                        v-model="form.password"
                                        type="password"
                                        placeholder="Mínimo 8 caracteres"
                                        class="w-full rounded-2xl border border-slate-700 bg-slate-950/80 px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-fuchsia-400 focus:ring-2 focus:ring-fuchsia-400/30"/>
                                    <p v-if="form.errors.password" class="mt-1 text-xs text-rose-400">
                                        {{ form.errors.password }}
                                    </p>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-200">
                                        Confirmar contraseña
                                    </label>
                                    <input
                                        v-model="form.password_confirmation"
                                        type="password"
                                        placeholder="Repite la contraseña"
                                        class="w-full rounded-2xl border border-slate-700 bg-slate-950/80 px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-fuchsia-400 focus:ring-2 focus:ring-fuchsia-400/30"/>
                                </div>
                            </div>

                            <div>
                                <div class="mb-3 flex items-center justify-between gap-3">
                                    <label class="block text-sm font-medium text-slate-200">
                                        Roles
                                    </label>
                                    <span class="text-xs uppercase tracking-[0.24em] text-slate-500">
                                        multi select
                                    </span>
                                </div>

                                <div class="flex flex-wrap gap-3">
                                    <label
                                        v-for="role in roles"
                                        :key="role.id"
                                        class="flex cursor-pointer items-center gap-3 rounded-2xl border px-4 py-3 transition hover:bg-white/5"
                                        :class="roleAccent(role.name)">
                                        <input
                                            v-model="form.roles"
                                            type="checkbox"
                                            :value="role.id"
                                            class="h-4 w-4 accent-cyan-400"/>
                                        <span class="text-sm font-medium">
                                            {{ role.name }}
                                        </span>
                                    </label>
                                </div>

                                <p v-if="form.errors.roles" class="mt-1 text-xs text-rose-400">
                                    {{ form.errors.roles }}
                                </p>
                            </div>

                            <div class="flex flex-col gap-3 border-t border-white/10 pt-6 sm:flex-row sm:justify-end">
                                <Link
                                    href="/users"
                                    class="inline-flex items-center justify-center rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-slate-300 transition hover:bg-white/10 hover:text-white">
                                    Cancelar
                                </Link>

                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-cyan-400 via-blue-500 to-fuchsia-500 px-5 py-3 text-sm font-semibold text-white shadow-[0_0_22px_rgba(56,189,248,0.7)] transition hover:shadow-[0_0_30px_rgba(244,114,182,0.8)] disabled:cursor-not-allowed disabled:opacity-50">
                                    {{ form.processing ? 'Guardando...' : 'Crear usuario' }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <aside class="space-y-6">
                        <div class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-6 backdrop-blur-xl">
                            <h3 class="text-lg font-semibold text-white">Checklist</h3>
                            <div class="mt-5 space-y-3 text-sm text-slate-400">
                                <p>• Completa usuario y email.</p>
                                <p>• Define contraseña segura.</p>
                                <p>• Asigna roles según permisos.</p>
                            </div>
                        </div>

                        <div class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-6 backdrop-blur-xl">
                            <h3 class="text-lg font-semibold text-white">Vista previa</h3>
                            <div class="mt-5 rounded-3xl border border-white/10 bg-slate-950/70 p-5">
                                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">
                                    Username
                                </p>
                                <p class="mt-2 text-lg font-bold text-white">
                                    {{ form.username || 'jugador123' }}
                                </p>

                                <p class="mt-4 text-xs uppercase tracking-[0.24em] text-slate-500">
                                    Email
                                </p>
                                <p class="mt-2 text-sm text-slate-300">
                                    {{ form.email || 'jugador@gameflux.com' }}
                                </p>
                            </div>
                        </div>
                    </aside>
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>