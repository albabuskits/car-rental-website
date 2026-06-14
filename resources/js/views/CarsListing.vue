<template>
  <div>
    <AppHeader />
    <main class="max-w-[1280px] mx-auto px-gutter py-lg" style="margin-top: 4rem">
      <section class="mb-xl">
        <div class="bg-surface-container-lowest car-card-shadow rounded-xl p-md flex flex-col md:flex-row gap-md items-center">
          <div class="relative w-full">
            <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline">search</span>
            <input v-model="searchQuery" @input="fetchCars()" class="w-full pr-xl pl-md py-md bg-surface-container-low border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent outline-none font-body-md text-body-md transition-all" placeholder="ابحث عن طراز أو علامة تجارية..." type="text"/>
          </div>
          <div class="flex gap-sm w-full md:w-auto">
            <select v-model="sortBy" @change="fetchCars()" class="bg-surface-container-low border border-outline-variant rounded-lg px-md py-md font-label-md text-label-md text-on-surface-variant focus:ring-2 focus:ring-secondary outline-none transition-all">
              <option value="">ترتيب حسب: المميز</option>
              <option value="price_asc">السعر: من الأقل إلى الأعلى</option>
              <option value="price_desc">السعر: من الأعلى إلى الأقل</option>
              <option value="newest">الأحدث أولاً</option>
            </select>
          </div>
        </div>
      </section>
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-xl">
        <aside class="lg:col-span-3 space-y-lg">
          <div class="bg-surface-container-low p-lg rounded-xl sticky top-24">
            <div class="flex justify-between items-center mb-md">
              <h3 class="font-headline-md text-headline-md text-primary">تصفية</h3>
              <button @click="clearFilters" class="text-label-sm font-label-sm text-secondary hover:underline">مسح الكل</button>
            </div>
            <div class="mb-lg">
              <p class="font-label-md text-label-md text-on-surface-variant mb-md">نوع السيارة</p>
              <div class="flex flex-wrap gap-xs">
                <button :class="categoryFilter === '' ? 'bg-primary text-on-primary' : 'bg-surface-container-highest text-secondary'" class="px-sm py-xs rounded-lg font-label-sm text-label-sm transition-all" @click="categoryFilter = ''; fetchCars()">الكل</button>
                <button :class="categoryFilter === 'suv' ? 'bg-primary text-on-primary' : 'bg-surface-container-highest text-secondary'" class="px-sm py-xs rounded-lg font-label-sm text-label-sm hover:bg-secondary-container hover:text-white transition-all" @click="categoryFilter = 'suv'; fetchCars()">دفع رباعي</button>
                <button :class="categoryFilter === 'sedan' ? 'bg-primary text-on-primary' : 'bg-surface-container-highest text-secondary'" class="px-sm py-xs rounded-lg font-label-sm text-label-sm hover:bg-secondary-container hover:text-white transition-all" @click="categoryFilter = 'sedan'; fetchCars()">سيدان</button>
                <button :class="categoryFilter === 'luxury' ? 'bg-primary text-on-primary' : 'bg-surface-container-highest text-secondary'" class="px-sm py-xs rounded-lg font-label-sm text-label-sm hover:bg-secondary-container hover:text-white transition-all" @click="categoryFilter = 'luxury'; fetchCars()">فاخرة</button>
                <button :class="categoryFilter === 'electric' ? 'bg-primary text-on-primary' : 'bg-surface-container-highest text-secondary'" class="px-sm py-xs rounded-lg font-label-sm text-label-sm hover:bg-secondary-container hover:text-white transition-all" @click="categoryFilter = 'electric'; fetchCars()">كهربائية</button>
              </div>
            </div>
            <div class="mb-lg">
              <p class="font-label-md text-label-md text-on-surface-variant mb-sm">العلامة التجارية</p>
              <div class="space-y-xs">
                <label class="flex items-center gap-sm cursor-pointer"><input v-model="brandFilter" value="مرسيدس-بنز" class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary" type="checkbox" @change="fetchCars()"/><span class="font-body-md text-body-md">مرسيدس-بنز</span></label>
                <label class="flex items-center gap-sm cursor-pointer"><input v-model="brandFilter" value="بي إم دبليو" class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary" type="checkbox" @change="fetchCars()"/><span class="font-body-md text-body-md">بي إم دبليو</span></label>
                <label class="flex items-center gap-sm cursor-pointer"><input v-model="brandFilter" value="أودي" class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary" type="checkbox" @change="fetchCars()"/><span class="font-body-md text-body-md">أودي</span></label>
                <label class="flex items-center gap-sm cursor-pointer"><input v-model="brandFilter" value="تسلا" class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary" type="checkbox" @change="fetchCars()"/><span class="font-body-md text-body-md">تسلا</span></label>
              </div>
            </div>
            <div class="mb-lg">
              <p class="font-label-md text-label-md text-on-surface-variant mb-sm">نطاق السعر (يومي)</p>
              <input v-model.number="priceRange" @input="fetchCars()" class="w-full h-2 bg-outline-variant rounded-lg appearance-none cursor-pointer accent-primary" max="1000" min="50" type="range"/>
              <div class="flex justify-between mt-sm text-label-sm font-label-sm text-on-surface-variant">
                <span>$50</span>
                <span>${{ priceRange }}+</span>
              </div>
            </div>
            <div class="mb-lg">
              <p class="font-label-md text-label-md text-on-surface-variant mb-sm">ناقل الحركة</p>
              <div class="flex gap-sm">
                <label class="flex-1 text-center cursor-pointer"><input v-model="transmissionFilter" value="automatic" class="hidden peer" name="trans" type="radio" @change="fetchCars()"/><div class="py-xs rounded-lg border border-outline-variant peer-checked:bg-secondary-container peer-checked:text-white peer-checked:border-secondary-container transition-all font-label-sm text-label-sm">أوتوماتيك</div></label>
                <label class="flex-1 text-center cursor-pointer"><input v-model="transmissionFilter" value="manual" class="hidden peer" name="trans" type="radio" @change="fetchCars()"/><div class="py-xs rounded-lg border border-outline-variant peer-checked:bg-secondary-container peer-checked:text-white peer-checked:border-secondary-container transition-all font-label-sm text-label-sm">يدوي</div></label>
              </div>
            </div>
            <button @click="fetchCars()" class="w-full bg-primary py-md rounded-lg text-on-primary font-label-md text-label-md hover:opacity-90 transition-all shadow-md">تطبيق التصفية</button>
          </div>
        </aside>
        <section class="lg:col-span-9">
          <div v-if="loading" class="text-center py-xl text-on-surface-variant">جاري التحميل...</div>
          <div v-else-if="cars.length === 0" class="text-center py-xl text-on-surface-variant">لا توجد سيارات متاحة.</div>
          <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-lg">
            <div v-for="car in cars" :key="car.id" class="bg-surface-container-lowest rounded-xl overflow-hidden car-card-shadow group border border-transparent hover:border-outline-variant transition-all">
              <div class="relative h-48 overflow-hidden">
                <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" :src="car.images && car.images.length ? '/storage/' + car.images[0].image_path : '/images/cl-car1.jpg'"/>
              </div>
              <div class="p-md">
                <div class="flex justify-between items-start mb-sm">
                  <div><h3 class="font-headline-md text-headline-md text-on-surface">{{ car.brand }} {{ car.model }}</h3><p class="font-body-md text-body-md text-on-surface-variant">{{ car.category }} • {{ car.year }}</p></div>
                </div>
                <div class="flex gap-md py-sm mb-md border-y border-outline-variant/30">
                  <div class="flex items-center gap-xs"><span class="material-symbols-outlined text-secondary text-sm">settings</span><span class="font-label-sm text-label-sm">{{ car.transmission === 'automatic' ? 'أوتوماتيك' : 'يدوي' }}</span></div>
                  <div class="flex items-center gap-xs"><span class="material-symbols-outlined text-secondary text-sm">local_gas_station</span><span class="font-label-sm text-label-sm">{{ car.fuel_type }}</span></div>
                  <div class="flex items-center gap-xs"><span class="material-symbols-outlined text-secondary text-sm">group</span><span class="font-label-sm text-label-sm">{{ car.seats }} مقاعد</span></div>
                </div>
                <div class="flex justify-between items-center">
                  <div><span class="font-headline-md text-headline-md text-primary">${{ Number(car.price_per_day).toFixed(0) }}</span><span class="font-label-sm text-label-sm text-on-surface-variant">/ يوم</span></div>
                  <button class="bg-secondary-container text-white px-lg py-sm rounded-lg font-label-md text-label-md hover:opacity-90 active:scale-95 transition-all" @click="$router.push('/cars/' + car.id)">عرض التفاصيل</button>
                </div>
              </div>
            </div>
          </div>
          <div v-if="totalPages > 1" class="mt-xl flex justify-center items-center gap-sm">
            <button :disabled="currentPage <= 1" class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container-high transition-all" :class="{'opacity-50': currentPage <= 1}" @click="goToPage(currentPage - 1)"><span class="material-symbols-outlined rtl-flip">chevron_right</span></button>
            <button v-for="p in totalPages" :key="p" class="w-10 h-10 flex items-center justify-center rounded-lg font-label-md" :class="p === currentPage ? 'bg-primary text-on-primary' : 'border border-outline-variant text-on-surface-variant hover:bg-surface-container-high transition-all'" @click="goToPage(p)">{{ p }}</button>
            <button :disabled="currentPage >= totalPages" class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container-high transition-all" :class="{'opacity-50': currentPage >= totalPages}" @click="goToPage(currentPage + 1)"><span class="material-symbols-outlined rtl-flip">chevron_left</span></button>
          </div>
        </section>
      </div>
    </main>
    <AppFooter />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import AppHeader from '@/components/AppHeader.vue'
import AppFooter from '@/components/AppFooter.vue'

const cars = ref([])
const loading = ref(true)
const searchQuery = ref('')
const categoryFilter = ref('')
const brandFilter = ref([])
const priceRange = ref(1000)
const transmissionFilter = ref('')
const sortBy = ref('')
const currentPage = ref(1)
const totalPages = ref(1)

function clearFilters() {
  categoryFilter.value = ''
  brandFilter.value = []
  priceRange.value = 1000
  transmissionFilter.value = ''
  searchQuery.value = ''
  sortBy.value = ''
  currentPage.value = 1
  fetchCars()
}

function goToPage(page) {
  if (page < 1 || page > totalPages.value) return
  currentPage.value = page
  fetchCars()
}

async function fetchCars() {
  loading.value = true
  try {
    const params = { page: currentPage.value }
    if (searchQuery.value) params.search = searchQuery.value
    if (categoryFilter.value) params.category = categoryFilter.value
    if (brandFilter.value.length) params.brands = brandFilter.value.join(',')
    if (priceRange.value < 1000) params.max_price = priceRange.value
    if (transmissionFilter.value) params.transmission = transmissionFilter.value
    if (sortBy.value) params.sort = sortBy.value
    const res = await axios.get('/api/cars', { params })
    cars.value = res.data.data || res.data
    totalPages.value = res.data.last_page || 1
  } catch {
    cars.value = []
  } finally {
    loading.value = false
  }
}

onMounted(fetchCars)
</script>