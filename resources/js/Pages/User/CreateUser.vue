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

    if (name.includes('admin')) return 'gf-chip-secondary';
    if (name.includes('mod')) return 'gf-chip-accent';
    if (name.includes('user')) return 'gf-chip';

    return 'gf-chip';
};

defineOptions({
    layout: AuthenticatedLayout
});
</script>

<template>
    <Head title="Nuevo usuario · GameFlux" />
        <div class="gf-page min-h-screen px-4 py-8 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl space-y-8">
                <section class="grid gap-4 lg:grid-cols-[1.35fr_0.85fr_0.85fr]">
                    <div class="gf-panel-hero relative overflow-hidden rounded-[2rem] p-7">
                        <div class="gf-page-orb-secondary absolute right-0 top-0 h-44 w-44 rounded-full"></div>

                        <div class="relative space-y-4">
                            <div class="gf-chip gf-chip-accent inline-flex rounded-full px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.28em]">
                                New account
                            </div>

                            <div>
                                <h1 class="text-3xl font-black tracking-tight sm:text-4xl">
                                    Nuevo usuario
                                </h1>
                                <p class="gf-text-muted mt-3 max-w-2xl text-sm leading-6">
                                    Crea una cuenta con roles, acceso y credenciales desde una interfaz limpia y liviana.
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-3 pt-2">
                                <Link
                                    href="/users"
                                    class="gf-button-secondary inline-flex items-center gap-2 rounded-2xl px-5 py-3 text-sm font-semibold transition hover:scale-[1.01]">
                                    ← Volver
                                </Link>

                                <div class="gf-chip inline-flex items-center rounded-2xl px-4 py-3 text-sm">
                                    {{ roles.length }} roles disponibles
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="gf-panel rounded-[2rem] p-6 backdrop-blur-xl">
                        <p class="gf-text-subtle text-xs uppercase tracking-[0.28em]">Estado</p>
                        <p class="gf-text-accent mt-3 text-3xl font-black">Borrador</p>
                        <p class="gf-text-subtle mt-2 text-sm">Formulario listo para crear.</p>
                        <div class="gf-divider mt-6 h-px"></div>
                        <p class="gf-text-muted mt-5 text-sm">La cuenta se enviará al guardar.</p>
                    </div>

                    <div class="gf-panel rounded-[2rem] p-6 backdrop-blur-xl">
                        <p class="gf-text-subtle text-xs uppercase tracking-[0.28em]">Roles</p>
                        <p class="mt-3 text-3xl font-black">{{ roles.length }}</p>
                        <p class="gf-text-subtle mt-2 text-sm">Opciones asignables</p>
                        <div class="gf-divider mt-6 h-px"></div>
                        <p class="gf-text-muted mt-5 text-sm">Selecciona uno o varios perfiles.</p>
                    </div>
                </section>

                <section class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
                    <div class="gf-panel rounded-[2rem] p-5 backdrop-blur-2xl sm:p-6">
                        <form class="space-y-6" @submit.prevent="submit">
                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label class="mb-2 block text-sm font-medium">
                                        Nombre de usuario
                                    </label>
                                    <input
                                        v-model="form.username"
                                        type="text"
                                        placeholder="ej: jugador123"
                                        class="gf-input w-full rounded-2xl px-4 py-3 transition"
                                    />
                                    <p v-if="form.errors.username" class="mt-1 text-xs" :style="{ color: 'var(--gf-danger-text)' }">
                                        {{ form.errors.username }}
                                    </p>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium">
                                        Email
                                    </label>
                                    <input
                                        v-model="form.email"
                                        type="email"
                                        placeholder="ej: jugador@gameflux.com"
                                        class="gf-input w-full rounded-2xl px-4 py-3 transition"/>
                                    <p v-if="form.errors.email" class="mt-1 text-xs" :style="{ color: 'var(--gf-danger-text)' }">
                                        {{ form.errors.email }}
                                    </p>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium">
                                        Contraseña
                                    </label>
                                    <input
                                        v-model="form.password"
                                        type="password"
                                        placeholder="Mínimo 8 caracteres"
                                        class="gf-input gf-input-secondary w-full rounded-2xl px-4 py-3 transition"/>
                                    <p v-if="form.errors.password" class="mt-1 text-xs" :style="{ color: 'var(--gf-danger-text)' }">
                                        {{ form.errors.password }}
                                    </p>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium">
                                        Confirmar contraseña
                                    </label>
                                    <input
                                        v-model="form.password_confirmation"
                                        type="password"
                                        placeholder="Repite la contraseña"
                                        class="gf-input gf-input-secondary w-full rounded-2xl px-4 py-3 transition"/>
                                </div>
                            </div>

                            <div>
                                <div class="mb-3 flex items-center justify-between gap-3">
                                    <label class="block text-sm font-medium">
                                        Roles
                                    </label>
                                    <span class="gf-text-subtle text-xs uppercase tracking-[0.24em]">
                                        multi select
                                    </span>
                                </div>

                                <div class="flex flex-wrap gap-3">
                                    <label
                                        v-for="role in roles"
                                        :key="role.id"
                                        class="flex cursor-pointer items-center gap-3 rounded-2xl border px-4 py-3 transition"
                                        :class="roleAccent(role.name)">
                                        <input
                                            v-model="form.roles"
                                            type="checkbox"
                                            :value="role.id"
                                            class="h-4 w-4"
                                            :style="{ accentColor: 'var(--gf-accent)' }"/>
                                        <span class="text-sm font-medium">
                                            {{ role.name }}
                                        </span>
                                    </label>
                                </div>

                                <p v-if="form.errors.roles" class="mt-1 text-xs" :style="{ color: 'var(--gf-danger-text)' }">
                                    {{ form.errors.roles }}
                                </p>
                            </div>

                            <div class="flex flex-col gap-3 border-t pt-6 sm:flex-row sm:justify-end" :style="{ borderColor: 'var(--gf-line)' }">
                                <Link
                                    href="/users"
                                    class="gf-button-secondary inline-flex items-center justify-center rounded-2xl px-5 py-3 text-sm font-semibold transition">
                                    Cancelar
                                </Link>

                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="gf-button-primary inline-flex items-center justify-center rounded-2xl px-5 py-3 text-sm font-semibold transition disabled:cursor-not-allowed disabled:opacity-50">
                                    {{ form.processing ? 'Guardando...' : 'Crear usuario' }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <aside class="space-y-6">
                        <div class="gf-panel rounded-[2rem] p-6 backdrop-blur-xl">
                            <h3 class="text-lg font-semibold">Checklist</h3>
                            <div class="gf-text-muted mt-5 space-y-3 text-sm">
                                <p>• Completa usuario y email.</p>
                                <p>• Define contraseña segura.</p>
                                <p>• Asigna roles según permisos.</p>
                            </div>
                        </div>

                        <div class="gf-panel rounded-[2rem] p-6 backdrop-blur-xl">
                            <h3 class="text-lg font-semibold">Vista previa</h3>
                            <div class="gf-panel-strong mt-5 rounded-3xl p-5">
                                <p class="gf-text-subtle text-xs uppercase tracking-[0.24em]">
                                    Username
                                </p>
                                <p class="mt-2 text-lg font-bold">
                                    {{ form.username || 'jugador123' }}
                                </p>

                                <p class="gf-text-subtle mt-4 text-xs uppercase tracking-[0.24em]">
                                    Email
                                </p>
                                <p class="gf-text-muted mt-2 text-sm">
                                    {{ form.email || 'jugador@gameflux.com' }}
                                </p>
                            </div>
                        </div>
                    </aside>
                </section>
            </div>
        </div>
    
</template>
