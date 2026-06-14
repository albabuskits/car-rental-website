<template>
  <div class="min-h-screen flex flex-col bg-surface text-on-surface">
    <main class="flex-grow flex items-center justify-center px-margin-mobile md:px-gutter py-xl">
      <div class="w-full max-w-[440px] flex flex-col gap-lg">
        <div class="flex flex-col items-center text-center gap-xs">
          <div class="flex items-center gap-xs">
            <span class="material-symbols-outlined text-primary text-4xl">directions_car</span>
            <h1 class="text-headline-lg font-headline-lg text-primary">عرب لتأجير السيارات</h1>
          </div>
          <p class="text-on-surface-variant font-body-md text-body-md">سجل الدخول لإدارة حجوزاتك المميزة</p>
        </div>
        <div class="bg-surface-container-lowest p-lg md:p-xl rounded-xl login-card-shadow border border-surface-container">
          <form class="space-y-md" @submit.prevent="handleLogin">
            <div v-if="error" class="p-md bg-error-container text-on-error-container rounded-lg font-label-sm">{{ error }}</div>
            <div class="space-y-xs">
              <label class="font-label-md text-label-md text-on-surface" for="email">البريد الإلكتروني</label>
              <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-xl">mail</span>
                <input class="w-full h-12 pr-10 pl-4 bg-surface-container-low border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary transition-all outline-none text-body-md font-body-md" id="email" v-model="form.email" placeholder="name@company.com" required type="email"/>
              </div>
            </div>
            <div class="space-y-xs">
              <div class="flex justify-between items-center">
                <label class="font-label-md text-label-md text-on-surface" for="password">كلمة المرور</label>
                <a class="text-secondary font-label-sm text-label-sm hover:underline" href="#">نسيت كلمة المرور؟</a>
              </div>
              <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-xl">lock</span>
                <input class="w-full h-12 pr-10 pl-12 bg-surface-container-low border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary transition-all outline-none text-body-md font-body-md" id="password" v-model="form.password" placeholder="••••••••" required type="password"/>
                <button class="absolute left-3 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface transition-colors" @click="togglePassword" type="button">
                  <span class="material-symbols-outlined" id="password-toggle-icon">visibility</span>
                </button>
              </div>
            </div>
            <div class="flex items-center gap-xs">
              <input class="w-4 h-4 rounded border-outline text-primary focus:ring-primary-container cursor-pointer" id="remember" v-model="form.remember" type="checkbox"/>
              <label class="font-body-md text-body-md text-on-surface-variant cursor-pointer select-none" for="remember">البقاء متصلاً</label>
            </div>
            <button class="w-full h-12 bg-primary text-on-primary font-label-md text-label-md rounded-lg btn-hover-effect transition-all flex items-center justify-center gap-xs" type="submit" :disabled="loading">
              <span v-if="loading">جاري تسجيل الدخول...</span>
              <span v-else>تسجيل الدخول إلى لوحة التحكم</span>
              <span class="material-symbols-outlined text-lg rtl-flip">login</span>
            </button>
          </form>
          <div class="relative my-lg">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-outline-variant"></div>
            </div>
            <div class="relative flex justify-center text-label-sm font-label-sm">
              <span class="bg-surface-container-lowest px-md text-on-surface-variant">وصول مؤسسي آمن</span>
            </div>
          </div>
          <div class="text-center">
            <p class="text-on-surface-variant font-body-md text-body-md">ليس لديك حساب؟ <a class="text-secondary font-label-md text-label-md hover:underline" href="#">اتصل بالمسؤول</a></p>
          </div>
        </div>
        <div class="flex items-center justify-center gap-sm opacity-60">
          <div class="flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">shield</span>
            <span class="font-label-sm text-label-sm">محمي بـ SSL</span>
          </div>
          <div class="w-1 h-1 bg-outline-variant rounded-full"></div>
          <div class="flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">lock_reset</span>
            <span class="font-label-sm text-label-sm">التحقق بخطوتين</span>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()
const loading = ref(false)
const error = ref(null)

const form = reactive({
  email: '',
  password: '',
  remember: false
})

function togglePassword() {
  const input = document.getElementById('password')
  const icon = document.getElementById('password-toggle-icon')
  if (input.type === 'password') {
    input.type = 'text'
    icon.textContent = 'visibility_off'
  } else {
    input.type = 'password'
    icon.textContent = 'visibility'
  }
}

async function handleLogin() {
  loading.value = true
  error.value = null
  try {
    await axios.get('/sanctum/csrf-cookie')
    const res = await axios.post('/api/login', {
      email: form.email,
      password: form.password
    })
    localStorage.setItem('token', res.data.token)
    localStorage.setItem('user', JSON.stringify(res.data.user))
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + res.data.token
    const isAdmin = res.data.user.roles?.some(r => r.name === 'admin')
    window.location.href = isAdmin ? '/admin' : '/dashboard'
  } catch (e) {
    if (e.response?.status === 422) {
      error.value = e.response?.data?.errors?.email?.[0] || 'بيانات الدخول غير صحيحة.'
    } else {
      error.value = 'فشل تسجيل الدخول. تحقق من بياناتك.'
    }
  } finally {
    loading.value = false
  }
}
</script>