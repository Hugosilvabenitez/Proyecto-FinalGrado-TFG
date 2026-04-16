<!--
Blog Index (View)

@author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
@date 2026-04-05

This file contains all the necessary lines for the Blog's Index.
-->
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import PostComments from '@/Components/PostComments.vue';

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

const avatarFromUser = (user) => {
    if (user?.avatar_url) return user.avatar_url.replace('https://', 'http://');
    return 'https://api.dicebear.com/9.x/fun-emoji/svg?seed=guest&backgroundColor=1d1440&radius=50';
};

const firstName = (name) => name?.split(' ')[0] || 'Trainer';

defineOptions({
    layout: AuthenticatedLayout
});
</script>

<template>
    <Head title="Blog · GameFlux" />

        <template>
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
            <div class="mx-auto max-w-7xl space-y-8">
                <section class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-6 shadow-[0_0_35px_rgba(15,23,42,0.9)] backdrop-blur-2xl">
                        <p class="text-xs uppercase tracking-[0.28em] text-slate-400">Entradas</p>
                        <p class="mt-3 text-4xl font-black text-slate-100">{{ totalPosts }}</p>
                        <p class="mt-2 text-sm text-slate-500">Publicaciones en el blog</p>
                    </div>

                    <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-6 shadow-[0_0_35px_rgba(15,23,42,0.9)] backdrop-blur-2xl">
                        <p class="text-xs uppercase tracking-[0.28em] text-slate-400">Comentarios</p>
                        <p class="mt-3 text-4xl font-black text-slate-100">{{ totalComments }}</p>
                        <p class="mt-2 text-sm text-slate-500">Interacciones totales</p>
                    </div>

                    <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-6 shadow-[0_0_35px_rgba(15,23,42,0.9)] backdrop-blur-2xl">
                        <p class="text-xs uppercase tracking-[0.28em] text-slate-400">Estado</p>
                        <p class="mt-3 text-2xl font-bold text-cyan-300">Activo</p>
                        <p class="mt-2 text-sm text-slate-500">Comunidad GameFlux en marcha</p>
                    </div>
                </section>

                <div class="grid grid-cols-1 gap-8 xl:grid-cols-[0.95fr_1.35fr]">
                    <aside class="space-y-8">
                        <section class="rounded-3xl border border-white/10 bg-slate-900/80 p-6 shadow-[0_0_35px_rgba(15,23,42,0.9)] backdrop-blur-2xl">
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-slate-100">Crear publicación</h3>
                                <p class="mt-1 text-sm text-slate-400">Publica una nueva entrada para el blog.</p>
                            </div>

                            <form @submit.prevent="submit" class="space-y-4">
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-200">Título</label>
                                    <input
                                        v-model="form.title"
                                        type="text"
                                        placeholder="Título de la publicación"
                                        class="w-full rounded-2xl border border-slate-700 bg-slate-950/80 px-4 py-3 text-slate-100 outline-none transition placeholder:text-slate-500 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30"
                                    />
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-200">Contenido</label>
                                    <textarea
                                        v-model="form.content"
                                        rows="10"
                                        placeholder="Escribe aquí tu publicación..."
                                        class="w-full resize-none rounded-2xl border border-slate-700 bg-slate-950/80 px-4 py-3 text-slate-100 outline-none transition placeholder:text-slate-500 focus:border-fuchsia-400 focus:ring-2 focus:ring-fuchsia-400/30"
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

                        <section class="rounded-3xl border border-white/10 bg-slate-900/80 p-6 shadow-[0_0_35px_rgba(15,23,42,0.9)] backdrop-blur-2xl">
                            <h3 class="text-lg font-semibold text-slate-100">Actividad reciente</h3>
                            <p class="mt-1 text-sm text-slate-400">Vista rápida del contenido más reciente.</p>

                            <div v-if="posts.length" class="mt-5 space-y-3">
                                <div
                                    v-for="post in posts.slice(0, 3)"
                                    :key="post.id"
                                    class="rounded-2xl border border-white/10 bg-slate-950/60 p-4"
                                >
                                    <div class="flex items-center gap-3">
                                        <img
                                            :src="avatarFromUser(post.user)"
                                            alt="Avatar"
                                            class="h-10 w-10 rounded-full border border-white/10 object-cover"
                                        />
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-semibold text-slate-100">
                                                {{ post.title }}
                                            </p>
                                            <p class="text-xs text-slate-400">
                                                por {{ firstName(post.user?.name) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-else class="mt-5 rounded-2xl border border-dashed border-slate-700 bg-slate-950/40 px-4 py-6 text-sm text-slate-500">
                                Aún no hay actividad.
                            </div>
                        </section>
                    </aside>

                    <section class="rounded-3xl border border-white/10 bg-slate-900/80 p-6 shadow-[0_0_35px_rgba(15,23,42,0.9)] backdrop-blur-2xl">
                        <div class="mb-6 flex items-end justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-100">Publicaciones</h3>
                                <p class="mt-1 text-sm text-slate-400"> Publicaciones y comentarios.</p>
                            </div>

                            <div class="rounded-full border border-cyan-400/20 bg-cyan-400/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-cyan-300">
                                Feed
                            </div>
                        </div>

                        <div v-if="posts.length" class="space-y-5">
                            <article
                                v-for="post in posts"
                                :key="post.id"
                                class="rounded-3xl border border-white/10 bg-slate-950/70 p-5 transition hover:border-cyan-400/30 hover:shadow-[0_0_28px_rgba(56,189,248,0.12)]"
                            >
                                <div class="flex items-start gap-4">
                                    <img
                                        :src="avatarFromUser(post.user)"
                                        alt="Avatar"
                                        class="h-12 w-12 rounded-full border border-white/10 object-cover shrink-0"
                                    />

                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-center justify-between gap-3">
                                            <div>
                                                <h4 class="text-base font-semibold text-slate-100">
                                                    {{ post.title }}
                                                </h4>
                                                <p class="text-xs text-slate-400">
                                                    por {{ firstName(post.user?.name) }}
                                                </p>
                                            </div>

                                            <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.22em] text-slate-400">
                                                #{{ post.id }}
                                            </span>
                                        </div>

                                        <p class="mt-4 whitespace-pre-line text-sm leading-6 text-slate-300">
                                            {{ post.content }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-5 border-t border-white/10 pt-5">
                                    <PostComments :post="post" />
                                </div>
                            </article>
                        </div>

                        <div
                            v-else
                            class="rounded-3xl border border-dashed border-slate-700 bg-slate-950/40 px-6 py-12 text-center"
                        >
                            <p class="text-lg font-semibold text-slate-200">Todavía no hay publicaciones</p>
                            <p class="mt-2 text-sm text-slate-500">
                                Crea la primera entrada para empezar con el blog de GameFlux.
                            </p>
                        </div>
                    </section>
                </div>
            </div>
        </div>
</template>