<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

interface Role {
  id: number;
  name: string;
}

interface User {
  id: number;
  name: string;
  email: string;
  created_at: string;
  roles: Role[];
  avatar_url: string;
}

interface PaginationLink {
  url: string | null;
  label: string;
  active: boolean;
}

interface Props {
  users: {
    data: User[];
    current_page: number;
    last_page: number;
    next_page_url: string | null;
    prev_page_url: string | null;
    total?: number;
    links?: PaginationLink[];
  };
}

const props = defineProps<Props>();

const deleteUser = (id: number) => {
  if (confirm('¿Seguro que quieres eliminar este usuario?')) {
    router.delete(`/users/${id}`, {
      preserveScroll: true,
    });
  }
};

const formatDate = (value: string) => {
  return new Date(value).toLocaleDateString('es-ES', {
    day: '2-digit',
    month: 'short',
    year: 'numeric',
  });
};

const roleAccent = (roleName: string) => {
  const name = roleName.toLowerCase();

  if (name.includes('admin')) return 'from-fuchsia-500/20 to-fuchsia-500/5 text-fuchsia-300 border-fuchsia-400/20';
  if (name.includes('mod')) return 'from-cyan-500/20 to-cyan-500/5 text-cyan-300 border-cyan-400/20';
  if (name.includes('user')) return 'from-emerald-500/20 to-emerald-500/5 text-emerald-300 border-emerald-400/20';

  return 'from-white/10 to-white/5 text-slate-300 border-white/10';
};

defineOptions({
    layout: AuthenticatedLayout
});
</script>

<template>
  <Head title="Usuarios · GameFlux" />

  
    <div class="min-h-screen bg-slate-950 px-4 py-8 sm:px-6 lg:px-8 text-slate-100">
      <div class="mx-auto max-w-7xl space-y-8">
        <section class="grid gap-4 lg:grid-cols-[1.4fr_0.8fr_0.8fr]">
          <div class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-[radial-gradient(circle_at_top_right,_rgba(56,189,248,0.16),_transparent_40%),linear-gradient(180deg,rgba(15,23,42,.88),rgba(2,6,23,.96))] p-7 shadow-[0_0_40px_rgba(15,23,42,0.8)]">
            <div class="absolute right-0 top-0 h-40 w-40 rounded-full bg-cyan-400/10 blur-3xl"></div>
            <div class="relative space-y-4">
              <div class="inline-flex rounded-full border border-cyan-400/20 bg-cyan-400/10 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.28em] text-cyan-300">
                Users control
              </div>

              <div>
                <h1 class="text-3xl font-black tracking-tight text-white sm:text-4xl">
                  Usuarios del sistema
                </h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-400">
                  Revisa cuentas, roles y accesos desde un panel sencillo y compacto.
                </p>
              </div>

              <div class="flex flex-wrap gap-3 pt-2">
                <Link
                  href="/users/create"
                  class="inline-flex items-center gap-2 rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-950 transition hover:scale-[1.01]">
                  <span class="text-base leading-none">+</span>
                  Nuevo usuario
                </Link>

                <div class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-300">
                  {{ users.total ?? users.data.length }} cuentas
                </div>
              </div>
            </div>
          </div>

          <div class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-6 backdrop-blur-xl">
            <p class="text-xs uppercase tracking-[0.28em] text-slate-400">Página</p>
            <p class="mt-3 text-4xl font-black text-white">{{ users.current_page }}</p>
            <p class="mt-2 text-sm text-slate-500">de {{ users.last_page }}</p>
            <div class="mt-6 h-px bg-white/10"></div>
            <p class="mt-5 text-sm text-slate-400">Navegación paginada del índice.</p>
          </div>

          <div class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-6 backdrop-blur-xl">
            <p class="text-xs uppercase tracking-[0.28em] text-slate-400">Estado</p>
            <p class="mt-3 text-3xl font-black text-cyan-300">Activo</p>
            <p class="mt-2 text-sm text-slate-500">Panel en funcionamiento.</p>
            <div class="mt-6 h-px bg-white/10"></div>
            <p class="mt-5 text-sm text-slate-400">Diseño optimizado para lectura rápida.</p>
          </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
          <div class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-4 sm:p-6 shadow-[0_0_35px_rgba(15,23,42,0.75)] backdrop-blur-2xl">
            <div class="mb-5 flex items-center justify-between gap-4 px-2">
              <div>
                <h3 class="text-lg font-semibold text-white">Listado de usuarios</h3>
                <p class="text-sm text-slate-400">A continuación se pueden observar los distintos usuarios del sistema.</p>
              </div>
            </div>

            <div class="space-y-3">
              <article
                v-for="user in users.data"
                :key="user.id"
                class="group rounded-[1.4rem] border border-white/10 bg-slate-950/70 p-4 transition hover:border-cyan-400/20 hover:bg-slate-950/95">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                  <div class="flex min-w-0 items-center gap-4">
                    <img
                      :src="user.avatar_url"
                      :alt="user.name"
                      class="h-14 w-14 rounded-2xl object-cover shadow-lg"/>

                    <div class="min-w-0">
                      <div class="flex flex-wrap items-center gap-2">
                        <h4 class="truncate text-base font-semibold text-white">
                          {{ user.name }}
                        </h4>
                        <span class="rounded-full border border-white/10 bg-white/5 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">
                          #{{ user.id }}
                        </span>
                      </div>

                      <p class="mt-1 truncate text-sm text-slate-400">
                        {{ user.email }}
                      </p>

                      <div class="mt-3 flex flex-wrap gap-2">
                        <span
                          v-for="role in user.roles"
                          :key="role.id"
                          class="inline-flex items-center rounded-full border bg-gradient-to-r px-3 py-1 text-xs font-semibold backdrop-blur"
                          :class="roleAccent(role.name)">
                          {{ role.name }}
                        </span>

                        <span
                          v-if="user.roles.length === 0"
                          class="inline-flex items-center rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-semibold text-slate-400">
                          Sin rol
                        </span>
                      </div>
                    </div>
                  </div>

                  <div class="flex flex-col items-start gap-3 sm:items-end">
                    <p class="text-xs uppercase tracking-[0.22em] text-slate-500">Creado</p>
                    <p class="text-sm font-medium text-slate-200">
                      {{ formatDate(user.created_at) }}
                    </p>

                    <div class="flex gap-2 pt-1">
                      <Link
                        :href="`/users/${user.id}/edit`"
                        class="rounded-2xl border border-cyan-400/15 bg-cyan-400/10 px-4 py-2 text-xs font-semibold text-cyan-300 transition hover:bg-cyan-400/20">
                        Editar
                      </Link>

                      <button
                        @click="deleteUser(user.id)"
                        class="rounded-2xl border border-rose-400/15 bg-rose-400/10 px-4 py-2 text-xs font-semibold text-rose-300 transition hover:bg-rose-400/20">
                        Eliminar
                      </button>
                    </div>
                  </div>
                </div>
              </article>

              <div
                v-if="!users.data.length"
                class="rounded-[1.4rem] border border-dashed border-white/10 bg-white/[0.03] px-6 py-14 text-center">
                <p class="text-lg font-semibold text-white">No hay usuarios todavía</p>
                <p class="mt-2 text-sm text-slate-500">Cuando existan cuentas, aparecerán aquí.</p>
              </div>
            </div>
          </div>

          <aside class="space-y-6">
            <div class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-6 backdrop-blur-xl">
              <h3 class="text-lg font-semibold text-white">Resumen</h3>
              <div class="mt-5 space-y-4">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                  <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Total usuarios</p>
                  <p class="mt-2 text-2xl font-black text-white">{{ users.total ?? users.data.length }}</p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                  <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Página actual</p>
                  <p class="mt-2 text-2xl font-black text-cyan-300">{{ users.current_page }}</p>
                </div>
              </div>
            </div>

            <div
              v-if="users.links?.length"
              class="rounded-[2rem] border border-white/10 bg-slate-900/70 p-6 backdrop-blur-xl">
              <h3 class="text-lg font-semibold text-white">Paginación</h3>
              <div class="mt-5 flex flex-wrap gap-2">
                <Link
                  v-for="link in users.links"
                  :key="link.label"
                  :href="link.url || ''"
                  v-html="link.label"
                  class="rounded-2xl border px-4 py-2 text-sm transition"
                  :class="[
                    link.active
                      ? 'border-cyan-400/40 bg-cyan-400/15 text-cyan-300'
                      : 'border-white/10 bg-white/5 text-slate-300 hover:border-white/20 hover:bg-white/10',
                    !link.url ? 'pointer-events-none opacity-40' : '',
                  ]"/>
              </div>
            </div>
          </aside>
        </section>
      </div>
    </div>
  
</template>