import { reactive } from 'vue';

/**
* File statsStore (States)
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-04-16
* 
* This file contains all the necessary functions for the User's stats features.
* This is the overall status of the user's statistics in memory (frontend).
*/

const state = reactive({
    total_minutes: 0,
    cloud_saves: 0,
    achievements_unlocked: 0,

    recent_achievements: [],
});

/**
 * START THE STORE FOR THE DASHBOARD'S VIEW
 */
export function initStats(initialStats = {}) {
    state.total_minutes = initialStats.total_minutes || 0;
    state.cloud_saves = initialStats.cloud_saves || 0;
    state.achievements_unlocked = initialStats.achievements_unlocked || 0;
}

/**
 * GETTER
 */
export function useStats() {
    return state;
}

/**
 * INCREMENT'S THE PLAYED TIME
 */
export function addPlaytime(minutes = 1) {
    state.total_minutes += minutes;
}

/**
 * INCREMENT'S THE GAME'S THAT HAVE BEEN PLAYED BY THE USER
 */
export function addCloudSave() {
    state.cloud_saves += 1;
}

/**
 * ADDS UNLOCKED ACHIEVEMENTS
 */
export function addAchievements(achievements = []) {
    state.achievements_unlocked += achievements.length;

    state.recent_achievements.push(
        ...achievements.map(a => ({
            id: a.id,
            name: a.name,
            icon: a.icon,
        }))
    );
}

/**
 * CLEARS RECENT NOTIFICATIONS
 */
export function clearRecentAchievements() {
    state.recent_achievements = [];
}