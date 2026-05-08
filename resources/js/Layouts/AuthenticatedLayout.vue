<script setup>
import { ref, computed, onBeforeUnmount, onMounted, watch } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { startPlaytimeTracker, stopPlaytimeTracker } from '@/services/playtimeTracker';
import GlobalNotifications from '@/Components/GlobalNotifications.vue';
import { initStats } from '@/state/statsStore';


/**
* Auth Layout Tpl
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-03-18
* 
* This file contains all the code for generate the auth layout template of Gameflux's project.
*/

const page = usePage();
const showingNavigationDropdown = ref(false);

watch(
    () => page.props.auth.user?.id,
    () => {
        initStats(page.props.auth.user.stats, page.props.auth.user.id);
    },
    { immediate: true }
);

onMounted(() => {
    startPlaytimeTracker();
});

onBeforeUnmount(() => {
    stopPlaytimeTracker();
});

const avatarUrl = computed(() => page.props.auth.user.avatar_url);

const userName = computed(() =>
    page.props.auth?.user?.name?.split(' ')[0] || 'Trainer'
);

const userId = computed(() =>
    page.props.auth?.user?.id || '???'
);

const userEmail = computed(() =>
    page.props.auth?.user?.email || 'user@example.com'
);

const themePresets = computed(() =>
    page.props.ui?.theme_presets ?? {}
);

const activeThemeKey = computed(() =>
    page.props.auth?.user?.ui_theme ?? 'nebula'
);

const activeTheme = computed(() =>
    page.props.auth?.user?.ui_theme_config
        ?? themePresets.value[activeThemeKey.value]
        ?? themePresets.value.nebula
        ?? {}
);

const themeStyle = computed(() => ({
    '--gf-shell-bg': activeTheme.value.shell_background,
    '--gf-hero-bg': activeTheme.value.hero_background,
    '--gf-nav-bg': activeTheme.value.nav_background,
    '--gf-panel': activeTheme.value.panel,
    '--gf-panel-strong': activeTheme.value.panel_strong,
    '--gf-panel-soft': activeTheme.value.panel_soft,
    '--gf-input-bg': activeTheme.value.input_background,
    '--gf-line': activeTheme.value.line,
    '--gf-line-strong': activeTheme.value.line_strong,
    '--gf-text': activeTheme.value.text,
    '--gf-muted': activeTheme.value.muted,
    '--gf-subtle': activeTheme.value.subtle,
    '--gf-accent': activeTheme.value.accent,
    '--gf-accent-soft': activeTheme.value.accent_soft,
    '--gf-accent-border': activeTheme.value.accent_border,
    '--gf-accent-ring': activeTheme.value.accent_ring,
    '--gf-secondary': activeTheme.value.secondary,
    '--gf-secondary-soft': activeTheme.value.secondary_soft,
    '--gf-secondary-border': activeTheme.value.secondary_border,
    '--gf-secondary-ring': activeTheme.value.secondary_ring,
    '--gf-title-gradient': activeTheme.value.title_gradient,
    '--gf-button-gradient': activeTheme.value.button_gradient,
    '--gf-orb-primary': activeTheme.value.orb_primary,
    '--gf-orb-secondary': activeTheme.value.orb_secondary,
    '--gf-success-soft': activeTheme.value.accent_soft,
    '--gf-success-border': activeTheme.value.accent_border,
    '--gf-success-text': activeTheme.value.accent,
    '--gf-warning-soft': activeTheme.value.secondary_soft,
    '--gf-warning-border': activeTheme.value.secondary_border,
    '--gf-warning-text': activeTheme.value.secondary,
    '--gf-danger-soft': activeTheme.value.secondary_soft,
    '--gf-danger-border': activeTheme.value.secondary_border,
    '--gf-danger-text': activeTheme.value.secondary,
}));
</script>

<template>
    <div class="gf-shell min-h-screen" :style="themeStyle">
        <nav class="gf-nav-shell relative z-50 border-b backdrop-blur-xl">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex shrink-0 items-center">
                        <Link :href="route('dashboard')" class="flex items-center gap-3 group">
                            <img src="/images/logo.jpg" alt="GameFlux" class="h-10 w-10 drop-shadow-[0_0_15px_rgba(59,130,246,0.75)] group-hover:scale-110 transition-transform" @error="$event.target.src='https://via.placeholder.com/40x40/1d1440/ffffff?text=GF'"/>
                            <div>
                                <div class="gf-title-gradient text-xl font-black tracking-tight">GameFlux</div>
                                <div class="gf-text-subtle text-xs font-mono uppercase tracking-[0.3em]">GBA Emulator</div>
                            </div>
                        </Link>
                    </div>

                    <div class="hidden md:flex items-center space-x-2">
                        <NavLink :href="route('welcome')">
                            Página Inicial
                        </NavLink>
                        <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </NavLink>
                        <NavLink :href="route('play')" :active="route().current('play')">
                            Play
                        </NavLink>
                        <NavLink :href="route('blog')" :active="route().current('blog')">
                            Blog
                        </NavLink>
                        <NavLink :href="route('chat-ia')" :active="route().current('chat-ia')">
                            Chat IA
                        </NavLink>
                        <NavLink :href="route('achievements.index')" :active="route().current('achievements.index')">
                            Logros
                        </NavLink>
                        <NavLink
                            v-if="$page.props.auth.user?.roles?.some(r => r.name.toLowerCase() === 'admin')"
                            :href="route('users.index')" :active="route().current('users.index')">
                            Usuarios
                        </NavLink>
                    </div>

                    <div class="hidden md:flex items-center">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <div class="gf-avatar-trigger flex cursor-pointer items-center gap-3 rounded-2xl px-4 py-2 backdrop-blur-xl transition-all group">
                                    <img :src="avatarUrl" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-white/20 shadow-lg group-hover:shadow-[0_0_20px_rgba(59,130,246,0.6)] transition-all"/>
                                    <div class="hidden sm:block min-w-0">
                                        <div class="max-w-32 truncate text-sm font-semibold" :style="{ color: 'var(--gf-text)' }">{{ userName }}</div>
                                        <div class="gf-text-subtle max-w-32 truncate text-xs">Trainer #{{ userId }}</div>
                                    </div>
                                    <svg class="gf-avatar-arrow gf-text-subtle h-4 w-4 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-9"/>
                                    </svg>
                                </div>
                            </template>
                            <template #content>
                                <DropdownLink :href="route('profile.edit')">Mi perfil</DropdownLink>
                                <DropdownLink :href="route('logout')" method="post" as="button">Cerrar sesión</DropdownLink>
                            </template>
                        </Dropdown>
                    </div>

                    <div class="flex md:hidden">
                        <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="gf-button-secondary inline-flex items-center justify-center rounded-xl p-2 duration-200">
                            <svg class="h-6 w-6" :class="{ 'hidden': showingNavigationDropdown, 'block': !showingNavigationDropdown }" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            <svg class="h-6 w-6" :class="{ 'hidden': !showingNavigationDropdown, 'block': showingNavigationDropdown }" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div v-if="showingNavigationDropdown" class="gf-nav-shell md:hidden border-t pb-6 backdrop-blur-xl">
                <div class="px-4 pt-4 pb-2 space-y-2">
                    <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                        Dashboard
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('play')" :active="route().current('play')">
                        Play
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('blog')" :active="route().current('blog')">
                        Blog
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('chat-ia')" :active="route().current('chat-ia')">
                        Chat IA
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('achievements.index')" :active="route().current('achievements.index')">
                        Logros
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('profile.edit')" :active="route().current('profile.edit')">
                        Perfil
                    </ResponsiveNavLink>
                </div>
                <div class="border-t px-4 pb-4 pt-4 space-y-2" :style="{ borderColor: 'var(--gf-line)' }">
                    <div class="px-4 py-3">
                        <div class="text-sm font-semibold" :style="{ color: 'var(--gf-text)' }">{{ userName }}</div>
                        <div class="gf-text-subtle text-xs">{{ userEmail }}</div>
                    </div>
                    <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                        Cerrar sesión
                    </ResponsiveNavLink>
                </div>
            </div>
        </nav>

        <main class="min-h-[calc(100vh-4rem)] overflow-y-auto">
            <slot />
        </main>

        <GlobalNotifications />
    </div>
</template>
