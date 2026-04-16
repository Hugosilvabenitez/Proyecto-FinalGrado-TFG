<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

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

  if (name.includes('admin')) return 'border-fuchsia-400/20 bg-fuchsia-400/10 text-fuchsia-300';
  if (name.includes('mod')) return 'border-cyan-400/20 bg-cyan-400/10 text-cyan-300';
  if (name.includes('user')) return 'border-emerald-400/20 bg-emerald-400/10 text-emerald-300';

  return 'border-white/10 bg-white/5 text-slate-300';
};
</script>

<template>
  <Head title="Editar usuario · GameFlux" />

  <AuthenticatedLayout>
    <template #header>
      <div class="space-y-2">
        <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Administración</p>
        <h2 class="text-xl font-semibold leading-tight bg-gradient-to-r from-cyan-400 via-blue-400 to-fuchsia-500 bg-clip-text text-transparent tracking-tight">
          Editar usuario
        </h2>
      </div>
    </template>

    <div class="min-h-screen bg-slate-950 px-4 py-8 sm:px-6 lg:px-8 text-slate-100">
      <div class="mx-auto max-w-6xl space-y-8">
        <section class="rounded-[2rem] border border-white/10 bg-[radial-gradient(circle_at_top_right,_rgba(56,189,248,0.15),_transparent_35%),linear-gradient(180deg,rgba(15,23,42,.88),rgba(2,6,23,.96))] p-6 sm:p-8 shadow-[0_0_40px_rgba(15,23,42,0.8)] backdrop-blur-2xl">
          <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
              <Link
                href="/users"
                class="inline-flex items-center gap-2 text-sm text-slate-400 transition hover:text-white"
              >
                ← Volver al listado
              </Link>

              <h1 class="mt-4 text-3xl font-black tracking-tight text-white sm:text-4xl">
                Editar usuario
              </h1>
              <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-400">
                Actualiza datos, contraseña y roles desde el perfil del usuario.
              </p>
            </div>

            <div class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-300">
              ID #{{ user.id }}
            </div>
          </div>
        </section>

        <div class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
          <section class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-5 sm:p-6 shadow-[0_0_35px_rgba(15,23,42,0.75)] backdrop-blur-2xl">
            <form @submit.prevent="submit" class="space-y-6">
              <div class="grid gap-5 md:grid-cols-2">
                <div class="md:col-span-1">
                  <label class="mb-2 block text-sm font-medium text-slate-200">Nombre de usuario</label>
                  <input
                    v-model="form.name"
                    type="text"
                    class="w-full rounded-2xl border border-slate-700 bg-slate-950/80 px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30"/>
                  <p v-if="form.errors.name" class="mt-1 text-xs text-rose-400">
                    {{ form.errors.name }}
                  </p>
                </div>

                <div class="md:col-span-1">
                  <label class="mb-2 block text-sm font-medium text-slate-200">Email</label>
                  <input
                    v-model="form.email"
                    type="email"
                    class="w-full rounded-2xl border border-slate-700 bg-slate-950/80 px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30"/>
                  <p v-if="form.errors.email" class="mt-1 text-xs text-rose-400">
                    {{ form.errors.email }}
                  </p>
                </div>

                <div class="md:col-span-1">
                  <label class="mb-2 block text-sm font-medium text-slate-200">
                    Nueva contraseña
                  </label>
                  <input
                    v-model="form.password"
                    type="password"
                    placeholder="Dejar vacío para no cambiarla"
                    class="w-full rounded-2xl border border-slate-700 bg-slate-950/80 px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-fuchsia-400 focus:ring-2 focus:ring-fuchsia-400/30"/>
                  <p v-if="form.errors.password" class="mt-1 text-xs text-rose-400">
                    {{ form.errors.password }}
                  </p>
                </div>

                <div class="md:col-span-1">
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
                  <label class="block text-sm font-medium text-slate-200">Roles</label>
                  <span class="text-xs uppercase tracking-[0.24em] text-slate-500">multi select</span>
                </div>

                <div class="flex flex-wrap gap-3">
                  <label
                    v-for="role in roles"
                    :key="role.id"
                    class="flex cursor-pointer items-center gap-3 rounded-2xl border px-4 py-3 transition hover:bg-white/5"
                    :class="roleAccent(role.name)">
                    <input
                      type="checkbox"
                      :value="role.id"
                      v-model="form.roles"
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
                  {{ form.processing ? 'Guardando...' : 'Guardar cambios' }}
                </button>
              </div>
            </form>
          </section>

          <aside class="space-y-6">
            <div class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-6 backdrop-blur-xl">
              <h3 class="text-lg font-semibold text-white">Resumen del usuario</h3>
              <div class="mt-5 space-y-4">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                  <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Nombre</p>
                  <p class="mt-2 text-sm font-semibold text-white">{{ user.name }}</p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                  <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Email actual</p>
                  <p class="mt-2 text-sm font-semibold text-white">{{ user.email }}</p>
                </div>
              </div>
            </div>

            <div class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-6 backdrop-blur-xl">
              <h3 class="text-lg font-semibold text-white">Roles asignados</h3>
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
                  class="inline-flex rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-semibold text-slate-400">
                  Sin roles
                </span>
              </div>
            </div>
          </aside>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>