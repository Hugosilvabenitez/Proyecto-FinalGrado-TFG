<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3'

interface Role {
  id: number
  name: string
}

interface User {
  id: number
  username: string
  email: string
  roles: Role[]
}

interface Props {
  user: User
  roles: Role[]
}

const props = defineProps<Props>()

const form = useForm({
  username: props.user.username,
  email: props.user.email,
  password: '',
  password_confirmation: '',
  roles: props.user.roles.map((r) => r.id),
})

function submit() {
  form.put(`/users/${props.user.id}`)
}
</script>

<template>
  <div class="min-h-screen bg-gray-900 text-white p-8">
    <div class="max-w-2xl mx-auto">

      <!-- Cabecera -->
      <div class="flex items-center gap-4 mb-8">
        <Link href="/users" class="text-gray-400 hover:text-white transition">
          ← Volver
        </Link>
        <h1 class="text-3xl font-bold text-red-500">✏️ Editar Usuario</h1>
      </div>

      <!-- Formulario -->
      <form @submit.prevent="submit" class="bg-gray-800 rounded-xl p-6 space-y-6">

        <!-- Username -->
        <div>
          <label class="block text-sm font-medium text-gray-300 mb-1">
            Nombre de usuario
          </label>
          <input
            v-model="form.username"
            type="text"
            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-red-500 transition"
          />
          <p v-if="form.errors.username" class="text-red-400 text-xs mt-1">
            {{ form.errors.username }}
          </p>
        </div>

        <!-- Email -->
        <div>
          <label class="block text-sm font-medium text-gray-300 mb-1">
            Email
          </label>
          <input
            v-model="form.email"
            type="email"
            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-red-500 transition"
          />
          <p v-if="form.errors.email" class="text-red-400 text-xs mt-1">
            {{ form.errors.email }}
          </p>
        </div>

        <!-- Nueva Password (opcional) -->
        <div>
          <label class="block text-sm font-medium text-gray-300 mb-1">
            Nueva contraseña
            <span class="text-gray-500 font-normal">(dejar vacío para no cambiar)</span>
          </label>
          <input
            v-model="form.password"
            type="password"
            placeholder="Mínimo 8 caracteres"
            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-red-500 transition"
          />
          <p v-if="form.errors.password" class="text-red-400 text-xs mt-1">
            {{ form.errors.password }}
          </p>
        </div>

        <!-- Confirmar Password -->
        <div>
          <label class="block text-sm font-medium text-gray-300 mb-1">
            Confirmar nueva contraseña
          </label>
          <input
            v-model="form.password_confirmation"
            type="password"
            placeholder="Repite la contraseña"
            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-red-500 transition"
          />
        </div>

        <!-- Roles -->
        <div>
          <label class="block text-sm font-medium text-gray-300 mb-2">
            Roles
          </label>
          <div class="flex flex-wrap gap-3">
            <label
              v-for="role in roles"
              :key="role.id"
              class="flex items-center gap-2 cursor-pointer"
            >
              <input
                type="checkbox"
                :value="role.id"
                v-model="form.roles"
                class="accent-red-500"
              />
              <span class="text-sm text-gray-300">{{ role.name }}</span>
            </label>
          </div>
          <p v-if="form.errors.roles" class="text-red-400 text-xs mt-1">
            {{ form.errors.roles }}
          </p>
        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-3 pt-2">
          <Link
            href="/users"
            class="bg-gray-700 hover:bg-gray-600 text-white px-5 py-2 rounded-lg transition"
          >
            Cancelar
          </Link>
          <button
            type="submit"
            :disabled="form.processing"
            class="bg-red-600 hover:bg-red-700 disabled:opacity-50 text-white px-5 py-2 rounded-lg transition"
          >
            {{ form.processing ? 'Guardando...' : 'Guardar cambios' }}
          </button>
        </div>

      </form>
    </div>
  </div>
</template>