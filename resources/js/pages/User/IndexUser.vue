<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3'

interface Role {
  id: number
  name: string
}

interface User {
  id: number
  username: string
  email: string
  created_at: string
  roles: Role[]
}

interface Props {
  users: {
    data: User[]
    current_page: number
    last_page: number
    next_page_url: string | null
    prev_page_url: string | null
  }
}

const props = defineProps<Props>()

function deleteUser(id: number) {
  if (confirm('¿Seguro que quieres eliminar este usuario?')) {
    router.delete(`/users/${id}`)
  }
}
</script>

<template>
  <div class="min-h-screen bg-gray-900 text-white p-8">
    <div class="max-w-6xl mx-auto">

      <!-- Cabecera -->
      <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-red-500">👥 Gestión de Usuarios</h1>
        <Link
          href="/users/create"
          class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition"
        >
          + Nuevo usuario
        </Link>
      </div>

      <!-- Tabla -->
      <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg">
        <table class="w-full text-sm">
          <thead class="bg-gray-700 text-gray-300 uppercase text-xs">
            <tr>
              <th class="px-6 py-4 text-left">ID</th>
              <th class="px-6 py-4 text-left">Usuario</th>
              <th class="px-6 py-4 text-left">Email</th>
              <th class="px-6 py-4 text-left">Roles</th>
              <th class="px-6 py-4 text-left">Creado</th>
              <th class="px-6 py-4 text-left">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="user in users.data"
              :key="user.id"
              class="border-t border-gray-700 hover:bg-gray-750 transition"
            >
              <td class="px-6 py-4 text-gray-400">{{ user.id }}</td>
              <td class="px-6 py-4 font-medium">{{ user.username }}</td>
              <td class="px-6 py-4 text-gray-400">{{ user.email }}</td>
              <td class="px-6 py-4">
                <span
                  v-for="role in user.roles"
                  :key="role.id"
                  class="bg-red-900 text-red-300 text-xs px-2 py-1 rounded-full mr-1"
                >
                  {{ role.name }}
                </span>
                <span v-if="user.roles.length === 0" class="text-gray-500 text-xs">
                  Sin rol
                </span>
              </td>
              <td class="px-6 py-4 text-gray-400">
                {{ new Date(user.created_at).toLocaleDateString('es-ES') }}
              </td>
              <td class="px-6 py-4 flex gap-2">
                <Link
                  :href="`/users/${user.id}/edit`"
                  class="bg-yellow-600 hover:bg-yellow-700 text-white text-xs px-3 py-1 rounded transition"
                >
                  Editar
                </Link>
                <button
                  @click="deleteUser(user.id)"
                  class="bg-red-700 hover:bg-red-800 text-white text-xs px-3 py-1 rounded transition"
                >
                  Eliminar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Paginación -->
      <!-- <div class="flex justify-between items-center mt-6 text-sm text-gray-400">
        <span>Página {{ users.current_page }} de {{ users.last_page }}</span>
        <div class="flex gap-2">
          <Link
            v-if="users.prev_page_url"
            :href="users.prev_page_url"
            class="bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded transition"
          >
            ← Anterior
          </Link>
          <Link
            v-if="users.next_page_url"
            :href="users.next_page_url"
            class="bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded transition"
          >
            Siguiente →
          </Link>
        </div>
      </div> -->

    </div>
  </div>
</template>