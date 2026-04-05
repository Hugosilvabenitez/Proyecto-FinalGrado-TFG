<script setup lang="ts">
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

interface Message {
  role: 'user' | 'assistant'
  content: string
}

const messages = ref<Message[]>([])
const userInput = ref('')
const loading = ref(false)

// Mensaje inicial de bienvenida
messages.value.push({
  role: 'assistant',
  content: '¡Hola! Soy tu asistente de GameFlux 🎮 Voy a ayudarte a encontrar el juego perfecto para ti. ¿Empezamos?'
})

async function sendMessage() {
  const text = userInput.value.trim()
  if (!text || loading.value) return

  messages.value.push({ role: 'user', content: text })
  userInput.value = ''
  loading.value = true

  try {
    const response = await fetch('/chat-ia', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content ?? '',
    },
    body: JSON.stringify({
    messages: messages.value,
  }),
})

    const data = await response.json()

    if (data.reply) {
      messages.value.push({ role: 'assistant', content: data.reply })
    } else {
      messages.value.push({ role: 'assistant', content: 'Ha ocurrido un error, inténtalo de nuevo.' })
    }
  } catch {
    messages.value.push({ role: 'assistant', content: 'No se pudo conectar con la IA.' })
  } finally {
    loading.value = false
  }
}

function handleEnter(e: KeyboardEvent) {
  if (!e.shiftKey) {
    e.preventDefault()
    sendMessage()
  }
}
</script>

<template>
  <div class="min-h-screen bg-gray-900 text-white flex flex-col">

    <!-- Cabecera -->
    <div class="bg-gray-800 border-b border-gray-700 px-6 py-4 flex items-center gap-4">
      <Link href="/" class="text-gray-400 hover:text-white transition">←</Link>
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center text-lg">
          🎮
        </div>
        <div>
          <h1 class="font-bold text-white">Asistente GameFlux</h1>
          <p class="text-xs text-green-400">● En línea</p>
        </div>
      </div>
    </div>

    <!-- Mensajes -->
    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-4 max-w-3xl mx-auto w-full">
      <div
        v-for="(msg, i) in messages"
        :key="i"
        class="flex"
        :class="msg.role === 'user' ? 'justify-end' : 'justify-start'"
      >
        <!-- Avatar IA -->
        <div
          v-if="msg.role === 'assistant'"
          class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center text-sm mr-2 mt-1 shrink-0"
        >
          🎮
        </div>

        <!-- Burbuja -->
        <div
          class="max-w-sm px-4 py-3 rounded-2xl text-sm leading-relaxed"
          :class="msg.role === 'user'
            ? 'bg-red-600 text-white rounded-tr-none'
            : 'bg-gray-700 text-gray-100 rounded-tl-none'"
        >
          {{ msg.content }}
        </div>
      </div>

      <!-- Indicador de carga -->
      <div v-if="loading" class="flex justify-start">
        <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center text-sm mr-2 shrink-0">
          🎮
        </div>
        <div class="bg-gray-700 px-4 py-3 rounded-2xl rounded-tl-none">
          <span class="flex gap-1">
            <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
            <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
            <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
          </span>
        </div>
      </div>
    </div>

    <!-- Input -->
    <div class="bg-gray-800 border-t border-gray-700 px-4 py-4">
      <div class="max-w-3xl mx-auto flex gap-3">
        <textarea
          v-model="userInput"
          @keydown.enter="handleEnter"
          placeholder="Escribe tu respuesta..."
          rows="1"
          class="flex-1 bg-gray-700 border border-gray-600 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-red-500 transition resize-none"
        />
        <button
          @click="sendMessage"
          :disabled="loading || !userInput.trim()"
          class="bg-red-600 hover:bg-red-700 disabled:opacity-50 text-white px-5 py-3 rounded-xl transition font-medium"
        >
          Enviar
        </button>
      </div>
      <p class="text-center text-xs text-gray-500 mt-2">Enter para enviar · Shift+Enter para nueva línea</p>
    </div>

  </div>
</template>