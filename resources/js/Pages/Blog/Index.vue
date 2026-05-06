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
import { router } from '@inertiajs/vue3';

const props = defineProps({
    posts: {
        type: Array,
        default: () => [],
    },
    auth: Object,
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

const canDelete = () => {
    return props.auth?.user?.roles?.some(r =>
        ['admin', 'moderator'].includes(r.name.toLowerCase())
    );
};

const deletePost = (id) => {
    if (!confirm('¿Eliminar este post?')) return;

    router.delete(`/posts/${id}`, {
        preserveScroll: true,
    });
};

defineOptions({
    layout: AuthenticatedLayout
});
</script>

<template>
    <Head title="Blog · GameFlux" />

        <div class="gf-page relative min-h-screen overflow-x-hidden px-4 py-10 sm:px-6 lg:px-8">
            <div class="pointer-events-none absolute inset-0">
                <div class="gf-page-orb-primary absolute -top-28 -left-20 h-72 w-72"></div>
                <div class="gf-page-orb-secondary absolute bottom-0 right-0 h-80 w-80"></div>
            </div>

            <div class="gf-page-grid pointer-events-none absolute inset-0"></div>

            <div class="relative z-10 mx-auto max-w-7xl space-y-8">
                <section class="gf-panel-hero rounded-[2rem] p-8 backdrop-blur-2xl sm:p-10">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                        <div class="max-w-2xl space-y-3">
                            <p class="gf-text-accent text-xs font-semibold uppercase tracking-[0.32em]">Comunidad</p>
                            <h2 class="gf-title-gradient text-3xl font-black tracking-tight sm:text-4xl">
                                Blog GameFlux
                            </h2>
                            <p class="gf-text-muted text-sm leading-6 sm:text-base">
                                Publica novedades, comparte guías y comenta las entradas de la comunidad con la misma paleta activa del resto de la app.
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <div class="gf-chip gf-chip-accent rounded-full px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em]">
                                {{ totalPosts }} posts
                            </div>
                            <div class="gf-chip gf-chip-secondary rounded-full px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em]">
                                {{ totalComments }} comentarios
                            </div>
                        </div>
                    </div>
                </section>

                <section class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="gf-panel rounded-3xl p-6 backdrop-blur-2xl">
                        <p class="gf-text-subtle text-xs uppercase tracking-[0.28em]">Entradas</p>
                        <p class="mt-3 text-4xl font-black">{{ totalPosts }}</p>
                        <p class="gf-text-subtle mt-2 text-sm">Publicaciones en el blog</p>
                    </div>

                    <div class="gf-panel rounded-3xl p-6 backdrop-blur-2xl">
                        <p class="gf-text-subtle text-xs uppercase tracking-[0.28em]">Comentarios</p>
                        <p class="mt-3 text-4xl font-black">{{ totalComments }}</p>
                        <p class="gf-text-subtle mt-2 text-sm">Interacciones totales</p>
                    </div>

                    <div class="gf-panel rounded-3xl p-6 backdrop-blur-2xl">
                        <p class="gf-text-subtle text-xs uppercase tracking-[0.28em]">Estado</p>
                        <p class="gf-text-accent mt-3 text-2xl font-bold">Activo</p>
                        <p class="gf-text-subtle mt-2 text-sm">Comunidad GameFlux en marcha</p>
                    </div>
                </section>

                <div class="grid grid-cols-1 gap-8 xl:grid-cols-[0.95fr_1.35fr]">
                    <aside class="space-y-8">
                        <section class="gf-panel rounded-3xl p-6 backdrop-blur-2xl">
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold">Crear publicación</h3>
                                <p class="gf-text-subtle mt-1 text-sm">Publica una nueva entrada para el blog.</p>
                            </div>

                            <form @submit.prevent="submit" class="space-y-4">
                                <div>
                                    <label class="mb-2 block text-sm font-medium">Título</label>
                                    <input
                                        v-model="form.title"
                                        type="text"
                                        placeholder="Título de la publicación"
                                        class="gf-input w-full rounded-2xl px-4 py-3 transition"
                                    />
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium">Contenido</label>
                                    <textarea
                                        v-model="form.content"
                                        rows="10"
                                        placeholder="Escribe aquí tu publicación..."
                                        class="gf-input gf-input-secondary w-full resize-none rounded-2xl px-4 py-3 transition"
                                    />
                                </div>

                                <div class="flex items-center justify-between gap-3">
                                    <p v-if="form.recentlySuccessful" class="text-sm font-medium" :style="{ color: 'var(--gf-success-text)' }">
                                        Publicación enviada.
                                    </p>

                                    <button
                                        type="submit"
                                        :disabled="form.processing"
                                        class="gf-button-primary ml-auto rounded-2xl px-5 py-3 text-sm font-semibold disabled:cursor-not-allowed disabled:opacity-50"
                                    >
                                        Publicar
                                    </button>
                                </div>
                            </form>
                        </section>

                        <section class="gf-panel rounded-3xl p-6 backdrop-blur-2xl">
                            <h3 class="text-lg font-semibold">Actividad reciente</h3>
                            <p class="gf-text-subtle mt-1 text-sm">Vista rápida del contenido más reciente.</p>

                            <div v-if="posts.length" class="mt-5 space-y-3">
                                <div
                                    v-for="post in posts.slice(0, 3)"
                                    :key="post.id"
                                    class="gf-panel-strong gf-panel-hover-accent rounded-2xl p-4"
                                >
                                    <div class="flex items-center gap-3">
                                        <img
                                            :src="avatarFromUser(post.user)"
                                            alt="Avatar"
                                            class="h-10 w-10 rounded-full border object-cover"
                                            :style="{ borderColor: 'var(--gf-line)' }"
                                        />
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-semibold">
                                                {{ post.title }}
                                            </p>
                                            <p class="gf-text-subtle text-xs">
                                                por {{ firstName(post.user?.name) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-else class="gf-panel-strong gf-text-subtle mt-5 rounded-2xl border-dashed px-4 py-6 text-sm">
                                Aún no hay actividad.
                            </div>
                        </section>
                    </aside>

                    <section class="gf-panel rounded-3xl p-6 backdrop-blur-2xl">
                        <div class="mb-6 flex items-end justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-semibold">Publicaciones</h3>
                                <p class="gf-text-subtle mt-1 text-sm">Publicaciones y comentarios.</p>
                            </div>

                            <div class="gf-chip gf-chip-accent rounded-full px-4 py-2 text-xs font-semibold uppercase tracking-[0.28em]">
                                Feed
                            </div>
                        </div>

                        <div v-if="posts.length" class="space-y-5">
                            <article
                                v-for="post in posts"
                                :key="post.id"
                                class="gf-panel-strong gf-panel-hover-accent rounded-3xl p-5"
                            >
                                <div class="flex items-start gap-4">
                                    <img
                                        :src="avatarFromUser(post.user)"
                                        alt="Avatar"
                                        class="h-12 w-12 rounded-full border object-cover shrink-0"
                                        :style="{ borderColor: 'var(--gf-line)' }"
                                    />

                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-center justify-between gap-3">
                                            <div>
                                                <h4 class="text-base font-semibold">
                                                    {{ post.title }}
                                                </h4>
                                                <p class="gf-text-subtle text-xs">
                                                    por {{ firstName(post.user?.name) }}
                                                </p>
                                            </div>

                                            <span class="gf-chip rounded-full px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.22em]">
                                                #{{ post.id }}
                                            </span>
                                        </div>
                                        <button
                                            v-if="canDelete()"
                                            @click="deletePost(post.id)"
                                            class="gf-action-danger mt-2 rounded-lg px-3 py-1 text-xs font-semibold"
                                        >
                                            Eliminar
                                        </button>
                                        <p class="gf-text-muted mt-4 whitespace-pre-line text-sm leading-6">
                                            {{ post.content }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-5 border-t pt-5" :style="{ borderColor: 'var(--gf-line)' }">
                                    <PostComments :post="post" :auth="auth"/>
                                </div>
                            </article>
                        </div>

                        <div
                            v-else
                            class="gf-panel-strong rounded-3xl border-dashed px-6 py-12 text-center"
                        >
                            <p class="text-lg font-semibold">Todavía no hay publicaciones</p>
                            <p class="gf-text-subtle mt-2 text-sm">
                                Crea la primera entrada para empezar con el blog de GameFlux.
                            </p>
                        </div>
                    </section>
                </div>
            </div>
        </div>
</template>
