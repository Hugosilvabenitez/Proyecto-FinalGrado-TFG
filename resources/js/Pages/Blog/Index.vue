<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    posts: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    title: '',
    content: '',
});

const submit = () => {
    form.post('/posts', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};

const totalPosts = computed(() => props.posts.length);
const totalComments = computed(() =>
    props.posts.reduce((acc, post) => acc + (post.comments?.length || 0), 0)
);
</script>

<template>
    <Head title="Blog · GameFlux" />

    <AuthenticatedLayout>
        <template #header>
            <div class="space-y-2">
                <h2 class="text-xl font-semibold leading-tight bg-gradient-to-r from-cyan-400 via-blue-400 to-fuchsia-500 bg-clip-text text-transparent tracking-tight">
                    Blog GameFlux
                </h2>
                <p class="text-xs text-slate-400">
                    Publica novedades, comparte guías y comenta las entradas de la comunidad.
                </p>
            </div>
        </template>

        <div class="min-h-screen px-4 py-10 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-6xl space-y-8">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="rounded-3xl border border-white/10 bg-slate-900/80 backdrop-blur-2xl p-6 shadow-[0_0_35px_rgba(15,23,42,0.9)]">
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Entradas</p>
                        <p class="mt-2 text-3xl font-black text-slate-100">{{ totalPosts }}</p>
                    </div>

                    <div class="rounded-3xl border border-white/10 bg-slate-900/80 backdrop-blur-2xl p-6 shadow-[0_0_35px_rgba(15,23,42,0.9)]">
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Comentarios</p>
                        <p class="mt-2 text-3xl font-black text-slate-100">{{ totalComments }}</p>
                    </div>

                    <div class="rounded-3xl border border-white/10 bg-slate-900/80 backdrop-blur-2xl p-6 shadow-[0_0_35px_rgba(15,23,42,0.9)]">
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Estado</p>
                        <p class="mt-2 text-lg font-semibold text-cyan-300">Contenido activo</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-8 lg:grid-cols-[1.05fr_1.4fr]">
                    <section class="rounded-3xl border border-white/10 bg-slate-900/80 backdrop-blur-2xl p-6 sm:p-8 shadow-[0_0_35px_rgba(15,23,42,0.9)]">
                        <header class="mb-6 space-y-1">
                            <h3 class="text-lg font-semibold text-slate-100">Crear publicación</h3>
                            <p class="text-sm text-slate-400">Escribe una nueva entrada para el blog de GameFlux.</p>
                        </header>

                        <form @submit.prevent="submit" class="space-y-4">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-200">Título</label>
                                <input
                                    v-model="form.title"
                                    type="text"
                                    placeholder="Título de la publicación"
                                    class="w-full rounded-2xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-slate-100 placeholder-slate-500 outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30" style="color: black;"
                                />
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-200">Contenido</label>
                                <textarea
                                    v-model="form.content"
                                    rows="8"
                                    placeholder="Escribe aquí el contenido..."
                                    class="w-full resize-none rounded-2xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-slate-100 placeholder-slate-500 outline-none transition focus:border-fuchsia-400 focus:ring-2 focus:ring-fuchsia-400/30" style="color: black;"
                                />
                            </div>

                            <div class="flex items-center justify-between gap-3">
                                <p v-if="form.recentlySuccessful" class="text-sm font-medium text-emerald-400">
                                    Publicación enviada.
                                </p>

                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="ml-auto rounded-2xl bg-gradient-to-r from-cyan-400 via-blue-500 to-fuchsia-500 px-5 py-3 text-sm font-semibold text-white shadow-[0_0_22px_rgba(56,189,248,0.7)] transition hover:shadow-[0_0_30px_rgba(244,114,182,0.8)] disabled:cursor-not-allowed disabled:opacity-50"
                                >
                                    Publicar
                                </button>
                            </div>
                        </form>
                    </section>

                    <section class="space-y-6">
                        <div class="rounded-3xl border border-white/10 bg-slate-900/80 backdrop-blur-2xl p-6 sm:p-8 shadow-[0_0_35px_rgba(15,23,42,0.9)]">
                            <header class="mb-6 flex items-center justify-between gap-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-100">Publicaciones</h3>
                                    <p class="text-sm text-slate-400">Últimas entradas y sus comentarios.</p>
                                </div>
                            </header>

                            <div v-if="posts.length" class="space-y-4">
                                <article
                                    v-for="post in posts"
                                    :key="post.id"
                                    class="rounded-3xl border border-white/10 bg-slate-950/70 p-5 transition hover:border-cyan-400/40 hover:shadow-[0_0_25px_rgba(56,189,248,0.18)]"
                                >
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="min-w-0">
                                            <h4 class="truncate text-base font-semibold text-slate-100">
                                                {{ post.title }}
                                            </h4>
                                            <p class="mt-2 text-sm leading-6 text-slate-300">
                                                {{ post.content }}
                                            </p>
                                        </div>
                                        <span class="shrink-0 rounded-full border border-cyan-400/20 bg-cyan-400/10 px-3 py-1 text-xs font-semibold text-cyan-300">
                                            #{{ post.id }}
                                        </span>
                                    </div>

                                    <div class="mt-5 border-t border-white/10 pt-4">
                                        <div class="mb-3 flex items-center justify-between">
                                            <p class="text-sm font-semibold text-slate-200">Comentarios</p>
                                            <p class="text-xs text-slate-500">
                                                {{ post.comments?.length || 0 }} comentarios
                                            </p>
                                        </div>

                                        <div v-if="post.comments?.length" class="space-y-3">
                                            <div
                                                v-for="comment in post.comments"
                                                :key="comment.id"
                                                class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3"
                                            >
                                                <p class="text-sm text-slate-200">
                                                    {{ comment.content }}
                                                </p>
                                            </div>
                                        </div>

                                        <div v-else class="rounded-2xl border border-dashed border-slate-700 bg-slate-950/40 px-4 py-4 text-sm text-slate-500">
                                            Aún no hay comentarios en esta publicación.
                                        </div>
                                    </div>
                                </article>
                            </div>

                            <div
                                v-else
                                class="rounded-3xl border border-dashed border-slate-700 bg-slate-950/40 px-6 py-10 text-center"
                            >
                                <p class="text-lg font-semibold text-slate-200">Todavía no hay publicaciones</p>
                                <p class="mt-2 text-sm text-slate-500">
                                    Crea la primera entrada para empezar con el blog de GameFlux.
                                </p>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>