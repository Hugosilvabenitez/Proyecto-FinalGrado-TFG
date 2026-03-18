<script setup>
import { ref, computed } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';

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

const avatarUrl = computed(() => {
    const user = page.props.auth?.user;
    
    if (user.avatar_url) {
        return user.avatar_url.replace('https://', 'http://');
    }
});

const userName = computed(() => page.props.auth?.user?.name?.split(' ')[0] || 'Trainer');
const userId = computed(() => page.props.auth?.user?.id || '???');
const userEmail = computed(() => page.props.auth?.user?.email || 'user@example.com');
</script>

<template>
    <div class="min-h-screen bg-slate-950 text-slate-100">
        <nav class="relative z-50 border-b border-white/10 bg-slate-900/95 backdrop-blur-xl shadow-[0_0_20px_rgba(15,23,42,0.9)]">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex shrink-0 items-center">
                        <Link :href="route('dashboard')" class="flex items-center gap-3 group">
                            <img src="/images/logo.jpg" alt="GameFlux" class="h-10 w-10 drop-shadow-[0_0_15px_rgba(59,130,246,0.75)] group-hover:scale-110 transition-transform" @error="$event.target.src='https://via.placeholder.com/40x40/1d1440/ffffff?text=GF'"/>
                            <div>
                                <div class="text-xl font-black bg-gradient-to-r from-cyan-400 via-blue-400 to-fuchsia-500 bg-clip-text text-transparent tracking-tight">GameFlux</div>
                                <div class="text-xs uppercase tracking-[0.3em] text-slate-400 font-mono">GBA Emulator</div>
                            </div>
                        </Link>
                    </div>

                    <div class="hidden md:flex items-center space-x-2">
                        <NavLink :href="route('dashboard')" :active="route().current('dashboard')" class="px-4 py-2 rounded-xl text-sm font-semibold text-slate-300 hover:bg-white/10 hover:text-cyan-300 transition-all">
                            Dashboard
                        </NavLink>
                    </div>

                    <div class="hidden md:flex items-center">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <div class="flex items-center gap-3 px-4 py-2 rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl hover:border-cyan-400/50 hover:shadow-[0_0_15px_rgba(56,189,248,0.3)] transition-all cursor-pointer group">
                                    <img :src="avatarUrl" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-white/20 shadow-lg group-hover:shadow-[0_0_20px_rgba(59,130,246,0.6)] transition-all"/>
                                    <div class="hidden sm:block min-w-0">
                                        <div class="text-sm font-semibold text-slate-200 truncate max-w-32">{{ userName }}</div>
                                        <div class="text-xs text-slate-400 truncate max-w-32">Trainer #{{ userId }}</div>
                                    </div>
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-cyan-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-9"/>
                                    </svg>
                                </div>
                            </template>
                            <template #content>
                                <DropdownLink :href="route('profile.edit')" class="px-4 py-2 text-sm text-slate-200 hover:bg-slate-800/50 hover:text-cyan-300">Mi perfil</DropdownLink>
                                <DropdownLink :href="route('logout')" method="post" as="button" class="px-4 py-2 text-sm text-slate-200 hover:bg-slate-800/50 hover:text-fuchsia-300">Cerrar sesión</DropdownLink>
                            </template>
                        </Dropdown>
                    </div>

                    <div class="flex md:hidden">
                        <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:bg-white/10 hover:text-cyan-300 transition-all duration-200">
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

            <div v-if="showingNavigationDropdown" class="md:hidden pb-6 border-t border-white/10 bg-slate-900/95 backdrop-blur-xl">
                <div class="px-4 pt-4 pb-2 space-y-2">
                    <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')" class="block w-full px-4 py-3 rounded-xl text-sm font-semibold text-slate-200 hover:bg-white/10 hover:text-cyan-300 transition-all">
                        Dashboard
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('profile.edit')" class="block w-full px-4 py-3 rounded-xl text-sm font-semibold text-slate-200 hover:bg-white/10 hover:text-cyan-300 transition-all">
                        Perfil
                    </ResponsiveNavLink>
                </div>
                <div class="px-4 pb-4 space-y-2 border-t border-white/10 pt-4">
                    <div class="px-4 py-3">
                        <div class="text-sm font-semibold text-slate-200">{{ userName }}</div>
                        <div class="text-xs text-slate-400">{{ userEmail }}</div>
                    </div>
                    <ResponsiveNavLink :href="route('logout')" method="post" as="button" class="block w-full px-4 py-3 rounded-xl text-sm font-semibold text-slate-200 hover:bg-white/10 hover:text-fuchsia-300 transition-all">
                        Cerrar sesión
                    </ResponsiveNavLink>
                </div>
            </div>
        </nav>

        <main class="min-h-[calc(100vh-4rem)]">
            <slot />
        </main>
    </div>
</template>
