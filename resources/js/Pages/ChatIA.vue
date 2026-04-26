<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { nextTick, onMounted, ref, watch } from 'vue';

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
        ? 'bg-gradient-to-r from-cyan-400 via-blue-500 to-fuchsia-500 text-white rounded-2xl rounded-br-sm shadow-[0_0_20px_rgba(56,189,248,0.35)]'
        : 'bg-white/5 backdrop-blur-2xl border border-white/10 text-slate-200 rounded-2xl rounded-bl-sm shadow-[0_0_20px_rgba(15,23,42,0.6)]';
};

defineOptions({
    layout: AuthenticatedLayout
});
</script>

<template>
    <Head title="Chat IA · GameFlux" />

        <template>
            <div class="space-y-2">
                <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Assistant</p>
                <h2 class="text-xl font-semibold leading-tight bg-gradient-to-r from-cyan-400 via-blue-400 to-fuchsia-500 bg-clip-text text-transparent tracking-tight">
                    Chat IA
                </h2>
            </div>
        </template>

        <div class="h-[calc(100vh-4rem)] overflow-hidden bg-slate-950 text-slate-100">
            <div class="relative h-full">
                <div class="pointer-events-none absolute inset-0">
                    <div class="absolute -top-32 -left-24 h-72 w-72 rounded-full bg-gradient-to-br from-cyan-500 via-blue-500 to-purple-600 opacity-25 blur-3xl"></div>
                    <div class="absolute -bottom-40 -right-20 h-80 w-80 rounded-full bg-gradient-to-tr from-fuchsia-500 via-orange-400 to-yellow-300 opacity-20 blur-3xl"></div>
                </div>

                <div
                    class="pointer-events-none absolute inset-0 opacity-25 mix-blend-soft-light"
                    style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2240%22 height=%2240%22 viewBox=%220 0 40 40%22><rect width=%221%22 height=%221%22 fill=%22%23ffffff%22 opacity=%220.12%22/></svg>');"
                ></div>

                <div class="relative z-10 flex h-full flex-col px-3 py-3 sm:px-4">
                    <div class="mx-auto flex h-full w-full max-w-5xl flex-col overflow-hidden rounded-[2rem] border border-white/10 bg-slate-900/75 shadow-[0_0_45px_rgba(15,23,42,0.85)] backdrop-blur-2xl">
                        <div class="flex items-center justify-between border-b border-white/10 px-5 py-4 sm:px-6">
                            <div class="flex items-center gap-3">
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-400 via-blue-500 to-fuchsia-500 text-lg shadow-[0_0_18px_rgba(56,189,248,0.45)]">
                                    🎮
                                </div>

                                <div>
                                    <h3 class="text-base font-semibold text-white">GameFlux IA</h3>
                                    <p class="text-xs text-slate-400">Asistente para descubrir juegos</p>
                                </div>
                            </div>

                            <div class="rounded-full border border-emerald-400/20 bg-emerald-400/10 px-3 py-1 text-xs font-semibold text-emerald-300">
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
                                    <div
                                        v-if="msg.role === 'assistant'"
                                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-cyan-400 via-blue-500 to-purple-600 text-sm shadow-[0_0_14px_rgba(56,189,248,0.6)]"
                                    >
                                        🎮
                                    </div>

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

                                    <div class="rounded-2xl rounded-bl-sm border border-white/10 bg-white/5 px-4 py-3 backdrop-blur-2xl">
                                        <span class="flex items-center gap-1.5">
                                            <span class="h-2 w-2 animate-bounce rounded-full bg-slate-400" style="animation-delay: 0ms"></span>
                                            <span class="h-2 w-2 animate-bounce rounded-full bg-slate-400" style="animation-delay: 150ms"></span>
                                            <span class="h-2 w-2 animate-bounce rounded-full bg-slate-400" style="animation-delay: 300ms"></span>
                                        </span>
                                    </div>
                                </div>

                                <div ref="bottomRef"></div>
                            </div>
                        </div>

                        <div class="border-t border-white/10 bg-slate-950/70 p-4 sm:p-5">
                            <div class="mx-auto flex max-w-4xl items-end gap-3 rounded-[1.5rem] border border-white/10 bg-white/5 p-3 shadow-[0_0_20px_rgba(15,23,42,0.6)] backdrop-blur-2xl">
                                <textarea
                                    ref="inputRef"
                                    v-model="userInput"
                                    @keydown="handleKeydown"
                                    placeholder="Escribe tu mensaje..."
                                    rows="1"
                                    class="max-h-40 flex-1 resize-none bg-transparent px-2 py-2 text-sm text-slate-100 outline-none placeholder:text-slate-500"
                                ></textarea>

                                <button
                                    type="button"
                                    @click="sendMessage"
                                    :disabled="loading || !userInput.trim()"
                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-r from-cyan-400 via-blue-500 to-fuchsia-500 text-white shadow-[0_0_20px_rgba(56,189,248,0.6)] transition hover:scale-105 hover:shadow-[0_0_30px_rgba(244,114,182,0.8)] disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:scale-100"
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