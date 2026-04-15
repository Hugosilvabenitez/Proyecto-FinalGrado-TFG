import { reactive } from 'vue';

const state = reactive({
    notifications: []
});

export function useNotifications() {

    const showAchievement = (achievement) => {
        const id = crypto.randomUUID();

        const notification = {
            id,
            ...achievement
        };

        state.notifications.push(notification);

        setTimeout(() => {
            const index = state.notifications.findIndex(n => n.id === id);

            if (index !== -1) {
                state.notifications.splice(index, 1);
            }
        }, 4000);
    };

    return {
        notifications: state.notifications,
        showAchievement
    };
}