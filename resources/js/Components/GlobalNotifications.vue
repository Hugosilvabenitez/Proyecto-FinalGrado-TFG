<script setup>
import { useNotifications } from '@/state/notificationStore';

/**
* GlobalNotifications View
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-04-16
* 
* This file contains all the necessary code for global notifications system.
* statsStore → User's data
* notificationStore → Visual events
* playtimeTracker → Connection between backend & frontend
* GlobalNotifications → User's notification
*/

const { notifications } = useNotifications();
</script>

<template>
    <div class="fixed bottom-6 right-6 space-y-3 z-50">
        <div v-for="n in notifications" :key="n.id" class="bg-slate-900 border border-yellow-400/40 text-white px-4 py-3 rounded-xl shadow-lg mb-3 transition-all duration-300 ease-out" :class="n.removing ? 'opacity-0 translate-x-6 scale-95' : 'opacity-100 translate-x-0 scale-100 animate-slide-in'">
            <div class="flex items-center gap-3">
                <span class="text-2xl">{{ n.icon }}</span>
                <div>
                    <p class="text-xs text-yellow-400 uppercase">
                        Logro desbloqueado
                    </p>
                    <p class="font-semibold">
                        {{ n.name }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>