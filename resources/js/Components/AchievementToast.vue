<script setup lang="ts">
import { ref, watch } from 'vue'
import { usePage } from '@inertiajs/vue3'
import type { PageProps, AchievementFlash } from '@/types'

const page = usePage<PageProps>()
const visible = ref(false)
const current = ref<AchievementFlash>({ icon: '🏆', name: '', points: 0 })

let timer: ReturnType<typeof setTimeout> | null = null

watch(
  () => page.props.flash?.achievement,
  (achievement) => {
    if (!achievement) return
    current.value = achievement
    visible.value = true
    if (timer) clearTimeout(timer)
    timer = setTimeout(() => { visible.value = false }, 4000)
  }
)
</script>