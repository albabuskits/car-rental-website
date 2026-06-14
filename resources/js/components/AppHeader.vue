<template>
  <header class="fixed top-0 left-0 w-full z-50 bg-surface shadow-sm h-16 flex items-center">
    <div class="flex justify-between items-center w-full px-gutter max-w-[1280px] mx-auto h-16">
      <div class="text-headline-md font-headline-lg font-bold text-primary cursor-pointer" @click="$router.push('/')">عرب لتأجير السيارات</div>
      <nav class="hidden md:flex items-center gap-lg">
        <router-link v-slot="{ isActive, navigate }" to="/" custom>
          <a :class="['font-label-md text-label-md transition-colors duration-200 cursor-pointer', isActive ? 'text-primary border-b-2 border-primary pb-1 font-bold' : 'text-on-surface-variant hover:text-primary']" @click="navigate">الرئيسية</a>
        </router-link>
        <router-link v-slot="{ isActive, navigate }" to="/cars" custom>
          <a :class="['font-label-md text-label-md transition-colors duration-200 cursor-pointer', isActive ? 'text-primary border-b-2 border-primary pb-1 font-bold' : 'text-on-surface-variant hover:text-primary']" @click="navigate">السيارات</a>
        </router-link>
        <router-link v-slot="{ isActive, navigate }" to="/about-us" custom>
          <a :class="['font-label-md text-label-md transition-colors duration-200 cursor-pointer', isActive ? 'text-primary border-b-2 border-primary pb-1 font-bold' : 'text-on-surface-variant hover:text-primary']" @click="navigate">من نحن</a>
        </router-link>
        <router-link v-slot="{ isActive, navigate }" to="/contact-us" custom>
          <a :class="['font-label-md text-label-md transition-colors duration-200 cursor-pointer', isActive ? 'text-primary border-b-2 border-primary pb-1 font-bold' : 'text-on-surface-variant hover:text-primary']" @click="navigate">اتصل بنا</a>
        </router-link>
      </nav>
      <div class="flex items-center gap-md">
        <button class="hidden lg:block text-on-surface-variant font-label-md text-label-md hover:text-secondary transition-colors" @click="toggleTheme" :title="themeIcon === 'dark_mode' ? 'تغيير إلى الوضع الفاتح' : 'تغيير إلى الوضع الداكن'">
          <span class="material-symbols-outlined">{{ themeIcon }}</span>
        </button>
        <template v-if="isLoggedIn">
          <button class="hidden lg:block text-error font-label-md text-label-md hover:opacity-80 transition-all" @click="handleLogout">تسجيل الخروج</button>
          <button class="bg-primary text-on-primary px-lg py-xs rounded-lg font-label-md text-label-md hover:bg-primary-container transition-all active:scale-95" @click="goToDashboard">لوحة التحكم</button>
        </template>
        <template v-else>
          <button class="hidden lg:block text-secondary font-label-md text-label-md hover:opacity-80 transition-all" @click="goToRegister">تسجيل</button>
          <button class="bg-primary text-on-primary px-lg py-xs rounded-lg font-label-md text-label-md hover:bg-primary-container transition-all active:scale-95" @click="$router.push('/login')">تسجيل الدخول</button>
        </template>
        <button class="md:hidden text-primary">
          <span class="material-symbols-outlined">menu</span>
        </button>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const themeIcon = ref('dark_mode')
const isLoggedIn = ref(false)

function getPreferredTheme() {
  return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
}

function applyTheme(theme) {
  const isDark = theme === 'dark' || (theme === 'auto' && getPreferredTheme() === 'dark')
  document.documentElement.classList.toggle('dark', isDark)
  themeIcon.value = isDark ? 'dark_mode' : 'light_mode'
}

function goToRegister() {
  window.location.href = '/register'
}

function goToDashboard() {
  window.location.href = '/dashboard'
}

async function handleLogout() {
  try {
    await axios.post('/api/logout')
  } catch {}
  localStorage.removeItem('token')
  localStorage.removeItem('user')
  delete axios.defaults.headers.common['Authorization']
  window.location.href = '/'
}

function toggleTheme() {
  const current = localStorage.getItem('theme') || 'auto'
  let next
  if (current === 'light') next = 'dark'
  else if (current === 'dark') next = 'auto'
  else next = 'light'
  localStorage.setItem('theme', next)
  applyTheme(next)
}

onMounted(async () => {
  const token = localStorage.getItem('token')
  if (token) {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
  }
  try {
    await axios.get('/api/user')
    isLoggedIn.value = true
  } catch {
    if (token) {
      localStorage.removeItem('token')
      localStorage.removeItem('user')
      delete axios.defaults.headers.common['Authorization']
    }
  }
  const saved = localStorage.getItem('theme') || 'auto'
  applyTheme(saved)
  window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    const theme = localStorage.getItem('theme') || 'auto'
    if (theme === 'auto') applyTheme('auto')
  })
})
</script>
