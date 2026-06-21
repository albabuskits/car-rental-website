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
              <span class="font-label-md text-label-md" :class="currentStep >= 1 ? 'text-primary font-bold' : 'text-on-surface-variant'" id="step-label-1">1. تفاصيل الإيجار</span>
              <span class="font-label-md text-label-md" :class="currentStep >= 2 ? 'text-primary font-bold' : 'text-on-surface-variant'" id="step-label-2">2. المعلومات الشخصية</span>
              <span class="font-label-md text-label-md" :class="currentStep >= 3 ? 'text-primary font-bold' : 'text-on-surface-variant'" id="step-label-3">3. التأكيد</span>
            </div>
            <div class="h-2 w-full bg-surface-container rounded-full overflow-hidden">
              <div class="h-full bg-primary progress-bar transition-all" :style="{ width: progressWidth }"></div>
            </div>
          </div>
          <div v-if="stepError" class="p-md bg-error-container text-on-error-container rounded-lg font-label-sm mb-lg">{{ stepError }}</div>

          <div v-if="!licenseLoading && !isLoggedIn" class="p-lg bg-error-container/20 border border-error/30 rounded-xl mb-lg">
            <div class="flex items-start gap-md">
              <span class="material-symbols-outlined text-error text-2xl">login</span>
              <div>
                <h3 class="font-headline-md text-headline-md text-error mb-xs">تسجيل الدخول مطلوب</h3>
                <p class="text-on-surface-variant mb-md">يجب عليك تسجيل الدخول أولاً لإتمام عملية الحجز.</p>
                <a href="/login" class="inline-flex items-center gap-xs bg-error text-white h-10 px-lg rounded-lg font-bold hover:opacity-90 transition-all text-sm">
                  <span class="material-symbols-outlined text-lg">login</span>
                  تسجيل الدخول
                </a>
              </div>
            </div>
          </div>

          <div v-if="!licenseLoading && isLoggedIn && !hasApprovedLicense" class="p-lg bg-error-container/20 border border-error/30 rounded-xl mb-lg">
            <div class="flex items-start gap-md">
              <span class="material-symbols-outlined text-error text-2xl">badge</span>
              <div>
                <h3 class="font-headline-md text-headline-md text-error mb-xs">رخصة القيادة غير موثقة</h3>
                <p class="text-on-surface-variant mb-md">يجب توثيق رخصة القيادة الخاصة بك من قبل الإدارة قبل البدء في الحجز. قم بتحميل رخصتك من لوحة المستخدم وانتظر التوثيق.</p>
                <a href="/dashboard" class="inline-flex items-center gap-xs bg-error text-white h-10 px-lg rounded-lg font-bold hover:opacity-90 transition-all text-sm">
                  <span class="material-symbols-outlined text-lg">open_in_new</span>
                  الذهاب إلى لوحة المستخدم
                </a>
              </div>
            </div>
          </div>

          <form v-if="isLoggedIn && hasApprovedLicense" class="space-y-lg" id="booking-form" @submit.prevent="submitBooking">
            <div v-show="currentStep === 1" class="space-y-lg">
              <div class="bg-surface p-lg rounded-xl booking-card-shadow border border-outline-variant/30">
                <h2 class="font-headline-md text-headline-md mb-md flex items-center gap-xs"><span class="material-symbols-outlined text-primary">calendar_month</span> الجدول والموقع</h2>
                <div v-if="car?.next_available_date" class="p-md bg-amber-50 border border-amber-200 rounded-lg mb-md flex items-center gap-sm">
                  <span class="material-symbols-outlined text-amber-600">info</span>
                  <p class="text-amber-800 text-sm">هذه السيارة متاحة ابتداءً من <strong>{{ car.next_available_date }}</strong></p>
                </div>
                <div v-if="availabilityError" class="p-md bg-error-container/20 border border-error/30 rounded-lg mb-md flex items-center gap-sm">
                  <span class="material-symbols-outlined text-error">block</span>
                  <p class="text-error text-sm">{{ availabilityError }}</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                  <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface-variant">تاريخ الاستلام</label>
                    <input v-model="form.pickup_date" :min="minPickupDate" class="w-full h-12 px-md rounded-lg border focus:ring-1 transition-all outline-none" :class="errors.pickup_date ? 'border-error focus:border-error focus:ring-error/20' : 'border-outline-variant focus:border-secondary focus:ring-secondary/20'" type="date"/>
                    <p v-if="errors.pickup_date" class="text-error text-label-sm">{{ errors.pickup_date }}</p>
                  </div>
                  <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface-variant">تاريخ الإرجاع</label>
                    <input v-model="form.return_date" class="w-full h-12 px-md rounded-lg border focus:ring-1 transition-all outline-none" :class="errors.return_date ? 'border-error focus:border-error focus:ring-error/20' : 'border-outline-variant focus:border-secondary focus:ring-secondary/20'" type="date"/>
                    <p v-if="errors.return_date" class="text-error text-label-sm">{{ errors.return_date }}</p>
                  </div>
                  <div class="md:col-span-2 space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface-variant">موقع التسليم</label>
                    <input v-model="form.delivery_location" class="w-full h-12 px-md rounded-lg border focus:ring-1 transition-all outline-none" :class="errors.delivery_location ? 'border-error focus:border-error focus:ring-error/20' : 'border-outline-variant focus:border-secondary focus:ring-secondary/20'" placeholder="أدخل عنوان التسليم" type="text"/>
                    <p v-if="errors.delivery_location" class="text-error text-label-sm">{{ errors.delivery_location }}</p>
                  </div>
                </div>
              </div>
              <div class="flex justify-start">
                <button class="bg-primary text-white h-12 px-xl rounded-lg font-bold hover:opacity-90 active:scale-95 transition-all flex items-center gap-xs" :disabled="availabilityLoading" @click.prevent="validateStep1" type="button">
                  <span v-if="availabilityLoading" class="material-symbols-outlined animate-spin">sync</span>
                  متابعة إلى المعلومات الشخصية
                </button>
              </div>
            </div>
            <div v-show="currentStep === 2" class="space-y-lg">
              <div class="bg-surface p-lg rounded-xl booking-card-shadow border border-outline-variant/30">
                <h2 class="font-headline-md text-headline-md mb-md flex items-center gap-xs"><span class="material-symbols-outlined text-primary">person</span> معلومات السائق</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                  <div class="space-y-xs"><label class="font-label-md text-label-md text-on-surface-variant">الاسم الكامل</label>
                    <input v-model="form.customer_name" class="w-full h-12 px-md rounded-lg border focus:ring-1 transition-all outline-none" :class="errors.customer_name ? 'border-error focus:border-error focus:ring-error/20' : 'border-outline-variant focus:border-secondary focus:ring-secondary/20'" placeholder="محمد أحمد" type="text"/>
                    <p v-if="errors.customer_name" class="text-error text-label-sm">{{ errors.customer_name }}</p>
                  </div>
                  <div class="space-y-xs"><label class="font-label-md text-label-md text-on-surface-variant">البريد الإلكتروني</label>
                    <input v-model="form.customer_email" class="w-full h-12 px-md rounded-lg border focus:ring-1 transition-all outline-none" :class="errors.customer_email ? 'border-error focus:border-error focus:ring-error/20' : 'border-outline-variant focus:border-secondary focus:ring-secondary/20'" placeholder="mohamed@example.com" type="email"/>
                    <p v-if="errors.customer_email" class="text-error text-label-sm">{{ errors.customer_email }}</p>
                  </div>
                  <div class="space-y-xs"><label class="font-label-md text-label-md text-on-surface-variant">رقم الهاتف</label>
                    <input v-model="form.customer_phone" class="w-full h-12 px-md rounded-lg border focus:ring-1 transition-all outline-none" :class="errors.customer_phone ? 'border-error focus:border-error focus:ring-error/20' : 'border-outline-variant focus:border-secondary focus:ring-secondary/20'" placeholder="+971 50 000 0000" type="tel"/>
                    <p v-if="errors.customer_phone" class="text-error text-label-sm">{{ errors.customer_phone }}</p>
                  </div>
                  <div class="space-y-xs"><label class="font-label-md text-label-md text-on-surface-variant">رقم رخصة القيادة</label>
                    <input v-model="form.customer_license" class="w-full h-12 px-md rounded-lg border focus:ring-1 transition-all outline-none bg-surface-container-low" :class="errors.customer_license ? 'border-error focus:border-error focus:ring-error/20' : 'border-outline-variant focus:border-secondary focus:ring-secondary/20'" type="text" readonly/>
                    <p v-if="errors.customer_license" class="text-error text-label-sm">{{ errors.customer_license }}</p>
                  </div>
                </div>
              </div>
              <div class="flex justify-between">
                <button class="text-primary border border-primary h-12 px-xl rounded-lg font-bold hover:bg-surface-container transition-all" @click.prevent="currentStep = 1" type="button">رجوع</button>
                <button class="bg-primary text-white h-12 px-xl rounded-lg font-bold hover:opacity-90 active:scale-95 transition-all" @click.prevent="validateStep2" type="button">مراجعة الحجز</button>
              </div>
            </div>
            <div v-show="currentStep === 3" class="space-y-lg">
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
                  <input v-model="form.terms" class="rounded border-outline-variant text-primary focus:ring-primary" id="terms" type="checkbox"/>
                  <label class="font-label-md text-label-md text-on-surface-variant" for="terms">أؤكد أن جميع المعلومات المقدمة دقيقة وأنني أحمل رخصة قيادة سارية المفعول.</label>
                </div>
                <p v-if="errors.terms" class="text-error text-label-sm">{{ errors.terms }}</p>
              </div>
              <div class="flex justify-between">
                <button class="text-primary border border-primary h-12 px-xl rounded-lg font-bold hover:bg-surface-container transition-all" @click.prevent="currentStep = 2" type="button">رجوع</button>
                <button class="bg-primary-container text-white h-12 px-xl rounded-lg font-bold hover:opacity-90 active:scale-95 transition-all flex items-center gap-xs" type="submit" :disabled="submitting">{{ submitting ? 'جاري الإرسال...' : 'إرسال طلب الحجز' }} <span class="material-symbols-outlined">send</span></button>
              </div>
            </div>
          </form>
        </div>
        <div class="lg:col-span-4">
          <div class="sticky top-24 space-y-lg">
            <div class="bg-surface rounded-xl overflow-hidden booking-card-shadow border border-outline-variant/30">
              <div class="relative h-48 w-full bg-surface-container-highest">
                <img loading="lazy" class="w-full h-full object-cover" :src="car && car.images && car.images.length ? '/storage/' + car.images[0].image_path : '/images/booking-car.jpg'"/>
              </div>
              <div class="p-lg">
                <div v-if="car" class="flex justify-between items-start mb-md">
                  <div><h3 class="font-headline-md text-headline-md">{{ car.brand }} {{ car.model }}</h3><p class="text-on-surface-variant font-label-md text-label-md">{{ categoryLabel }}</p></div>
                  <span class="bg-secondary/10 text-secondary px-xs py-1 rounded font-label-sm text-label-sm">{{ car.transmission === 'automatic' ? 'أوتوماتيك' : 'يدوي' }}</span>
                </div>
                <div v-if="car" class="flex flex-wrap gap-md mb-lg">
                  <div class="flex items-center gap-xs text-on-surface-variant"><span class="material-symbols-outlined text-base">person</span><span class="text-sm">{{ car.seats }} مقاعد</span></div>
                  <div class="flex items-center gap-xs text-on-surface-variant"><span class="material-symbols-outlined text-base">local_gas_station</span><span class="text-sm">{{ car.fuel_type }}</span></div>
                </div>
                <div v-if="car" class="space-y-sm border-t border-outline-variant/20 pt-lg">
                  <div class="flex justify-between font-label-md text-label-md"><span class="text-on-surface-variant">السعر لليوم</span><span class="text-primary font-bold">${{ Number(car.price_per_day).toFixed(2) }}</span></div>
                  <div class="flex justify-between font-label-md text-label-md"><span class="text-on-surface-variant">المدة</span><span class="text-on-surface" id="summary-duration">-</span></div>
                  <div v-if="tax.enabled" class="flex justify-between font-label-md text-label-md"><span class="text-on-surface-variant">الضرائب والرسوم</span><span class="text-on-surface">${{ Number(tax.amount).toFixed(2) }}</span></div>
                  <div class="pt-md mt-md border-t border-primary/20 flex justify-between items-center">
                    <span class="font-bold text-headline-md">المجموع</span>
                    <div class="text-right"><p class="font-display-lg text-primary text-3xl font-bold" id="summary-total">-</p><p class="text-xs text-on-surface-variant">كل شيء شامل</p></div>
                  </div>
                </div>
                <div v-else-if="carLoadError" class="p-md text-center text-error">{{ carLoadError }}</div>
                <div v-else class="p-md text-center text-on-surface-variant">جاري تحميل بيانات السيارة...</div>
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
import { ref, reactive, computed, watch, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import AppHeader from '@/components/AppHeader.vue'
import AppFooter from '@/components/AppFooter.vue'

const route = useRoute()
const router = useRouter()
const car = ref(null)
const submitting = ref(false)
const submitError = ref('')
const stepError = ref('')
const currentStep = ref(1)
const hasApprovedLicense = ref(false)
const licenseLoading = ref(true)
const isLoggedIn = ref(false)
const tax = ref({ enabled: true, amount: 45 })
const availabilityLoading = ref(false)
const availabilityError = ref('')
const carLoadError = ref('')

const minPickupDate = computed(() => {
  if (car.value?.next_available_date) return car.value.next_available_date
  const d = new Date()
  d.setDate(d.getDate() + 1)
  return d.toISOString().split('T')[0]
})

const form = reactive({
  pickup_date: '',
  return_date: '',
  delivery_location: '',
  customer_name: '',
  customer_email: '',
  customer_phone: '',
  customer_license: '',
  terms: false,
})

const errors = reactive({
  pickup_date: '',
  return_date: '',
  delivery_location: '',
  customer_name: '',
  customer_email: '',
  customer_phone: '',
  customer_license: '',
  terms: '',
})

function clearErrors() {
  Object.keys(errors).forEach(k => errors[k] = '')
  stepError.value = ''
}

const progressWidth = computed(() => {
  if (currentStep.value === 1) return '33.33%'
  if (currentStep.value === 2) return '66.66%'
  return '100%'
})

const categoryLabel = computed(() => {
  if (!car.value) return ''
  const map = { suv: 'دفع رباعي', sedan: 'سيدان', luxury: 'فاخرة', sports: 'رياضية', economy: 'اقتصادية', electric: 'كهربائية' }
  return map[car.value.category] || car.value.category
})

function updateSummary() {
  if (!car.value) return
  const pickup = new Date(form.pickup_date)
  const dropoff = new Date(form.return_date)
  if (form.pickup_date && form.return_date && dropoff > pickup) {
    const diffTime = Math.abs(dropoff - pickup)
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
    const el = document.getElementById('summary-duration')
    if (el) el.textContent = diffDays + ' أيام'
    const pricePerDay = Number(car.value.price_per_day)
    const basePrice = diffDays * pricePerDay
    const taxAmount = tax.value.enabled ? Number(tax.value.amount) : 0
    const total = basePrice + taxAmount
    const totalEl = document.getElementById('summary-total')
    if (totalEl) totalEl.textContent = '$' + total.toFixed(2)
  }
}

async function checkAvailability() {
  if (!form.pickup_date || !form.return_date || !car.value?.id) return
  availabilityLoading.value = true
  availabilityError.value = ''
  try {
    const res = await axios.get(`/api/cars/${car.value.id}/availability`, {
      params: { pickup_date: form.pickup_date, return_date: form.return_date },
    })
    if (!res.data.available) {
      availabilityError.value = res.data.next_available_date
        ? `السيارة غير متاحة في هذه التواريخ. أقرب تاريخ متاح: ${res.data.next_available_date}`
        : 'السيارة غير متاحة في هذه التواريخ.'
    }
  } catch {
    // silently fail - server validates on submit
  } finally {
    availabilityLoading.value = false
  }
}

watch(() => form.pickup_date, (val) => {
  if (val) {
    const d = new Date(val + 'T00:00:00')
    d.setDate(d.getDate() + 1)
    form.return_date = d.toISOString().split('T')[0]
  }
})

watch(() => [form.pickup_date, form.return_date], () => {
  updateSummary()
  if (form.pickup_date && form.return_date) checkAvailability()
})

function validateStep1() {
  clearErrors()
  if (!hasApprovedLicense.value) {
    stepError.value = 'يجب توثيق رخصة القيادة قبل البدء في الحجز.'
    return false
  }
  let valid = true
  if (!form.pickup_date) { errors.pickup_date = 'يرجى اختيار تاريخ الاستلام'; valid = false }
  else {
    const today = new Date()
    today.setHours(0, 0, 0, 0)
    const pickup = new Date(form.pickup_date + 'T00:00:00')
    if (pickup <= today) { errors.pickup_date = 'تاريخ الاستلام يجب أن يكون بعد اليوم'; valid = false }
  }
  if (!form.return_date) { errors.return_date = 'يرجى اختيار تاريخ الإرجاع'; valid = false }
  else if (form.pickup_date && form.return_date && form.return_date <= form.pickup_date) {
    errors.return_date = 'تاريخ الإرجاع يجب أن يكون بعد تاريخ الاستلام'; valid = false
  }
  if (!form.delivery_location.trim()) { errors.delivery_location = 'يرجى إدخال موقع التسليم'; valid = false }
  if (availabilityError.value) { stepError.value = availabilityError.value; valid = false }
  if (valid) { currentStep.value = 2 }
  return valid
}

function validateStep2() {
  clearErrors()
  let valid = true
  if (!form.customer_name.trim()) { errors.customer_name = 'يرجى إدخال الاسم الكامل'; valid = false }
  if (!form.customer_email.trim()) { errors.customer_email = 'يرجى إدخال البريد الإلكتروني'; valid = false }
  else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.customer_email)) { errors.customer_email = 'البريد الإلكتروني غير صحيح'; valid = false }
  if (!form.customer_phone.trim()) { errors.customer_phone = 'يرجى إدخال رقم الهاتف'; valid = false }
  if (valid) { currentStep.value = 3 }
  return valid
}

async function submitBooking() {
  if (!form.terms) { errors.terms = 'يرجى الموافقة على الشروط قبل الإرسال'; return }
  if (!hasApprovedLicense.value) { submitError.value = 'يجب توثيق رخصة القيادة قبل إرسال الحجز.'; return }
  clearErrors()
  const carId = route.query.car_id
  if (!carId) { submitError.value = 'الرجاء اختيار سيارة أولاً'; return }
  submitting.value = true
  submitError.value = ''
  try {
    await axios.post('/api/bookings', {
      car_id: carId,
      pickup_date: form.pickup_date,
      return_date: form.return_date,
      delivery_location: form.delivery_location,
      customer_name: form.customer_name,
      customer_email: form.customer_email,
      customer_phone: form.customer_phone,
      customer_license: form.customer_license,
    })
      window.showToast('تم إرسال طلب الحجز بنجاح! سنتواصل معك قريباً.')
      router.push('/')
  } catch (e) {
    submitError.value = e.response?.data?.message || e.message || 'فشل إرسال الحجز. حاول مرة أخرى.'
  } finally {
    submitting.value = false
  }
}

onMounted(async () => {
  const carId = route.query.car_id
    if (carId) {
      try {
        const res = await axios.get('/api/cars/' + carId)
        car.value = res.data
      } catch (e) {
        carLoadError.value = e.response?.data?.message || 'فشل تحميل بيانات السيارة. حاول مرة أخرى لاحقاً.'
      }
    }
  const token = localStorage.getItem('token')
  if (token) {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
    try {
      const res = await axios.get('/api/user')
      isLoggedIn.value = true
      if (res.data.name) form.customer_name = res.data.name
      if (res.data.email) form.customer_email = res.data.email
    } catch {
      localStorage.removeItem('token')
      delete axios.defaults.headers.common['Authorization']
    }
  }
  if (isLoggedIn.value) {
    try {
      const res = await axios.get('/api/user/license')
      hasApprovedLicense.value = res.data.has_approved_license
      if (res.data.tax) tax.value = res.data.tax
      if (res.data.license) {
        if (res.data.license.full_name) form.customer_name = res.data.license.full_name
        if (res.data.license.license_number) form.customer_license = res.data.license.license_number
      }
    } catch (e) {
      console.error('License check failed:', e.response?.data || e.message)
    }
  }
  licenseLoading.value = false
  const d = new Date()
  d.setDate(d.getDate() + 1)
  form.pickup_date = car.value?.next_available_date || d.toISOString().split('T')[0]
})
</script>
