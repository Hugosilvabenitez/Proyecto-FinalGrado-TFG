<script setup>
import { useNotifications } from '@/state/notificationsStore';

const { notifications } = useNotifications();
</script>

<template>
    <div class="fixed bottom-6 right-6 space-y-3 z-50">
        <div v-for="n in notifications" :key="n.id"
            class="bg-slate-900 border border-yellow-400/40 text-white px-4 py-3 rounded-xl shadow-lg animate-slide-in">

            <div class="flex items-center gap-3">
                <span class="text-2xl">{{ n.icon }}</span>
                <div>
                    <p class="text-xs text-yellow-400 uppercase">Logro desbloqueado</p>
                    <p class="font-semibold">{{ n.name }}</p>
                </div>
            </div>
        </div>
    </div>
</template>