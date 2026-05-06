<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { nextTick, onMounted, ref, watch } from 'vue';

/**
 * AI CHAT'S VIEW
 * 
 * These 
 */

interface Message {
    role: 'user' | 'assistant';
    content: string;
}

const messages = ref<Message[]>([
    {
        role: 'assistant',
        content:
            '¡Hola! Soy tu asistente de GameFlux 🎮 Voy a ayudarte a encontrar el juego perfecto para ti. ¿Empezamos?',
    },
]);

const userInput = ref('');
const loading = ref(false);
const bottomRef = ref<HTMLElement | null>(null);
const inputRef = ref<HTMLTextAreaElement | null>(null);

const scrollToBottom = async () => {
    await nextTick();
    bottomRef.value?.scrollIntoView({ behavior: 'smooth', block: 'end' });
};

watch(
    () => messages.value.length,
    () => {
        scrollToBottom();
    }
);

onMounted(() => {
    scrollToBottom();
    inputRef.value?.focus();
});

const sendMessage = async () => {
    const text = userInput.value.trim();
    if (!text || loading.value) return;

    messages.value.push({ role: 'user', content: text });
    userInput.value = '';
    loading.value = true;

    try {
        const response = await fetch('/chat-ia', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                'X-CSRF-TOKEN':
                    (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content ?? '',
            },
            body: JSON.stringify({ messages: messages.value }),
        });

        const data = await response.json();

        messages.value.push({
            role: 'assistant',
            content: data.reply || 'Ha ocurrido un error, inténtalo de nuevo.',
        });
    } catch {
        messages.value.push({
            role: 'assistant',
            content: 'No se pudo conectar con la IA.',
        });
    } finally {
        loading.value = false;
        await scrollToBottom();
        inputRef.value?.focus();
    }
};

const handleKeydown = (e: KeyboardEvent) => {
    if (e.key !== 'Enter' || e.shiftKey) return;

    e.preventDefault();
    sendMessage();
};

const messageClass = (role: Message['role']) => {
    return role === 'user'
        ? 'gf-message-user rounded-2xl rounded-br-sm'
        : 'gf-message-assistant rounded-2xl rounded-bl-sm backdrop-blur-2xl';
};

defineOptions({
    layout: AuthenticatedLayout
});
</script>

<template>
    <Head title="Chat IA · GameFlux" />

        <template>
            <div class="space-y-2">
                <p class="gf-text-subtle text-xs uppercase tracking-[0.35em]">Assistant</p>
                <h2 class="gf-title-gradient text-xl font-semibold leading-tight tracking-tight">
                    Chat IA
                </h2>
            </div>
        </template>

        <div class="gf-page h-[calc(100vh-4rem)] overflow-hidden">
            <div class="relative h-full">
                <div class="pointer-events-none absolute inset-0">
                    <div class="gf-page-orb-primary absolute -top-32 -left-24 h-72 w-72 rounded-full"></div>
                    <div class="gf-page-orb-secondary absolute -bottom-40 -right-20 h-80 w-80 rounded-full"></div>
                </div>

                <div class="gf-page-grid pointer-events-none absolute inset-0"></div>

                <div class="relative z-10 flex h-full flex-col px-3 py-3 sm:px-4">
                    <div class="gf-panel mx-auto flex h-full w-full max-w-5xl flex-col overflow-hidden rounded-[2rem] backdrop-blur-2xl">
                        <div class="flex items-center justify-between border-b px-5 py-4 sm:px-6" :style="{ borderColor: 'var(--gf-line)' }">
                            <div class="flex items-center gap-3">
                            <img
                                src="/images/santiago-ia.png"
                                alt="Santiago IA"
                                class="h-10 w-10 rounded-full object-cover border-4 border-cyan-400 drop-shadow-[0_0_15px_rgba(59,130,246,0.75)] group-hover:scale-110 transition-transform"
                            />
                                
                                <div>
                                    <h3 class="text-base font-semibold text-white">Santiago</h3>
                                    <p class="text-xs text-slate-400">Asistente para descubrir juegos</p>
                                </div>
                            </div>

                            <div class="gf-chip gf-chip-success rounded-full px-3 py-1 text-xs font-semibold">
                                Online
                            </div>
                        </div>

                        <div class="flex-1 overflow-y-auto px-4 py-5 sm:px-6">
                            <div class="space-y-4">
                                <div
                                    v-for="(msg, i) in messages"
                                    :key="i"
                                    class="flex items-end gap-2"
                                    :class="msg.role === 'user' ? 'justify-end' : 'justify-start'"
                                >
                                    <img
                                        v-if="msg.role === 'assistant'"
                                        src="/images/santiago-ia.png"
                                        alt="Santiago IA"
                                        class="h-10 w-10 rounded-full object-cover border-4 border-cyan-400 drop-shadow-[0_0_15px_rgba(59,130,246,0.75)] group-hover:scale-110 transition-transform"
                                    />

                                    <div
                                        class="max-w-[85%] px-4 py-3 text-sm leading-relaxed sm:max-w-[70%]"
                                        :class="messageClass(msg.role)"
                                    >
                                        <p class="whitespace-pre-wrap break-words">
                                            {{ msg.content }}
                                        </p>
                                    </div>
                                </div>

                                <div v-if="loading" class="flex items-end gap-2 justify-start">
                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-cyan-400 via-blue-500 to-purple-600 text-sm shadow-[0_0_14px_rgba(56,189,248,0.6)]">
                                        🎮
                                    </div>

                                    <div class="gf-message-assistant rounded-2xl rounded-bl-sm px-4 py-3 backdrop-blur-2xl">
                                        <span class="flex items-center gap-1.5">
                                            <span class="gf-text-subtle h-2 w-2 animate-bounce rounded-full" style="animation-delay: 0ms; background: var(--gf-subtle);"></span>
                                            <span class="gf-text-subtle h-2 w-2 animate-bounce rounded-full" style="animation-delay: 150ms; background: var(--gf-subtle);"></span>
                                            <span class="gf-text-subtle h-2 w-2 animate-bounce rounded-full" style="animation-delay: 300ms; background: var(--gf-subtle);"></span>
                                        </span>
                                    </div>
                                </div>

                                <div ref="bottomRef"></div>
                            </div>
                        </div>

                        <div class="gf-panel-strong border-t p-4 sm:p-5" :style="{ borderColor: 'var(--gf-line)' }">
                            <div class="gf-panel-soft mx-auto flex max-w-4xl items-end gap-3 rounded-[1.5rem] p-3 backdrop-blur-2xl">
                                <textarea
                                    ref="inputRef"
                                    v-model="userInput"
                                    @keydown="handleKeydown"
                                    placeholder="Escribe tu mensaje..."
                                    rows="1"
                                    class="max-h-40 flex-1 resize-none bg-transparent px-2 py-2 text-sm text-slate-100 placeholder:text-slate-500 outline-none border-none ring-0 focus:ring-0 focus:outline-none"

                                ></textarea>

                                <button
                                    type="button"
                                    @click="sendMessage"
                                    :disabled="loading || !userInput.trim()"
                                    class="gf-button-primary flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:scale-100"
                                >
                                    <svg
                                        class="h-4 w-4"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <line x1="22" y1="2" x2="11" y2="13"></line>
                                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>
