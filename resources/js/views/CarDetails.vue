<template>
  <div>
    <AppHeader />
    <main class="max-w-[1280px] mx-auto px-gutter py-xl" style="margin-top: 4rem">
      <nav v-if="car" class="mb-lg flex items-center gap-xs text-on-surface-variant font-label-sm">
        <a class="hover:text-primary cursor-pointer" @click="$router.push('/')">الرئيسية</a>
        <span class="material-symbols-outlined text-[16px] rtl-flip">chevron_left</span>
        <a class="hover:text-primary cursor-pointer" @click="$router.push('/cars')">السيارات</a>
        <span class="material-symbols-outlined text-[16px] rtl-flip">chevron_left</span>
        <span class="text-on-surface font-semibold">{{ car.brand }} {{ car.model }}</span>
      </nav>
      <div v-if="loading" class="text-center py-xl text-on-surface-variant">جاري التحميل...</div>
      <div v-else-if="!car" class="text-center py-xl text-on-surface-variant">السيارة غير موجودة.</div>
      <div v-else class="grid grid-cols-1 lg:grid-cols-12 gap-xl">
        <div class="lg:col-span-7 space-y-md">
          <div class="relative rounded-xl overflow-hidden shadow-sm group">
            <img class="w-full aspect-[16/10] object-cover transition-transform duration-700 group-hover:scale-105" :src="selectedImage"/>
            <div class="absolute top-md left-md">
              <span class="bg-secondary text-on-secondary px-md py-1 rounded-full font-label-md shadow-lg">{{ car.status === 'available' ? 'متاحة الآن' : 'غير متاحة' }}</span>
            </div>
          </div>
          <div v-if="carImages.length > 0" class="grid grid-cols-4 gap-md">
            <div v-for="(img, index) in visibleThumbnails" :key="index" class="cursor-pointer rounded-lg overflow-hidden border-2 transition-all relative" :class="selectedImage === getImageUrl(img) ? 'border-primary' : 'border-transparent hover:border-outline-variant'" @click="selectedImage = getImageUrl(img)">
              <img class="w-full h-24 object-cover" :src="getImageUrl(img)"/>
              <div v-if="index === 3 && carImages.length > 4" class="absolute inset-0 bg-black/40 flex items-center justify-center text-white font-label-md">+{{ carImages.length - 4 }} صور</div>
            </div>
          </div>
          <div class="pt-lg">
            <h3 class="font-headline-md text-headline-md mb-md">الوصف</h3>
            <p class="text-on-surface-variant leading-relaxed">{{ car.description || 'لا يوجد وصف.' }}</p>
          </div>
        </div>
        <div class="lg:col-span-5 space-y-lg">
          <div class="glass-card p-lg rounded-xl shadow-sm border border-surface-variant">
            <div class="flex justify-between items-start mb-md">
              <div>
                <h1 class="font-headline-lg text-headline-lg">{{ car.brand }} {{ car.model }}</h1>
                <p class="text-on-surface-variant font-label-md">{{ car.category }} | موديل {{ car.year }}</p>
              </div>
            </div>
            <div class="bg-surface-container-low p-md rounded-lg flex items-center justify-between mb-lg">
              <div>
                <span class="text-on-surface-variant font-label-sm uppercase tracking-wider block">السعر اليومي</span>
                <span class="font-headline-md text-primary">${{ Number(car.price_per_day).toFixed(0) }}</span><span class="text-on-surface-variant">/ يوم</span>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-sm mb-lg">
              <div class="bg-surface p-md rounded-lg border border-surface-variant flex items-center gap-md">
                <div class="w-10 h-10 bg-secondary-fixed rounded-lg flex items-center justify-center"><span class="material-symbols-outlined text-secondary">local_gas_station</span></div>
                <div><span class="text-on-surface-variant text-label-sm block">الوقود</span><span class="font-label-md">{{ car.fuel_type }}</span></div>
              </div>
              <div class="bg-surface p-md rounded-lg border border-surface-variant flex items-center gap-md">
                <div class="w-10 h-10 bg-secondary-fixed rounded-lg flex items-center justify-center"><span class="material-symbols-outlined text-secondary">airline_seat_recline_extra</span></div>
                <div><span class="text-on-surface-variant text-label-sm block">المقاعد</span><span class="font-label-md">{{ car.seats }} أشخاص</span></div>
              </div>
              <div class="bg-surface p-md rounded-lg border border-surface-variant flex items-center gap-md">
                <div class="w-10 h-10 bg-secondary-fixed rounded-lg flex items-center justify-center"><span class="material-symbols-outlined text-secondary">settings_input_component</span></div>
                <div><span class="text-on-surface-variant text-label-sm block">ناقل الحركة</span><span class="font-label-md">{{ car.transmission === 'automatic' ? 'أوتوماتيك' : 'يدوي' }}</span></div>
              </div>
              <div class="bg-surface p-md rounded-lg border border-surface-variant flex items-center gap-md">
                <div class="w-10 h-10 bg-secondary-fixed rounded-lg flex items-center justify-center"><span class="material-symbols-outlined text-secondary">ac_unit</span></div>
                <div><span class="text-on-surface-variant text-label-sm block">تكييف</span><span class="font-label-md">{{ car.ac ? 'متوفر' : 'غير متوفر' }}</span></div>
              </div>
            </div>
            <div class="space-y-md">
              <button class="w-full h-12 bg-primary text-on-primary font-label-md rounded-lg shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-md" @click="$router.push('/booking?car_id=' + car.id)">
                احجز هذه السيارة <span class="material-symbols-outlined rtl-flip">arrow_back</span>
              </button>
            </div>
          </div>
        </div>
      </div>
      <section v-if="similarCars.length > 0" class="mt-xl pt-xl border-t border-surface-variant">
        <div class="flex justify-between items-end mb-lg">
          <div><h2 class="font-headline-md text-headline-md">سيارات مماثلة</h2><p class="text-on-surface-variant">المزيد من الخيارات من أسطولنا المميز</p></div>
          <a class="text-primary font-label-md flex items-center gap-xs hover:gap-md transition-all cursor-pointer" @click="$router.push('/cars')">عرض الأسطول الكامل <span class="material-symbols-outlined text-[20px] rtl-flip">east</span></a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-lg">
          <div v-for="s in similarCars" :key="s.id" class="bg-white rounded-xl shadow-sm overflow-hidden group hover:shadow-md transition-all duration-300">
            <div class="relative h-48 overflow-hidden">
              <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" :src="s.images && s.images.length ? '/storage/' + s.images[0].image_path : '/images/cd-similar1.jpg'"/>
              <div class="absolute top-md left-md bg-white/90 backdrop-blur px-md py-1 rounded-full text-label-sm font-bold text-primary">${{ Number(s.price_per_day).toFixed(0) }}/ يوم</div>
            </div>
            <div class="p-md">
              <h4 class="font-label-md text-lg mb-1">{{ s.brand }} {{ s.model }}</h4>
              <div class="flex gap-md text-on-surface-variant text-sm mb-md"><span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">settings_input_component</span> {{ s.transmission === 'automatic' ? 'أوتوماتيك' : 'يدوي' }}</span><span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">airline_seat_recline_extra</span> {{ s.seats }} مقاعد</span></div>
              <button class="w-full py-2 border border-outline-variant rounded-lg font-label-sm hover:border-primary hover:text-primary transition-all" @click="$router.push('/cars/' + s.id)">عرض التفاصيل</button>
            </div>
          </div>
        </div>
      </section>
    </main>
    <AppFooter />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'
import AppHeader from '@/components/AppHeader.vue'
import AppFooter from '@/components/AppFooter.vue'

const route = useRoute()
const car = ref(null)
const similarCars = ref([])
const loading = ref(true)
const selectedImage = ref('')

const carImages = computed(() => car.value?.images || [])
const visibleThumbnails = computed(() => carImages.value.slice(0, 4))

function getImageUrl(img) {
  return img?.image_path ? '/storage/' + img.image_path : '/images/cd-main.jpg'
}

onMounted(async () => {
  try {
    const res = await axios.get('/api/cars/' + route.params.id)
    car.value = res.data
    if (car.value.images && car.value.images.length > 0) {
      selectedImage.value = getImageUrl(car.value.images[0])
    } else {
      selectedImage.value = '/images/cd-main.jpg'
    }
    const similarRes = await axios.get('/api/cars/' + route.params.id + '/similar')
    similarCars.value = similarRes.data
  } catch {
    car.value = null
  } finally {
    loading.value = false
  }
})
</script>
