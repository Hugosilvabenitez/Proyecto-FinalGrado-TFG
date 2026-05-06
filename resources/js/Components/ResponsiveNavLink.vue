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
        ? 'gf-mobile-nav-link gf-mobile-nav-link-active block w-full rounded-xl px-4 py-3 text-start text-sm font-semibold focus:outline-none'
        : 'gf-mobile-nav-link block w-full rounded-xl px-4 py-3 text-start text-sm font-semibold focus:outline-none',
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
