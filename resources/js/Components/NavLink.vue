<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'gf-nav-link gf-nav-link-active inline-flex items-center rounded-xl px-4 py-2 text-sm font-semibold leading-5 focus:outline-none'
        : 'gf-nav-link inline-flex items-center rounded-xl px-4 py-2 text-sm font-semibold leading-5 focus:outline-none',
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
