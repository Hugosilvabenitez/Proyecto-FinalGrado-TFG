import { onMounted, onUnmounted } from 'vue';
import axios from 'axios';
import { useNotifications } from '@/state/notificationsStore';
import { useStats } from '@/state/statsStore';

/** 
 * File PlaytimeTracker (Utility)
 * 
 * @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
 * @date 2026-03-30 
 *
 * This files controls user's stats in all project, not only on dashboard area. 
*/

let interval = null;
let isTracking = false;

export function usePlaytimeTracker() {

    const { showAchievement } = useNotifications();
    const stats = useStats();

    const startTracking = () => {
        if (isTracking) return;

        isTracking = true;

        interval = setInterval(async () => {
            try {
                const response = await axios.post('/stats/playtime', {
                    minutes: 1
                });

                stats.total_minutes += 1;

                if (response.data?.achievements) {
                    response.data.achievements.forEach(showAchievement);
                    stats.achievements_unlocked += response.data.achievements.length;
                }

            } catch (error) {
                console.error(error);
            }
        }, 60000);
    };

    const stopTracking = () => {
        if (interval) {
            clearInterval(interval);
            interval = null;
            isTracking = false;
        }
    };

    onMounted(startTracking);
    onUnmounted(stopTracking);
}