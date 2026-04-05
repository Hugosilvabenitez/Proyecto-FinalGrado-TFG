// resources/js/types/index.ts
export * from './auth';

export interface AchievementFlash {
    name: string
    icon: string
    points: number
}

export interface PageProps {
    name: string
    auth: Auth
    flash: {
        achievement: AchievementFlash | null
    }
    [key: string]: unknown
}