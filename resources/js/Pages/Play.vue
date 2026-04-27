<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineOptions({
  layout: AuthenticatedLayout,
});
</script>

<template>
  <Head title="Play" />

  <div class="min-h-screen bg-slate-950 px-4 py-8 text-slate-100 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-5xl">
      <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight">Emulador GBA</h1>
        <p class="mt-2 text-sm text-slate-400">
          Esta vista usa el emulador original de `gbajs2`, que es bastante más estable para cargar ROMs `.gba`
          y archivos de guardado.
        </p>
      </div>

      <div class="overflow-hidden rounded-2xl border border-white/10 bg-slate-900/70 shadow-[0_0_30px_rgba(15,23,42,0.7)] backdrop-blur">
        <iframe
          src="/emulator/gbajs2/index.html"
          title="Emulador GBA"
          class="block h-[820px] w-full bg-black"
        ></iframe>
      </div>
    </div>
  </div>
</template>
