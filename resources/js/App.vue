<template>
  <div class="min-h-screen flex flex-col">
    <router-view />
    <AppToast />
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import AppToast from '@/components/AppToast.vue'
import { useSettingsStore } from '@/stores/settings'

const settings = useSettingsStore()
onMounted(() => settings.load())
</script>