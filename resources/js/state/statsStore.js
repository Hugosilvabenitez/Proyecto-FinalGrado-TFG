import { reactive } from 'vue';

const state = reactive({
    total_minutes: 0,
    cloud_saves: 0,
    achievements_unlocked: 0,
});

export function useStats() {
    return state;
}