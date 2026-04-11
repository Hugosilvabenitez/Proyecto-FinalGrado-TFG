<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import AchievementToast from '@/Components/AchievementToast.vue'

defineProps<{
    canLogin: boolean
    canRegister: boolean
}>()
</script>

<template>
    <Head title="GameFlux · Emulador online" />
    <AchievementToast />

    <div class="min-h-screen bg-slate-950 text-slate-100 relative overflow-x-hidden">

        <!-- Fondo animado -->
        <div class="pointer-events-none fixed inset-0 z-0">
            <div class="absolute -top-32 -left-24 h-96 w-96 bg-gradient-to-br from-cyan-500 via-blue-500 to-purple-600 opacity-30 blur-3xl animate-pulse"/>
            <div class="absolute -bottom-40 -right-20 h-96 w-96 bg-gradient-to-tr from-fuchsia-500 via-orange-400 to-yellow-300 opacity-30 blur-3xl animate-pulse" style="animation-delay:1.5s"/>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 h-[600px] w-[600px] bg-gradient-to-br from-violet-600/10 to-cyan-500/10 blur-3xl"/>
        </div>
        <div class="pointer-events-none fixed inset-0 z-0 opacity-20 mix-blend-soft-light" style="background-image:url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2240%22 height=%2240%22 viewBox=%220 0 40 40%22><rect width=%221%22 height=%221%22 fill=%22%23ffffff%22 opacity=%220.12%22/></svg>');"></div>

        <!-- Navbar -->
        <nav class="relative z-10 flex items-center justify-between px-8 py-4 border-b border-white/10 backdrop-blur-2xl bg-slate-950/60 sticky top-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-cyan-400 via-blue-500 to-fuchsia-500 rounded-2xl flex items-center justify-center shadow-[0_0_20px_rgba(56,189,248,0.5)]">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <rect x="2" y="7" width="16" height="9" rx="2.5" stroke="#fff" stroke-width="1.2"/>
                        <path d="M6 11.5H8M7 10.5V12.5" stroke="#fff" stroke-width="1.2" stroke-linecap="round"/>
                        <circle cx="12" cy="11.5" r="0.8" fill="#fff"/>
                        <circle cx="14" cy="11.5" r="0.8" fill="#fff"/>
                        <path d="M7 7V5.5C7 4.67 7.67 4 8.5 4H11.5C12.33 4 13 4.67 13 5.5V7" stroke="#fff" stroke-width="1.2"/>
                    </svg>
                </div>
                <span class="text-lg font-semibold tracking-tight">Game<span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-fuchsia-400">Flux</span></span>
            </div>
            <div class="hidden sm:flex items-center gap-1">
                <Link :href="route('chat-ia')" class="text-sm text-slate-400 hover:text-slate-100 px-4 py-2 rounded-xl hover:bg-white/5 transition-all duration-200 no-underline">Chat IA</Link>
                <template v-if="canLogin">
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-sm text-slate-400 hover:text-slate-100 px-4 py-2 rounded-xl hover:bg-white/5 transition-all duration-200 no-underline">Mi perfil</Link>
                    <template v-else>
                        <Link :href="route('login')" class="text-sm text-slate-400 hover:text-slate-100 px-4 py-2 rounded-xl hover:bg-white/5 transition-all duration-200 no-underline">Iniciar sesión</Link>
                        <Link v-if="canRegister" :href="route('register')" class="text-sm text-white font-semibold px-5 py-2 rounded-xl bg-gradient-to-r from-cyan-400 via-blue-500 to-fuchsia-500 shadow-[0_0_20px_rgba(56,189,248,0.5)] hover:shadow-[0_0_30px_rgba(244,114,182,0.7)] hover:scale-[1.02] transition-all duration-200 no-underline">
                            Registrarse
                        </Link>
                    </template>
                </template>
            </div>
        </nav>

        <!-- HERO PRINCIPAL -->
        <section class="relative z-10 flex flex-col items-center text-center px-6 pt-28 pb-24">
            <div class="inline-flex items-center gap-2 text-xs text-emerald-400 bg-emerald-500/10 border border-emerald-500/25 px-4 py-1.5 rounded-full mb-10 tracking-widest uppercase">
                <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                GameFlux · Emulador online 
            </div>

            <h1 class="text-5xl sm:text-7xl font-semibold leading-tight mb-6 tracking-tight max-w-4xl">
                El emulador que<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-blue-400 to-fuchsia-500">
                    aprende contigo.
                </span>
            </h1>

            <p class="text-lg text-slate-400 max-w-xl leading-relaxed mb-12">
                Juega a clásicos directamente en el navegador. GameFlux analiza tus gustos con IA y te recomienda el siguiente juego perfecto para ti.
            </p>

            <div class="flex gap-4 flex-wrap justify-center mb-20">
                <Link v-if="canRegister" :href="route('register')" class="group flex items-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-r from-cyan-400 via-blue-500 to-fuchsia-500 text-white font-semibold text-sm shadow-[0_0_30px_rgba(56,189,248,0.7)] hover:shadow-[0_0_50px_rgba(244,114,182,0.8)] hover:scale-[1.03] transition-all duration-300 no-underline">
                    Empieza gratis
                    <span class="group-hover:translate-x-1 transition-transform duration-200">→</span>
                </Link>
                <Link :href="route('chat-ia')" class="flex items-center gap-2 px-8 py-4 rounded-2xl border border-white/10 bg-white/5 backdrop-blur-2xl text-slate-300 hover:border-cyan-400/50 hover:text-cyan-300 hover:shadow-[0_0_25px_rgba(56,189,248,0.3)] transition-all duration-300 no-underline text-sm font-medium">
                    Probar el chat IA
                </Link>
            </div>

            <!-- Hero visual: mockup de consola -->
            <div class="relative w-full max-w-2xl mx-auto">
                <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl shadow-[0_0_80px_rgba(56,189,248,0.15)] p-6 sm:p-8">
                    <!-- Barra superior mockup -->
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-3 h-3 rounded-full bg-red-500/60"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-500/60"></div>
                        <div class="w-3 h-3 rounded-full bg-green-500/60"></div>
                        <div class="flex-1 mx-4 h-7 bg-slate-800/80 rounded-lg flex items-center px-3">
                            <span class="text-xs text-slate-500">gameflux.app/play</span>
                        </div>
                    </div>
                    <!-- Pantalla emulador simulada -->
                    <div class="relative rounded-2xl bg-slate-900 border border-white/5 overflow-hidden" style="aspect-ratio:16/9;">
                        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 flex items-center justify-center">
                            <div class="text-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-cyan-400 via-blue-500 to-fuchsia-500 rounded-3xl flex items-center justify-center mx-auto mb-4 shadow-[0_0_40px_rgba(56,189,248,0.6)] animate-pulse">
                                    <svg width="36" height="36" viewBox="0 0 20 20" fill="none">
                                        <rect x="2" y="7" width="16" height="9" rx="2.5" stroke="#fff" stroke-width="1.2"/>
                                        <path d="M6 11.5H8M7 10.5V12.5" stroke="#fff" stroke-width="1.2" stroke-linecap="round"/>
                                        <circle cx="12" cy="11.5" r="0.8" fill="#fff"/>
                                        <circle cx="14" cy="11.5" r="0.8" fill="#fff"/>
                                        <path d="M7 7V5.5C7 4.67 7.67 4 8.5 4H11.5C12.33 4 13 4.67 13 5.5V7" stroke="#fff" stroke-width="1.2"/>
                                    </svg>
                                </div>
                                <p class="text-slate-400 text-sm">Selecciona un juego para empezar</p>
                                <p class="text-slate-600 text-xs mt-1">+100 títulos disponibles</p>
                            </div>
                        </div>
                        <!-- Partículas decorativas -->
                        <div class="absolute top-4 left-4 w-2 h-2 rounded-full bg-cyan-400/40 animate-ping" style="animation-duration:2s"></div>
                        <div class="absolute top-8 right-8 w-1.5 h-1.5 rounded-full bg-fuchsia-400/40 animate-ping" style="animation-duration:3s"></div>
                        <div class="absolute bottom-6 left-12 w-1 h-1 rounded-full bg-blue-400/40 animate-ping" style="animation-duration:2.5s"></div>
                    </div>
                    <!-- Controles mockup -->
                    <div class="flex items-center justify-between mt-4 px-2">
                        <div class="flex gap-2">
                            <div class="w-8 h-8 rounded-xl bg-slate-800 border border-white/5 flex items-center justify-center">
                                <span class="text-xs text-slate-500">L</span>
                            </div>
                            <div class="w-8 h-8 rounded-xl bg-slate-800 border border-white/5 flex items-center justify-center">
                                <span class="text-xs text-slate-500">R</span>
                            </div>
                        </div>
                        <div class="flex gap-1">
                            <div class="w-2 h-2 rounded-full bg-cyan-400/50"></div>
                            <div class="w-2 h-2 rounded-full bg-fuchsia-400/50"></div>
                            <div class="w-2 h-2 rounded-full bg-blue-400/50"></div>
                        </div>
                        <div class="flex gap-2">
                            <div class="w-8 h-8 rounded-xl bg-slate-800 border border-white/5 flex items-center justify-center">
                                <span class="text-xs text-slate-500">A</span>
                            </div>
                            <div class="w-8 h-8 rounded-xl bg-slate-800 border border-white/5 flex items-center justify-center">
                                <span class="text-xs text-slate-500">B</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Glow bajo el mockup -->
                <div class="absolute -bottom-8 left-1/2 -translate-x-1/2 w-3/4 h-16 bg-cyan-500/20 blur-2xl rounded-full"></div>
            </div>
        </section>

        <!-- STATS -->
        <section class="relative z-10 px-8 pb-24 max-w-4xl mx-auto">
            <div class="grid grid-cols-3 gap-4">
                <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl p-6 text-center transition duration-500 hover:border-cyan-400/40 hover:shadow-[0_0_40px_rgba(56,189,248,0.3)] hover:-translate-y-1">
                    <div class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500 mb-2">+100</div>
                    <div class="text-xs text-slate-500 uppercase tracking-widest">Juegos disponibles</div>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl p-6 text-center transition duration-500 hover:border-fuchsia-400/40 hover:shadow-[0_0_40px_rgba(244,114,182,0.3)] hover:-translate-y-1">
                    <div class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-400 to-purple-500 mb-2">IA</div>
                    <div class="text-xs text-slate-500 uppercase tracking-widest">Recomendaciones</div>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl p-6 text-center transition duration-500 hover:border-orange-400/40 hover:shadow-[0_0_40px_rgba(251,146,60,0.3)] hover:-translate-y-1">
                    <div class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-500 mb-2">+20</div>
                    <div class="text-xs text-slate-500 uppercase tracking-widest">Logros únicos</div>
                </div>
            </div>
        </section>

        <!-- CARACTERÍSTICAS -->
        <section class="relative z-10 px-8 pb-24 max-w-6xl mx-auto">
            <div class="h-px bg-gradient-to-r from-transparent via-white/10 to-transparent mb-16"></div>
            <div class="text-center mb-12">
                <p class="text-xs text-slate-500 tracking-widest uppercase mb-3">Qué ofrece GameFlux</p>
                <h2 class="text-3xl font-semibold tracking-tight">Todo lo que necesitas<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-fuchsia-500">en un solo lugar.</span></h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

                <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl p-7 transition duration-500 hover:border-cyan-400/60 hover:shadow-[0_0_40px_rgba(56,189,248,0.4)] hover:-translate-y-1 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-cyan-400 to-blue-600 rounded-2xl flex items-center justify-center mb-5 shadow-[0_0_15px_rgba(56,189,248,0.5)] group-hover:shadow-[0_0_25px_rgba(56,189,248,0.8)] transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/></svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-100 mb-2">Emulador en el navegador</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Juega a tus clásicos favoritos sin instalar nada. Compatible con múltiples plataformas retro.</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl p-7 transition duration-500 hover:border-fuchsia-400/60 hover:shadow-[0_0_40px_rgba(244,114,182,0.4)] hover:-translate-y-1 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-fuchsia-500 to-purple-600 rounded-2xl flex items-center justify-center mb-5 shadow-[0_0_15px_rgba(168,85,247,0.5)] group-hover:shadow-[0_0_25px_rgba(168,85,247,0.8)] transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-100 mb-2">Chat IA de recomendación</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Habla con nuestra IA. Te hace preguntas sobre tus gustos y te recomienda el juego perfecto de nuestra biblioteca.</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl p-7 transition duration-500 hover:border-emerald-400/60 hover:shadow-[0_0_40px_rgba(16,185,129,0.4)] hover:-translate-y-1 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-600 rounded-2xl flex items-center justify-center mb-5 shadow-[0_0_15px_rgba(16,185,129,0.5)] group-hover:shadow-[0_0_25px_rgba(16,185,129,0.8)] transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-100 mb-2">Sistema de logros</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Desbloquea logros automáticamente según tu tiempo de juego, partidas completadas y puntuaciones.</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl p-7 transition duration-500 hover:border-orange-400/60 hover:shadow-[0_0_40px_rgba(251,146,60,0.4)] hover:-translate-y-1 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center mb-5 shadow-[0_0_15px_rgba(251,191,36,0.5)] group-hover:shadow-[0_0_25px_rgba(251,191,36,0.8)] transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-100 mb-2">Perfil de jugador</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Tu historial de partidas, estadísticas de juego y colección de logros siempre disponibles en tu perfil.</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl p-7 transition duration-500 hover:border-blue-400/60 hover:shadow-[0_0_40px_rgba(96,165,250,0.4)] hover:-translate-y-1 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-violet-600 rounded-2xl flex items-center justify-center mb-5 shadow-[0_0_15px_rgba(96,165,250,0.5)] group-hover:shadow-[0_0_25px_rgba(96,165,250,0.8)] transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z"/></svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-100 mb-2">Guardado en la nube</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Guarda el estado de tus partidas y continúa desde donde lo dejaste en cualquier dispositivo.</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl p-7 transition duration-500 hover:border-pink-400/60 hover:shadow-[0_0_40px_rgba(244,114,182,0.4)] hover:-translate-y-1 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-pink-400 to-rose-600 rounded-2xl flex items-center justify-center mb-5 shadow-[0_0_15px_rgba(244,114,182,0.5)] group-hover:shadow-[0_0_25px_rgba(244,114,182,0.8)] transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/></svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-100 mb-2">Acceso instantáneo</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Sin descargas ni configuraciones. Entra, elige tu juego y empieza a jugar en segundos.</p>
                </div>

            </div>
        </section>

        <!-- CÓMO FUNCIONA -->
        <section class="relative z-10 px-8 pb-24 max-w-4xl mx-auto">
            <div class="h-px bg-gradient-to-r from-transparent via-white/10 to-transparent mb-16"></div>
            <div class="text-center mb-12">
                <p class="text-xs text-slate-500 tracking-widest uppercase mb-3">Simple y rápido</p>
                <h2 class="text-3xl font-semibold tracking-tight">Empieza a jugar<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-fuchsia-500">en tres pasos.</span></h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-cyan-400 via-blue-500 to-fuchsia-500 rounded-3xl flex items-center justify-center mx-auto mb-5 shadow-[0_0_25px_rgba(56,189,248,0.5)] group-hover:shadow-[0_0_40px_rgba(56,189,248,0.7)] transition-shadow text-2xl font-bold text-white">1</div>
                    <h3 class="text-base font-semibold text-slate-100 mb-2">Crea tu cuenta</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Regístrate gratis en segundos. Solo necesitas un correo.</p>
                </div>
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-fuchsia-500 via-purple-500 to-blue-500 rounded-3xl flex items-center justify-center mx-auto mb-5 shadow-[0_0_25px_rgba(168,85,247,0.5)] group-hover:shadow-[0_0_40px_rgba(168,85,247,0.7)] transition-shadow text-2xl font-bold text-white">2</div>
                    <h3 class="text-base font-semibold text-slate-100 mb-2">Elige o descubre</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Explora el catálogo o deja que la IA te recomiende el juego ideal.</p>
                </div>
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-400 via-yellow-400 to-green-400 rounded-3xl flex items-center justify-center mx-auto mb-5 shadow-[0_0_25px_rgba(251,191,36,0.5)] group-hover:shadow-[0_0_40px_rgba(251,191,36,0.7)] transition-shadow text-2xl font-bold text-white">3</div>
                    <h3 class="text-base font-semibold text-slate-100 mb-2">Juega y desbloquea</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Juega directamente en el navegador y gana logros automáticamente.</p>
                </div>
            </div>
        </section>

        <!-- CTA FINAL -->
        <section class="relative z-10 px-8 pb-28 max-w-4xl mx-auto">
            <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl shadow-[0_0_80px_rgba(56,189,248,0.1)] p-12 text-center relative overflow-hidden">
                <div class="absolute -top-20 -left-20 h-64 w-64 bg-gradient-to-br from-cyan-500/20 to-blue-500/10 blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-20 -right-20 h-64 w-64 bg-gradient-to-tl from-fuchsia-500/20 to-purple-500/10 blur-3xl pointer-events-none"></div>
                <div class="relative z-10">
                    <p class="text-xs text-slate-500 tracking-widest uppercase mb-4">¿A qué esperas?</p>
                    <h2 class="text-3xl sm:text-4xl font-semibold tracking-tight mb-4">
                        Tu próximo juego favorito<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-blue-400 to-fuchsia-500">te está esperando.</span>
                    </h2>
                    <p class="text-slate-400 max-w-md mx-auto mb-10 text-sm leading-relaxed">
                        Únete a GameFlux, descubre juegos increíbles con ayuda de la IA y compite por desbloquear todos los logros.
                    </p>
                    <div class="flex gap-4 justify-center flex-wrap">
                        <Link v-if="canRegister" :href="route('register')" class="group flex items-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-r from-cyan-400 via-blue-500 to-fuchsia-500 text-white font-semibold text-sm shadow-[0_0_30px_rgba(56,189,248,0.6)] hover:shadow-[0_0_50px_rgba(244,114,182,0.8)] hover:scale-[1.03] transition-all duration-300 no-underline">
                            Crear cuenta gratis
                            <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </Link>
                        <Link :href="route('login')" class="flex items-center px-8 py-4 rounded-2xl border border-white/10 bg-white/5 text-slate-300 hover:border-cyan-400/50 hover:text-cyan-300 hover:shadow-[0_0_25px_rgba(56,189,248,0.3)] transition-all duration-300 no-underline text-sm font-medium">
                            Ya tengo cuenta
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Acceso rápido -->
        <section class="relative z-10 px-8 pb-20 max-w-6xl mx-auto">
            <div class="h-px bg-gradient-to-r from-transparent via-white/10 to-transparent mb-10"></div>
            <p class="text-xs text-slate-500 tracking-widest uppercase mb-5">Acceso rápido</p>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                <Link :href="route('login')" class="group rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl p-5 no-underline transition duration-500 hover:border-fuchsia-400/60 hover:shadow-[0_0_30px_rgba(244,114,182,0.3)] hover:-translate-y-0.5 flex flex-col gap-3">
                    <div class="w-2.5 h-2.5 rounded-full bg-gradient-to-r from-fuchsia-400 to-pink-500 group-hover:shadow-[0_0_10px_rgba(244,114,182,0.9)] transition-shadow"></div>
                    <div class="text-sm font-semibold text-slate-200">Iniciar sesión</div>
                    <div class="text-xs text-slate-500">Accede a tu cuenta</div>
                </Link>
                <Link v-if="canRegister" :href="route('register')" class="group rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl p-5 no-underline transition duration-500 hover:border-cyan-400/60 hover:shadow-[0_0_30px_rgba(56,189,248,0.3)] hover:-translate-y-0.5 flex flex-col gap-3">
                    <div class="w-2.5 h-2.5 rounded-full bg-gradient-to-r from-cyan-400 to-blue-500 group-hover:shadow-[0_0_10px_rgba(56,189,248,0.9)] transition-shadow"></div>
                    <div class="text-sm font-semibold text-slate-200">Registrarse</div>
                    <div class="text-xs text-slate-500">Crea tu cuenta</div>
                </Link>
                <Link :href="route('chat-ia')" class="group rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl p-5 no-underline transition duration-500 hover:border-orange-400/60 hover:shadow-[0_0_30px_rgba(251,146,60,0.3)] hover:-translate-y-0.5 flex flex-col gap-3">
                    <div class="w-2.5 h-2.5 rounded-full bg-gradient-to-r from-yellow-400 to-orange-500 group-hover:shadow-[0_0_10px_rgba(251,191,36,0.9)] transition-shadow"></div>
                    <div class="text-sm font-semibold text-slate-200">Chat IA</div>
                    <div class="text-xs text-slate-500">Recomendaciones</div>
                </Link>
                <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="group rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl p-5 no-underline transition duration-500 hover:border-blue-400/60 hover:shadow-[0_0_30px_rgba(96,165,250,0.3)] hover:-translate-y-0.5 flex flex-col gap-3">
                    <div class="w-2.5 h-2.5 rounded-full bg-gradient-to-r from-blue-400 to-violet-500 group-hover:shadow-[0_0_10px_rgba(96,165,250,0.9)] transition-shadow"></div>
                    <div class="text-sm font-semibold text-slate-200">Mi perfil</div>
                    <div class="text-xs text-slate-500">Estadísticas</div>
                </Link>
                <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="group rounded-3xl border border-white/10 bg-white/5 backdrop-blur-2xl p-5 no-underline transition duration-500 hover:border-emerald-400/60 hover:shadow-[0_0_30px_rgba(16,185,129,0.3)] hover:-translate-y-0.5 flex flex-col gap-3">
                    <div class="w-2.5 h-2.5 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 group-hover:shadow-[0_0_10px_rgba(16,185,129,0.9)] transition-shadow"></div>
                    <div class="text-sm font-semibold text-slate-200">Mis logros</div>
                    <div class="text-xs text-slate-500">Ver progreso</div>
                </Link>
            </div>
        </section>

        <!-- Footer -->
        <footer class="relative z-10 px-8 py-6 border-t border-white/5 flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-3">
                <div class="w-7 h-7 bg-gradient-to-br from-cyan-400 via-blue-500 to-fuchsia-500 rounded-lg flex items-center justify-center">
                    <svg width="14" height="14" viewBox="0 0 20 20" fill="none">
                        <rect x="2" y="7" width="16" height="9" rx="2.5" stroke="#fff" stroke-width="1.4"/>
                        <path d="M6 11.5H8M7 10.5V12.5" stroke="#fff" stroke-width="1.4" stroke-linecap="round"/>
                        <circle cx="12" cy="11.5" r="0.8" fill="#fff"/>
                        <circle cx="14" cy="11.5" r="0.8" fill="#fff"/>
                    </svg>
                </div>
                <span class="text-xs text-slate-500">GameFlux · TFG 2º DAW · 2026</span>
            </div>
            <span class="text-xs text-slate-600">Desarrollado con Laravel + Vue + IA</span>
        </footer>

    </div>
</template>