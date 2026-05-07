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

let initialized = false;
let currentUserId = null;

/**
 * START THE STORE FOR THE DASHBOARD'S VIEW
 */
export function initStats(initialStats = {}, userId = null) {
    const totalMinutes = Number(initialStats?.total_minutes || 0);
    const cloudSaves = Number(initialStats?.cloud_saves || 0);
    const achievementsUnlocked = Number(initialStats?.achievements_unlocked || 0);
    const normalizedUserId = userId ? Number(userId) : null;

    if (normalizedUserId && currentUserId && currentUserId !== normalizedUserId) {
        initialized = false;
        state.recent_achievements = [];
    }

    if (!initialized) {
        state.total_minutes = totalMinutes;
        state.cloud_saves = cloudSaves;
        state.achievements_unlocked = achievementsUnlocked;
        initialized = true;
        currentUserId = normalizedUserId;
        return;
    }

    if (normalizedUserId && !currentUserId) {
        currentUserId = normalizedUserId;
    }

    state.total_minutes = Math.max(state.total_minutes, totalMinutes);
    state.cloud_saves = Math.max(state.cloud_saves, cloudSaves);
    state.achievements_unlocked = Math.max(state.achievements_unlocked, achievementsUnlocked);
}

/**
 * UPDATES SAVED GAMES COUNT FROM DASHBOARD DATA
 */
export function setCloudSaves(total = 0) {
    state.cloud_saves = Number(total || 0);
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
