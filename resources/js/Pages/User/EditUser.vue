<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

/**
 * USER'S EDIT AREA 
 * 
 * THESE AREA CONTAINS THE USER'S EDITION FUNCTIONALITY
*/

interface Role {
  id: number;
  name: string;
}

interface User {
  id: number;
  name: string;
  email: string;
  roles: Role[];
}

interface Props {
  user: User;
  roles: Role[];
}

const props = defineProps<Props>();

const form = useForm({
  name: props.user.name,
  email: props.user.email,
  password: '',
  password_confirmation: '',
  roles: props.user.roles.map((r) => r.id),
});

const submit = () => {
  form.put(`/users/${props.user.id}`, {
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
  <Head title="Editar usuario · GameFlux" />
    <div class="gf-page min-h-screen px-4 py-8 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-6xl space-y-8">
        <section class="gf-panel-hero rounded-[2rem] p-6 sm:p-8 backdrop-blur-2xl">
          <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
              <Link
                href="/users"
                class="gf-text-muted inline-flex items-center gap-2 text-sm transition hover:text-[var(--gf-accent)]"
              >
                ← Volver al listado
              </Link>

              <h1 class="mt-4 text-3xl font-black tracking-tight sm:text-4xl">
                Editar usuario
              </h1>
              <p class="gf-text-muted mt-3 max-w-2xl text-sm leading-6">
                Actualiza datos, contraseña y roles desde el perfil del usuario.
              </p>
            </div>

            <div class="gf-chip inline-flex items-center rounded-2xl px-4 py-3 text-sm">
              ID #{{ user.id }}
            </div>
          </div>
        </section>

        <div class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
          <section class="gf-panel rounded-[2rem] p-5 sm:p-6 backdrop-blur-2xl">
            <form @submit.prevent="submit" class="space-y-6">
              <div class="grid gap-5 md:grid-cols-2">
                <div class="md:col-span-1">
                  <label class="mb-2 block text-sm font-medium">Nombre de usuario</label>
                  <input
                    v-model="form.name"
                    type="text"
                    class="gf-input w-full rounded-2xl px-4 py-3 transition"/>
                  <p v-if="form.errors.name" class="mt-1 text-xs" :style="{ color: 'var(--gf-danger-text)' }">
                    {{ form.errors.name }}
                  </p>
                </div>

                <div class="md:col-span-1">
                  <label class="mb-2 block text-sm font-medium">Email</label>
                  <input
                    v-model="form.email"
                    type="email"
                    class="gf-input w-full rounded-2xl px-4 py-3 transition"/>
                  <p v-if="form.errors.email" class="mt-1 text-xs" :style="{ color: 'var(--gf-danger-text)' }">
                    {{ form.errors.email }}
                  </p>
                </div>

                <div class="md:col-span-1">
                  <label class="mb-2 block text-sm font-medium">
                    Nueva contraseña
                  </label>
                  <input
                    v-model="form.password"
                    type="password"
                    placeholder="Dejar vacío para no cambiarla"
                    class="gf-input gf-input-secondary w-full rounded-2xl px-4 py-3 transition"/>
                  <p v-if="form.errors.password" class="mt-1 text-xs" :style="{ color: 'var(--gf-danger-text)' }">
                    {{ form.errors.password }}
                  </p>
                </div>

                <div class="md:col-span-1">
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
                  <label class="block text-sm font-medium">Roles</label>
                  <span class="gf-text-subtle text-xs uppercase tracking-[0.24em]">multi select</span>
                </div>

                <div class="flex flex-wrap gap-3">
                  <label
                    v-for="role in roles"
                    :key="role.id"
                    class="flex cursor-pointer items-center gap-3 rounded-2xl border px-4 py-3 transition"
                    :class="roleAccent(role.name)">
                    <input
                      type="checkbox"
                      :value="role.id"
                      v-model="form.roles"
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
                  {{ form.processing ? 'Guardando...' : 'Guardar cambios' }}
                </button>
              </div>
            </form>
          </section>

          <aside class="space-y-6">
            <div class="gf-panel rounded-[2rem] p-6 backdrop-blur-xl">
              <h3 class="text-lg font-semibold">Resumen del usuario</h3>
              <div class="mt-5 space-y-4">
                <div class="gf-panel-soft rounded-2xl p-4">
                  <p class="gf-text-subtle text-xs uppercase tracking-[0.24em]">Nombre</p>
                  <p class="mt-2 text-sm font-semibold">{{ user.name }}</p>
                </div>

                <div class="gf-panel-soft rounded-2xl p-4">
                  <p class="gf-text-subtle text-xs uppercase tracking-[0.24em]">Email actual</p>
                  <p class="mt-2 text-sm font-semibold">{{ user.email }}</p>
                </div>
              </div>
            </div>

            <div class="gf-panel rounded-[2rem] p-6 backdrop-blur-xl">
              <h3 class="text-lg font-semibold">Roles asignados</h3>
              <div class="mt-5 flex flex-wrap gap-2">
                <span
                  v-for="role in user.roles"
                  :key="role.id"
                  class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold"
                  :class="roleAccent(role.name)">
                  {{ role.name }}
                </span>

                <span
                  v-if="user.roles.length === 0"
                  class="gf-chip inline-flex rounded-full px-3 py-1 text-xs font-semibold">
                  Sin roles
                </span>
              </div>
            </div>
          </aside>
        </div>
      </div>
    </div>
  
</template>
