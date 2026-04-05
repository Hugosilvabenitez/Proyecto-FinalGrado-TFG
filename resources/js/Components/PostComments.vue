<!--
Comments Component (View)

@author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
@date 2026-04-05

This file contains all the necessary lines for the Comment's Component.
-->

<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
});

const comments = ref(props.post.comments ? [...props.post.comments] : []);

const form = useForm({
    content: '',
    post_id: props.post.id,
});

const avatarFromUser = (user) => {
    if (user?.avatar_url) return user.avatar_url.replace('https://', 'http://');
    return 'https://api.dicebear.com/9.x/fun-emoji/svg?seed=guest&backgroundColor=1d1440&radius=50';
};

const firstName = (name) => name?.split(' ')[0] || 'Trainer';

const normalizeComment = (comment) => ({
    ...comment,
    user: comment.user || null,
});

const submit = () => {
    if (!form.content.trim()) return;

    form.post('/comments', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('content');
        },
    });
};

onMounted(() => {
    if (!props.post?.id || !window.Echo) return;

    window.Echo.channel(`post.${props.post.id}`)
        .listen('CommentCreated', (e) => {
            comments.value.push(normalizeComment(e.comment));
        });
});

onUnmounted(() => {
    if (!props.post?.id || !window.Echo) return;
    window.Echo.leaveChannel(`post.${props.post.id}`);
});

const orderedComments = computed(() => comments.value);
</script>

<template>
    <div class="mt-4 space-y-4">
        <div class="space-y-2 max-h-56 overflow-y-auto pr-1">
            <div
                v-for="comment in orderedComments"
                :key="comment.id"
                class="rounded-2xl border border-white/10 bg-slate-950/60 p-3"
            >
                <div class="flex items-start gap-3">
                    <img
                        :src="avatarFromUser(comment.user)"
                        alt="Avatar"
                        class="h-9 w-9 rounded-full border border-white/10 object-cover shrink-0"
                    />

                    <div class="min-w-0 flex-1">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-sm font-semibold text-cyan-300 truncate">
                                {{ firstName(comment.user?.name) }}
                            </p>
                        </div>

                        <p class="mt-1 text-sm text-slate-200 leading-6">
                            {{ comment.content }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <form @submit.prevent="submit" class="flex gap-2">
            <input
                v-model="form.content"
                type="text"
                placeholder="Escribe un comentario..."
                class="flex-1 rounded-2xl border border-slate-700 bg-slate-950/80 px-4 py-3 text-sm text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30"
            />

            <button
                type="submit"
                :disabled="form.processing"
                class="rounded-2xl bg-gradient-to-r from-cyan-400 via-blue-500 to-fuchsia-500 px-4 py-3 text-sm font-semibold text-white shadow-[0_0_18px_rgba(56,189,248,0.6)] transition hover:shadow-[0_0_26px_rgba(244,114,182,0.75)] disabled:cursor-not-allowed disabled:opacity-50"
            >
                Enviar
            </button>
        </form>
    </div>
</template>