<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

/**
 * USER'S CRUD AREA
 * 
 * THESE AREA CONTAINS ALL THE USERS CRUD
*/

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
  <Head title="Usuarios · GameFlux" />

  
    <div class="gf-page min-h-screen px-4 py-8 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-7xl space-y-8">
        <section class="grid gap-4 lg:grid-cols-[1.4fr_0.8fr_0.8fr]">
          <div class="gf-panel-hero relative overflow-hidden rounded-[2rem] p-7">
            <div class="gf-page-orb-primary absolute right-0 top-0 h-40 w-40 rounded-full"></div>
            <div class="relative space-y-4">
              <div class="gf-chip-accent inline-flex rounded-full px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.28em]">
                Control de usuarios
              </div>

              <div>
                <h1 class="text-3xl font-black tracking-tight sm:text-4xl">
                  Usuarios del sistema
                </h1>
                <p class="gf-text-muted mt-3 max-w-2xl text-sm leading-6">
                  Revisa cuentas, roles y accesos desde un panel sencillo y compacto.
                </p>
              </div>

              <div class="flex flex-wrap gap-3 pt-2">
                <Link
                  href="/users/create"
                  class="gf-button-primary inline-flex items-center gap-2 rounded-2xl px-5 py-3 text-sm font-semibold transition hover:scale-[1.01]">
                  <span class="text-base leading-none">+</span>
                  Nuevo usuario
                </Link>

                <div class="gf-chip inline-flex items-center rounded-2xl px-4 py-3 text-sm">
                  {{ users.total ?? users.data.length }} cuentas
                </div>
              </div>
            </div>
          </div>

          <div class="gf-panel-soft rounded-[2rem] p-6 backdrop-blur-xl">
            <p class="gf-text-subtle text-xs uppercase tracking-[0.28em]">Página</p>
            <p class="mt-3 text-4xl font-black">{{ users.current_page }}</p>
            <p class="gf-text-subtle mt-2 text-sm">de {{ users.last_page }}</p>
          </div>

          <div class="gf-panel-soft rounded-[2rem] p-6 backdrop-blur-xl">
            <p class="gf-text-subtle text-xs uppercase tracking-[0.28em]">Estado</p>
            <p class="gf-text-accent mt-3 text-3xl font-black">Activo</p>
            <p class="gf-text-subtle mt-2 text-sm">Panel en funcionamiento.</p>
          </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
          <div class="gf-panel rounded-[2rem] p-4 sm:p-6 backdrop-blur-2xl">
            <div class="mb-5 flex items-center justify-between gap-4 px-2">
              <div>
                <h3 class="text-lg font-semibold">Listado de usuarios</h3>
                <p class="gf-text-muted text-sm">A continuación se pueden observar los distintos usuarios del sistema.</p>
              </div>
            </div>

            <div class="space-y-3">
              <article
                v-for="user in users.data"
                :key="user.id"
                class="gf-panel-strong gf-panel-hover-accent group rounded-[1.4rem] p-4 transition">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                  <div class="flex min-w-0 items-center gap-4">
                    <img
                      :src="user.avatar_url"
                      :alt="user.name"
                      class="h-14 w-14 rounded-2xl object-cover shadow-lg"/>

                    <div class="min-w-0">
                      <div class="flex flex-wrap items-center gap-2">
                        <h4 class="truncate text-base font-semibold">
                          {{ user.name }}
                        </h4>
                        <span class="gf-chip rounded-full px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.2em]">
                          #{{ user.id }}
                        </span>
                      </div>

                      <p class="gf-text-muted mt-1 truncate text-sm">
                        {{ user.email }}
                      </p>

                      <div class="mt-3 flex flex-wrap gap-2">
                        <span
                          v-for="role in user.roles"
                          :key="role.id"
                          class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold backdrop-blur"
                          :class="roleAccent(role.name)">
                          {{ role.name }}
                        </span>

                        <span
                          v-if="user.roles.length === 0"
                          class="gf-chip inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold">
                          Sin rol
                        </span>
                      </div>
                    </div>
                  </div>

                  <div class="flex flex-col items-start gap-3 sm:items-end">
                    <p class="gf-text-subtle text-xs uppercase tracking-[0.22em]">Creado</p>
                    <p class="text-sm font-medium">
                      {{ formatDate(user.created_at) }}
                    </p>

                    <div class="flex gap-2 pt-1">
                      <Link
                        :href="`/users/${user.id}/edit`"
                        class="gf-button-secondary rounded-2xl px-4 py-2 text-xs font-semibold transition">
                        Editar
                      </Link>

                      <button
                        @click="deleteUser(user.id)"
                        class="gf-action-danger rounded-2xl px-4 py-2 text-xs font-semibold transition">
                        Eliminar
                      </button>
                    </div>
                  </div>
                </div>
              </article>

              <div
                v-if="!users.data.length"
                class="gf-panel-strong rounded-[1.4rem] border-dashed px-6 py-14 text-center">
                <p class="text-lg font-semibold">No hay usuarios todavía</p>
                <p class="gf-text-subtle mt-2 text-sm">Cuando existan cuentas, aparecerán aquí.</p>
              </div>
            </div>
          </div>

          <aside class="space-y-6">
            <div class="gf-panel rounded-[2rem] p-6 backdrop-blur-xl">
              <h3 class="text-lg font-semibold">Resumen</h3>
              <div class="mt-5 space-y-4">
                <div class="gf-panel-soft rounded-2xl p-4">
                  <p class="gf-text-subtle text-xs uppercase tracking-[0.24em]">Total usuarios</p>
                  <p class="mt-2 text-2xl font-black">{{ users.total ?? users.data.length }}</p>
                </div>

                <div class="gf-panel-soft rounded-2xl p-4">
                  <p class="gf-text-subtle text-xs uppercase tracking-[0.24em]">Página actual</p>
                  <p class="gf-text-accent mt-2 text-2xl font-black">{{ users.current_page }}</p>
                </div>
              </div>
            </div>

            <div
              v-if="users.links?.length"
              class="gf-panel rounded-[2rem] p-6 backdrop-blur-xl">
              <h3 class="text-lg font-semibold">Paginación</h3>
              <div class="mt-5 flex flex-wrap gap-2">
                <Link
                  v-for="link in users.links"
                  :key="link.label"
                  :href="link.url || ''"
                  v-html="
                    link.label.includes('Previous')
                      ? 'Atrás'
                      : link.label.includes('Next')
                      ? 'Siguiente'
                      : link.label"
                  class="rounded-2xl border px-4 py-2 text-sm transition"
                  :class="[
                    link.active
                      ? 'gf-chip-accent'
                      : 'gf-chip hover:border-[var(--gf-line-strong)]',
                    !link.url ? 'pointer-events-none opacity-40' : '',
                  ]"/>
              </div>
            </div>
          </aside>
        </section>
      </div>
    </div>
</template>
