<template>
  <div>
    <AppHeader />
    <main class="flex-grow w-full max-w-[1280px] mx-auto px-gutter py-xl" style="margin-top: 4rem">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-xl">
        <div class="lg:col-span-8">
          <div class="mb-xl">
            <h1 class="font-headline-lg text-headline-lg mb-xs">أكمل حجزك</h1>
            <p class="text-on-surface-variant font-body-md">بعض التفاصيل الإضافية لتأمين سيارتك المميزة.</p>
          </div>
          <div class="mb-xl relative">
            <div class="flex justify-between mb-xs">
              <span class="step-active font-label-md text-label-md" id="step-label-1">1. تفاصيل الإيجار</span>
              <span class="step-inactive font-label-md text-label-md" id="step-label-2">2. المعلومات الشخصية</span>
              <span class="step-inactive font-label-md text-label-md" id="step-label-3">3. التأكيد</span>
            </div>
            <div class="h-2 w-full bg-surface-container rounded-full overflow-hidden">
              <div class="h-full bg-primary progress-bar" id="progress-indicator" style="width: 33.33%"></div>
            </div>
          </div>
          <form class="space-y-lg" id="booking-form">
            <div class="space-y-lg" id="step-1">
              <div class="bg-surface p-lg rounded-xl booking-card-shadow border border-outline-variant/30">
                <h2 class="font-headline-md text-headline-md mb-md flex items-center gap-xs"><span class="material-symbols-outlined text-primary">calendar_month</span> الجدول والموقع</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                  <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface-variant">تاريخ الاستلام</label>
                    <div class="relative"><input class="w-full h-12 px-md rounded-lg border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary/20 transition-all" id="pickup-date" required type="date"/></div>
                  </div>
                  <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface-variant">تاريخ الإرجاع</label>
                    <div class="relative"><input class="w-full h-12 px-md rounded-lg border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary/20 transition-all" id="return-date" required type="date"/></div>
                  </div>
                  <div class="md:col-span-2 space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface-variant">موقع التسليم</label>
                    <input class="w-full h-12 px-md rounded-lg border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary/20 transition-all" id="delivery-location" placeholder="أدخل عنوان التسليم" required type="text"/>
                  </div>
                </div>
              </div>
              <div class="flex justify-start">
                <button class="bg-primary text-white h-12 px-xl rounded-lg font-bold hover:opacity-90 active:scale-95 transition-all" @click.prevent="goToStep(2)" type="button">متابعة إلى المعلومات الشخصية</button>
              </div>
            </div>
            <div class="hidden space-y-lg" id="step-2">
              <div class="bg-surface p-lg rounded-xl booking-card-shadow border border-outline-variant/30">
                <h2 class="font-headline-md text-headline-md mb-md flex items-center gap-xs"><span class="material-symbols-outlined text-primary">person</span> معلومات السائق</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                  <div class="space-y-xs"><label class="font-label-md text-label-md text-on-surface-variant">الاسم الكامل</label><input class="w-full h-12 px-md rounded-lg border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary/20 transition-all" id="customer-name" placeholder="محمد أحمد" required type="text"/></div>
                  <div class="space-y-xs"><label class="font-label-md text-label-md text-on-surface-variant">البريد الإلكتروني</label><input class="w-full h-12 px-md rounded-lg border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary/20 transition-all" id="customer-email" placeholder="mohamed@example.com" required type="email"/></div>
                  <div class="space-y-xs"><label class="font-label-md text-label-md text-on-surface-variant">رقم الهاتف</label><input class="w-full h-12 px-md rounded-lg border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary/20 transition-all" id="customer-phone" placeholder="+971 50 000 0000" required type="tel"/></div>
                  <div class="space-y-xs"><label class="font-label-md text-label-md text-on-surface-variant">رقم رخصة القيادة</label><input class="w-full h-12 px-md rounded-lg border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary/20 transition-all" id="customer-license" placeholder="DL-123456789" required type="text"/></div>
                </div>
              </div>
              <div class="flex justify-between">
                <button class="text-primary border border-primary h-12 px-xl rounded-lg font-bold hover:bg-surface-container transition-all" @click.prevent="goToStep(1)" type="button">رجوع</button>
                <button class="bg-primary text-white h-12 px-xl rounded-lg font-bold hover:opacity-90 active:scale-95 transition-all" @click.prevent="goToStep(3)" type="button">مراجعة الحجز</button>
              </div>
            </div>
            <div class="hidden space-y-lg" id="step-3">
              <div v-if="submitError" class="p-md bg-error-container text-on-error-container rounded-lg font-label-sm">{{ submitError }}</div>
              <div class="bg-surface p-lg rounded-xl booking-card-shadow border border-outline-variant/30">
                <h2 class="font-headline-md text-headline-md mb-md flex items-center gap-xs"><span class="material-symbols-outlined text-primary">verified_user</span> المراجعة النهائية</h2>
                <div class="p-md bg-surface-container-low rounded-lg border border-outline-variant/20 mb-md">
                  <div class="flex items-start gap-md">
                    <span class="material-symbols-outlined text-secondary text-2xl">info</span>
                    <div>
                      <p class="font-label-md text-label-md mb-1">حجز آمن</p>
                      <p class="text-on-surface-variant font-body-sm text-sm">بالنقر على إرسال، فإنك توافق على شروط الخدمة وسياسة الخصوصية الخاصة بنا. سيتصل بك أحد المتخصصين في غضون 15 دقيقة لتأكيد التوفر.</p>
                    </div>
                  </div>
                </div>
                <div class="flex items-center gap-xs mb-md">
                  <input class="rounded border-outline-variant text-primary focus:ring-primary" id="terms" required type="checkbox"/>
                  <label class="font-label-md text-label-md text-on-surface-variant" for="terms">أؤكد أن جميع المعلومات المقدمة دقيقة وأنني أحمل رخصة قيادة سارية المفعول.</label>
                </div>
              </div>
              <div class="flex justify-between">
                <button class="text-primary border border-primary h-12 px-xl rounded-lg font-bold hover:bg-surface-container transition-all" @click.prevent="goToStep(2)" type="button">رجوع</button>
                <button class="bg-primary-container text-white h-12 px-xl rounded-lg font-bold hover:opacity-90 active:scale-95 transition-all flex items-center gap-xs" type="submit" :disabled="submitting">{{ submitting ? 'جاري الإرسال...' : 'إرسال طلب الحجز' }} <span class="material-symbols-outlined">send</span></button>
              </div>
            </div>
          </form>
        </div>
        <div class="lg:col-span-4">
          <div class="sticky top-24 space-y-lg">
            <div class="bg-surface rounded-xl overflow-hidden booking-card-shadow border border-outline-variant/30">
              <div class="relative h-48 w-full bg-surface-container-highest">
                <img class="w-full h-full object-cover" src="/images/booking-car.jpg"/>
              </div>
              <div class="p-lg">
                <div class="flex justify-between items-start mb-md">
                  <div><h3 class="font-headline-md text-headline-md">بي إم دبليو الفئة الخامسة</h3><p class="text-on-surface-variant font-label-md text-label-md">سيدان تنفيذية فاخرة</p></div>
                  <span class="bg-secondary/10 text-secondary px-xs py-1 rounded font-label-sm text-label-sm">أوتوماتيك</span>
                </div>
                <div class="flex flex-wrap gap-md mb-lg">
                  <div class="flex items-center gap-xs text-on-surface-variant"><span class="material-symbols-outlined text-base">person</span><span class="text-sm">5 مقاعد</span></div>
                  <div class="flex items-center gap-xs text-on-surface-variant"><span class="material-symbols-outlined text-base">work</span><span class="text-sm">2 حقيبة كبيرة</span></div>
                  <div class="flex items-center gap-xs text-on-surface-variant"><span class="material-symbols-outlined text-base">local_gas_station</span><span class="text-sm">بنزين</span></div>
                </div>
                <div class="space-y-sm border-t border-outline-variant/20 pt-lg">
                  <div class="flex justify-between font-label-md text-label-md"><span class="text-on-surface-variant">السعر لليوم</span><span class="text-primary font-bold">$120.00</span></div>
                  <div class="flex justify-between font-label-md text-label-md"><span class="text-on-surface-variant">المدة</span><span class="text-on-surface" id="summary-duration">3 أيام</span></div>
                  <div class="flex justify-between font-label-md text-label-md"><span class="text-on-surface-variant">الضرائب والرسوم</span><span class="text-on-surface">$45.00</span></div>
                  <div class="pt-md mt-md border-t border-primary/20 flex justify-between items-center">
                    <span class="font-bold text-headline-md">المجموع</span>
                    <div class="text-right"><p class="font-display-lg text-primary text-3xl font-bold" id="summary-total">$405.00</p><p class="text-xs text-on-surface-variant">كل شيء شامل</p></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="p-lg bg-inverse-surface text-inverse-on-surface rounded-xl">
              <div class="flex items-center gap-md mb-sm"><span class="material-symbols-outlined text-secondary-fixed">shield_lock</span><p class="font-label-md text-label-md">ضمان حجز آمن</p></div>
              <p class="text-sm opacity-80">بيانات الدفع والشخصية الخاصة بك مشفرة ومحمية باستخدام بروتوكولات قياسية في المجال.</p>
            </div>
          </div>
        </div>
      </div>
    </main>
    <AppFooter />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import AppHeader from '@/components/AppHeader.vue'
import AppFooter from '@/components/AppFooter.vue'

const route = useRoute()
const router = useRouter()
const isLoggedIn = ref(false)
const submitting = ref(false)
const submitError = ref('')

function goToStep(stepNumber) {
  document.getElementById('step-1').classList.add('hidden')
  document.getElementById('step-2').classList.add('hidden')
  document.getElementById('step-3').classList.add('hidden')
  document.getElementById('step-' + stepNumber).classList.remove('hidden')
  const progress = document.getElementById('progress-indicator')
  if (stepNumber === 1) progress.style.width = '33.33%'
  else if (stepNumber === 2) progress.style.width = '66.66%'
  else if (stepNumber === 3) progress.style.width = '100%'
  const stepLabels = ['step-label-1', 'step-label-2', 'step-label-3']
  stepLabels.forEach((id, index) => {
    const label = document.getElementById(id)
    if (index + 1 === stepNumber) { label.classList.remove('step-inactive'); label.classList.add('step-active') }
    else if (index + 1 < stepNumber) { label.classList.remove('step-inactive'); label.classList.add('step-active') }
    else { label.classList.remove('step-active'); label.classList.add('step-inactive') }
  })
  window.scrollTo({ top: 100, behavior: 'smooth' })
}

function updateSummary() {
  const pickup = new Date(document.getElementById('pickup-date')?.value)
  const dropoff = new Date(document.getElementById('return-date')?.value)
  if (pickup && dropoff && dropoff > pickup) {
    const diffTime = Math.abs(dropoff - pickup)
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
    const el = document.getElementById('summary-duration')
    if (el) el.textContent = diffDays + ' أيام'
    const basePrice = diffDays * 120
    const total = basePrice + 45
    const totalEl = document.getElementById('summary-total')
    if (totalEl) totalEl.textContent = '$' + total.toFixed(2)
  }
}

onMounted(() => {
  const token = localStorage.getItem('token')
  if (token) {
    isLoggedIn.value = true
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
    const userData = localStorage.getItem('user')
    if (userData) {
      const user = JSON.parse(userData)
      const nameEl = document.getElementById('customer-name')
      const emailEl = document.getElementById('customer-email')
      if (nameEl && user.name) nameEl.value = user.name
      if (emailEl && user.email) emailEl.value = user.email
    }
    axios.get('/api/user').then(res => {
      const nameEl = document.getElementById('customer-name')
      const emailEl = document.getElementById('customer-email')
      if (nameEl && res.data.name) nameEl.value = res.data.name
      if (emailEl && res.data.email) emailEl.value = res.data.email
    }).catch(() => {})
  }
  const today = new Date()
  const nextWeek = new Date()
  nextWeek.setDate(today.getDate() + 7)
  const pickupEl = document.getElementById('pickup-date')
  const returnEl = document.getElementById('return-date')
  if (pickupEl) pickupEl.value = today.toISOString().split('T')[0]
  if (returnEl) returnEl.value = nextWeek.toISOString().split('T')[0]
  updateSummary()
  document.getElementById('pickup-date')?.addEventListener('change', updateSummary)
  document.getElementById('return-date')?.addEventListener('change', updateSummary)
  document.getElementById('booking-form')?.addEventListener('submit', async function(e) {
    e.preventDefault()
    const carId = route.query.car_id
    if (!carId) { submitError.value = 'الرجاء اختيار سيارة أولاً'; return; }
    submitting.value = true
    submitError.value = ''
    try {
      const payload = {
        car_id: carId,
        pickup_date: document.getElementById('pickup-date')?.value,
        return_date: document.getElementById('return-date')?.value,
        delivery_location: document.getElementById('delivery-location')?.value,
        customer_name: document.getElementById('customer-name')?.value,
        customer_email: document.getElementById('customer-email')?.value,
        customer_phone: document.getElementById('customer-phone')?.value,
        customer_license: document.getElementById('customer-license')?.value,
      }
      if (!payload.customer_name || !payload.customer_email) {
        throw new Error('يرجى ملء جميع الحقول المطلوبة')
      }
      await axios.post('/api/bookings', payload)
      alert('تم إرسال طلب الحجز بنجاح! سنتواصل معك قريباً.')
      router.push('/')
    } catch (e) {
      submitError.value = e.response?.data?.message || e.message || 'فشل إرسال الحجز. حاول مرة أخرى.'
    } finally {
      submitting.value = false
    }
  })
})
</script>