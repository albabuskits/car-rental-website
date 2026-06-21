<template>
  <Teleport to="body">
    <div class="fixed top-4 left-1/2 -translate-x-1/2 z-[9999] flex flex-col gap-2 w-full max-w-sm px-gutter">
      <TransitionGroup name="toast">
        <div v-for="toast in toasts" :key="toast.id"
          class="flex items-center gap-3 px-lg py-md rounded-xl shadow-lg border backdrop-blur-sm transition-all"
          :class="toastClass(toast.type)">
          <span class="material-symbols-outlined text-xl">{{ toastIcon(toast.type) }}</span>
          <p class="font-label-md text-label-md flex-1">{{ toast.message }}</p>
          <button @click="dismiss(toast.id)" class="opacity-60 hover:opacity-100 transition-opacity">
            <span class="material-symbols-outlined text-lg">close</span>
          </button>
        </div>
      </TransitionGroup>
    </div>
  </Teleport>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const toasts = ref([])
let nextId = 0
let listeners = []

function addToast(message, type = 'success', duration = 4000) {
  const id = ++nextId
  toasts.value.push({ id, message, type })
  if (duration > 0) {
    setTimeout(() => dismiss(id), duration)
  }
}

function dismiss(id) {
  toasts.value = toasts.value.filter(t => t.id !== id)
}

function toastClass(type) {
  const map = {
    success: 'bg-green-50 border-green-200 text-green-800',
    error: 'bg-red-50 border-red-200 text-red-800',
    info: 'bg-blue-50 border-blue-200 text-blue-800',
    warning: 'bg-amber-50 border-amber-200 text-amber-800',
  }
  return map[type] || map.info
}

function toastIcon(type) {
  const map = {
    success: 'check_circle',
    error: 'error',
    info: 'info',
    warning: 'warning',
  }
  return map[type] || map.info
}

function handleCustomEvent(e) {
  addToast(e.detail.message, e.detail.type, e.detail.duration)
}

onMounted(() => {
  window.addEventListener('app-toast', handleCustomEvent)
  listeners.push(() => window.removeEventListener('app-toast', handleCustomEvent))
})

onUnmounted(() => {
  listeners.forEach(fn => fn())
  listeners = []
})

window.showToast = addToast
</script>

<style scoped>
.toast-enter-active { transition: all 0.3s ease-out; }
.toast-leave-active { transition: all 0.3s ease-in; }
.toast-enter-from { opacity: 0; transform: translateY(-20px) scale(0.95); }
.toast-leave-to { opacity: 0; transform: translateY(-20px) scale(0.95); }
</style>