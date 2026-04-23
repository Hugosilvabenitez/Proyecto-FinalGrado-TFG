<script setup lang="ts">
import { ref } from 'vue'
import { Link, Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';


interface Message {
  role: 'user' | 'assistant'
  content: string
}

const messages = ref<Message[]>([])
const userInput = ref('')
const loading = ref(false)

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
      body: JSON.stringify({ messages: messages.value }),
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

defineOptions({
    layout: AuthenticatedLayout
});
</script>

<template>
  <Head title="Chat IA · GameFlux" />
  
    <div class="min-h-screen bg-slate-950 text-slate-100 relative overflow-hidden flex flex-col">

      <!-- Blobs de fondo -->
      <div class="pointer-events-none absolute inset-0">
        <div class="absolute -top-32 -left-24 h-72 w-72 bg-gradient-to-br from-cyan-500 via-blue-500 to-purple-600 opacity-40 blur-3xl rounded-full"/>
        <div class="absolute -bottom-40 -right-20 h-80 w-80 bg-gradient-to-tr from-fuchsia-500 via-orange-400 to-yellow-300 opacity-40 blur-3xl rounded-full"/>
      </div>

      <!-- Grain -->
      <div
        class="pointer-events-none absolute inset-0 opacity-30 mix-blend-soft-light"
        style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2240%22 height=%2240%22 viewBox=%220 0 40 40%22><rect width=%221%22 height=%221%22 fill=%22%23ffffff%22 opacity=%220.12%22/></svg>');"
      />

      <!-- Header
      <div class="relative z-10 bg-white/5 backdrop-blur-2xl border-b border-white/10 px-6 py-4 flex items-center gap-4">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-gradient-to-br from-cyan-400 via-blue-500 to-purple-600 rounded-full flex items-center justify-center text-lg shadow-[0_0_20px_rgba(56,189,248,0.7)]">
            🎮
          </div>
          <div>
            <h1 class="font-semibold text-slate-100 text-sm tracking-tight">Asistente GameFlux</h1>
            <p class="text-xs text-emerald-400 flex items-center gap-1">
              <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full shadow-[0_0_6px_#4ade80] inline-block animate-pulse"/>
              En línea
            </p>
          </div>
        </div>
      </div> -->

      <!-- Mensajes -->
      <div class="relative z-10 flex-1 overflow-y-auto px-4 py-6 space-y-4 max-w-3xl mx-auto w-full">
        <div
          v-for="(msg, i) in messages"
          :key="i"
          class="flex items-end gap-2"
          :class="msg.role === 'user' ? 'justify-end' : 'justify-start'"
        >
          <!-- Avatar IA -->
          <div
            v-if="msg.role === 'assistant'"
            class="w-8 h-8 bg-gradient-to-br from-cyan-400 via-blue-500 to-purple-600 rounded-full flex items-center justify-center text-sm shrink-0 shadow-[0_0_14px_rgba(56,189,248,0.6)]"
          >
            🎮
          </div>

          <!-- Burbuja -->
          <div
            class="max-w-sm px-4 py-3 text-sm leading-relaxed"
            :class="msg.role === 'user'
              ? 'bg-gradient-to-r from-cyan-400 via-blue-500 to-fuchsia-500 text-white rounded-2xl rounded-br-sm shadow-[0_0_20px_rgba(56,189,248,0.4)]'
              : 'bg-white/5 backdrop-blur-2xl border border-white/10 text-slate-200 rounded-2xl rounded-bl-sm shadow-[0_0_20px_rgba(15,23,42,0.6)]'"
          >
            {{ msg.content }}
          </div>
        </div>

        <!-- Typing indicator -->
        <div v-if="loading" class="flex items-end gap-2 justify-start">
          <div class="w-8 h-8 bg-gradient-to-br from-cyan-400 via-blue-500 to-purple-600 rounded-full flex items-center justify-center text-sm shrink-0 shadow-[0_0_14px_rgba(56,189,248,0.6)]">
            🎮
          </div>
          <div class="bg-white/5 backdrop-blur-2xl border border-white/10 px-4 py-3 rounded-2xl rounded-bl-sm">
            <span class="flex gap-1.5 items-center">
              <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0ms"/>
              <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 150ms"/>
              <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 300ms"/>
            </span>
          </div>
        </div>
      </div>

      <!-- Input -->
      <div class="relative z-10 bg-white/5 backdrop-blur-2xl border-t border-white/10 px-4 py-8">
        <div class="max-w-3xl mx-auto flex gap-4 items-end px-4 py-8 bg-white/5 border border-white/10 rounded-2xl shadow-[0_0_20px_rgba(15,23,42,0.6)]">
          <textarea
            v-model="userInput"
            @keydown.enter="handleEnter"
            placeholder="Escribe tu respuesta..."
            rows="1"
            class="flex-1 bg-white/5 border border-white/10 rounded-2xl px-4 py-3 text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:border-cyan-400/50 focus:shadow-[0_0_16px_rgba(56,189,248,0.2)] transition-all resize-none"
          />
          <button
            @click="sendMessage"
            :disabled="loading || !userInput.trim()"
            class="w-11 h-11 rounded-2xl bg-gradient-to-r from-cyan-400 via-blue-500 to-fuchsia-500 text-white flex items-center justify-center shrink-0 shadow-[0_0_20px_rgba(56,189,248,0.6)] hover:shadow-[0_0_30px_rgba(244,114,182,0.8)] hover:scale-105 transition-all disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:scale-100 disabled:hover:shadow-[0_0_20px_rgba(56,189,248,0.6)]"
          >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <line x1="22" y1="2" x2="11" y2="13"/>
              <polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </svg>
          </button>
        </div>
      </div>

    </div>
  
</template>