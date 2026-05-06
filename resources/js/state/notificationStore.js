import { reactive } from 'vue';

/**
* File notificationStore (States)
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-04-16
* 
* This file contains all the necessary functions for the global notifications system.
*/

const state = reactive({
    notifications: []
});

export function useNotifications() {

    const showAchievement = (achievement) => {
        const id = Date.now() + Math.random();

        state.notifications.push({
            id,
            type: 'achievement',
            icon: achievement.icon,
            name: achievement.name,
            removing: false
        });

        setTimeout(() => {
            const notif = state.notifications.find(n => n.id === id);
            if (!notif) return;

            notif.removing = true;

            setTimeout(() => {
                const index = state.notifications.findIndex(n => n.id === id);
                if (index !== -1) {
                    state.notifications.splice(index, 1);
                }
            }, 2000);
        }, 8000);
    };

    return {
        notifications: state.notifications,
        showAchievement
    };
}