import axios from 'axios';
import { addPlaytime, addAchievements } from '@/state/statsStore';
import { useNotifications } from '@/state/notificationStore';

/**
* File playtimeTracker (Service)
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-04-16
* 
* This file contains all the necessary functions for the playtime tracker service.
* It is a global service that runs in the background on the front end.
*/

let interval = null;
let running = false;

export function startPlaytimeTracker() {
    if (running) return;

    running = true;

    console.log('[TRACKER] iniciado');

    interval = setInterval(async () => {
        try {
            const { data } = await axios.post('/stats/playtime', {
                minutes: 1
            });

            addPlaytime(1);

            if (data.achievements?.length) {
                addAchievements(data.achievements);

                const { showAchievement } = useNotifications();

                data.achievements.forEach((a) => {
                    showAchievement({
                        id: a.id,
                        name: a.name,
                        icon: a.icon
                    });
                });
            }

        } catch (e) {
            console.error('[TRACKER]', e);
        }
    }, 60000);
}

export function stopPlaytimeTracker() {
    if (interval) {
        clearInterval(interval);
        interval = null;
        running = false;
    }
}