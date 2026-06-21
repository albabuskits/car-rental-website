<template>
  <div>
    <AppHeader />
    <main class="mt-16">
      <section class="relative h-[640px] w-full flex items-center overflow-hidden">
        <div class="absolute inset-0">
          <img loading="lazy" class="w-full h-full object-cover" src="/images/hero-bg.jpg"/>
          <div class="absolute inset-0 hero-gradient"></div>
        </div>
        <div class="relative z-10 w-full max-w-[1280px] mx-auto px-gutter text-on-tertiary">
          <h1 class="font-display-lg text-display-lg max-w-2xl mb-md">تنقل راقي للمحترفين</h1>
          <p class="font-body-lg text-body-lg max-w-xl mb-xl text-surface-container">عرب تقدم أسطولاً من السيارات الفاخرة والشركات التي تمت صيانتها بعناية لتتناسب مع رحلتك.</p>
          <div class="bg-surface rounded-xl p-md car-card-shadow flex flex-col lg:flex-row items-stretch lg:items-center gap-md max-w-4xl">
            <div class="flex-1 flex flex-col gap-1 px-4 border-b lg:border-b-0 lg:border-l border-outline-variant">
              <label class="font-label-sm text-label-sm text-on-surface-variant">موقع الاستلام</label>
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">location_on</span>
                <input class="w-full border-none focus:ring-0 bg-transparent text-on-surface font-label-md p-0" placeholder="مطار دبي الدولي" type="text"/>
              </div>
            </div>
            <div class="flex-1 flex flex-col gap-1 px-4 border-b lg:border-b-0 lg:border-l border-outline-variant">
              <label class="font-label-sm text-label-sm text-on-surface-variant">تاريخ ووقت الاستلام</label>
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">calendar_today</span>
                <input class="w-full border-none focus:ring-0 bg-transparent text-on-surface font-label-md p-0" type="datetime-local"/>
              </div>
            </div>
            <div class="flex-1 flex flex-col gap-1 px-4">
              <label class="font-label-sm text-label-sm text-on-surface-variant">تاريخ ووقت الإرجاع</label>
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">history</span>
                <input class="w-full border-none focus:ring-0 bg-transparent text-on-surface font-label-md p-0" type="datetime-local"/>
              </div>
            </div>
            <button class="bg-primary text-on-primary h-12 px-12 rounded-lg font-label-md text-label-md hover:bg-primary-container transition-all flex items-center justify-center gap-2 min-w-[240px]" @click="$router.push('/cars')">
              <span class="material-symbols-outlined">search</span>
              بحث عن سيارة
            </button>
          </div>
        </div>
      </section>
      <section class="py-xl max-w-[1280px] mx-auto px-gutter">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-xl gap-md">
          <div>
            <h2 class="font-headline-lg text-headline-lg text-primary mb-2">الأسطول المميز</h2>
            <p class="text-on-surface-variant">اختر من بين مجموعتنا الممتازة من السيارات المتاحة.</p>
          </div>
          <div class="flex flex-wrap gap-xs">
            <button class="px-md py-2 rounded-full bg-primary text-on-primary font-label-md text-label-md" @click="$router.push('/cars')">جميع السيارات</button>
            <button class="px-md py-2 rounded-full bg-surface-container-low text-primary font-label-md text-label-md hover:bg-surface-container-high transition-colors" @click="$router.push('/cars')">فاخرة</button>
            <button class="px-md py-2 rounded-full bg-surface-container-low text-primary font-label-md text-label-md hover:bg-surface-container-high transition-colors" @click="$router.push('/cars')">دفع رباعي</button>
            <button class="px-md py-2 rounded-full bg-surface-container-low text-primary font-label-md text-label-md hover:bg-surface-container-high transition-colors" @click="$router.push('/cars')">كهربائية</button>
          </div>
        </div>
        <div v-if="featuredCars.length === 0" class="text-center py-xl text-on-surface-variant">لا توجد سيارات مميزة حالياً.</div>
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-lg">
          <div v-for="car in featuredCars" :key="car.id" class="bg-surface rounded-xl overflow-hidden car-card-shadow group">
            <div class="relative h-56 overflow-hidden">
              <img loading="lazy" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" :src="car.images && car.images.length ? '/storage/' + car.images[0].image_path : '/images/fleet-car1.jpg'"/>
              <div class="absolute top-4 right-4" :class="!car.next_available_date ? 'bg-green-600' : 'bg-amber-600'"><span class="text-white px-3 py-1 rounded-full text-label-sm font-label-md block">{{ !car.next_available_date ? 'متاحة الآن' : 'متاحة من ' + car.next_available_date }}</span></div>
            </div>
            <div class="p-md">
              <div class="flex justify-between items-start mb-md">
                <div>
                  <h3 class="font-headline-md text-headline-md text-on-surface">{{ car.brand }} {{ car.model }}</h3>
                  <p class="text-on-surface-variant text-label-sm">{{ car.category }}</p>
                </div>
                <div class="text-right">
                  <span class="text-primary font-bold text-headline-md">${{ Number(car.price_per_day).toFixed(0) }}</span>
                  <span class="text-on-surface-variant text-label-sm block">/ يوم</span>
                </div>
              </div>
              <div class="flex items-center justify-between border-y border-outline-variant py-md mb-md">
                <div class="flex items-center gap-1 text-on-surface-variant">
                  <span class="material-symbols-outlined text-md">airline_seat_recline_extra</span>
                  <span class="text-label-sm">{{ car.seats }} مقاعد</span>
                </div>
                <div class="flex items-center gap-1 text-on-surface-variant">
                  <span class="material-symbols-outlined text-md">settings</span>
                  <span class="text-label-sm">{{ car.transmission === 'automatic' ? 'أوتوماتيك' : 'يدوي' }}</span>
                </div>
                <div class="flex items-center gap-1 text-on-surface-variant">
                  <span class="material-symbols-outlined text-md">{{ car.fuel_type === 'electric' ? 'bolt' : car.fuel_type === 'hybrid' ? 'ev_station' : 'local_gas_station' }}</span>
                  <span class="text-label-sm">{{ car.fuel_type }}</span>
                </div>
              </div>
              <button class="w-full py-md border-2 border-primary text-primary font-bold rounded-lg hover:bg-primary hover:text-on-primary transition-all" @click="$router.push('/cars/' + car.id)">عرض التفاصيل</button>
            </div>
          </div>
        </div>
      </section>
      <section class="bg-surface-container-low py-xl">
        <div class="max-w-[1280px] mx-auto px-gutter grid grid-cols-1 lg:grid-cols-2 gap-xl items-center">
          <div class="relative">
            <img loading="lazy" class="rounded-xl car-card-shadow w-full" src="/images/home-about.jpg"/>
            <div class="absolute -bottom-6 -right-6 bg-primary p-lg rounded-xl shadow-lg text-on-primary hidden md:block">
              <div class="font-display-lg text-4xl mb-1">15+</div>
              <div class="text-label-sm">سنوات من التميز</div>
            </div>
          </div>
          <div>
            <h2 class="font-headline-lg text-headline-lg text-primary mb-md">عن عرب لتأجير السيارات</h2>
            <p class="font-body-lg text-body-lg text-on-surface-variant mb-md leading-relaxed">تأسست عرب على مبادئ الكفاءة والفخامة، وكانت الشريك الموثوق للمسافرين والشركات في جميع أنحاء المنطقة. نحن نفخر بتقديم تجربة حجز سلسة وأسطول يلبي أعلى معايير السلامة والراحة.</p>
            <p class="font-body-lg text-body-lg text-on-surface-variant mb-xl leading-relaxed">التزامنا يتجاوز مجرد توفير السيارة؛ نحن نقدم حلاً للتنقل يحترم وقتك ويرفع من مكانتك.</p>
            <div class="flex flex-col sm:flex-row gap-md">
              <button class="bg-primary text-on-primary px-xl py-md rounded-lg font-bold hover:bg-primary-container transition-all" @click="$router.push('/about-us')">اعرف المزيد عنا</button>
              <button class="border-2 border-primary text-primary px-xl py-md rounded-lg font-bold hover:bg-primary hover:text-on-primary transition-all" @click="$router.push('/cars')">تصفح أسطولنا</button>
            </div>
          </div>
        </div>
      </section>
      <section class="py-xl max-w-[1280px] mx-auto px-gutter overflow-hidden">
        <div class="text-center mb-xl">
          <h2 class="font-headline-lg text-headline-lg text-primary mb-2">ماذا يقول عملاؤنا</h2>
          <div class="w-20 h-1 bg-primary mx-auto"></div>
        </div>
        <div class="relative" id="testimonial-slider">
          <div class="flex transition-transform duration-500 gap-md items-stretch" id="slider-track">
            <div class="min-w-full md:min-w-[calc(50%-12px)] lg:min-w-[calc(33.333%-16px)] bg-surface p-xl rounded-xl car-card-shadow flex flex-col justify-between">
              <div>
                <div class="flex text-primary mb-md">
                  <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                </div>
                <p class="italic text-on-surface-variant mb-xl">"خدمة عرب لا تضاهى. من لحظة حجزي لمرسيدس E-Class حتى إرجاعها في المطار، كان كل شيء احترافياً وسلساً. حقاً مكتب تأجير من الطراز الأول."</p>
              </div>
              <div class="flex items-center gap-md">
                <div class="w-12 h-12 rounded-full overflow-hidden bg-surface-container-high flex items-center justify-center text-primary font-bold">ج</div>
                <div>
                  <h4 class="font-bold text-on-surface">جيمس ويلسون</h4>
                  <p class="text-label-sm text-on-surface-variant">مسافر أعمال</p>
                </div>
              </div>
            </div>
            <div class="min-w-full md:min-w-[calc(50%-12px)] lg:min-w-[calc(33.333%-16px)] bg-surface p-xl rounded-xl car-card-shadow flex flex-col justify-between border-t-4 border-primary">
              <div>
                <div class="flex text-primary mb-md">
                  <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                </div>
                <p class="italic text-on-surface-variant mb-xl">"استئجار سيارة دفع رباعي لرحلة عائلتنا كان أفضل قرار. كانت السيارة بحالة ممتازة، واستغرق Process الاستلام أقل من 5 دقائق. أوصي بشدة لأي زائر."</p>
              </div>
              <div class="flex items-center gap-md">
                <div class="w-12 h-12 rounded-full overflow-hidden bg-surface-container-high flex items-center justify-center text-primary font-bold">س</div>
                <div>
                  <h4 class="font-bold text-on-surface">سارة الفايد</h4>
                  <p class="text-label-sm text-on-surface-variant">عميلة دائمة</p>
                </div>
              </div>
            </div>
            <div class="min-w-full md:min-w-[calc(50%-12px)] lg:min-w-[calc(33.333%-16px)] bg-surface p-xl rounded-xl car-card-shadow flex flex-col justify-between">
              <div>
                <div class="flex text-primary mb-md">
                  <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                </div>
                <p class="italic text-on-surface-variant mb-xl">"تسلا موديل S كانت مثالية لاجتماعات عملي. لقد تركت انطباعاً رائعاً وكانت تعليمات الشحن المقدمة من الموظفين مفيدة جداً. تجربة ممتازة."</p>
              </div>
              <div class="flex items-center gap-md">
                <div class="w-12 h-12 rounded-full overflow-hidden bg-surface-container-high flex items-center justify-center text-primary font-bold">م</div>
                <div>
                  <h4 class="font-bold text-on-surface">مارك تشانغ</h4>
                  <p class="text-label-sm text-on-surface-variant">رائد أعمال تقني</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
    <AppFooter />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import AppHeader from '@/components/AppHeader.vue'
import AppFooter from '@/components/AppFooter.vue'

const featuredCars = ref([])

onMounted(async () => {
  try {
    const res = await axios.get('/api/cars/featured')
    featuredCars.value = res.data
  } catch {}
  const track = document.getElementById('slider-track')
  if (!track) return
  let currentPos = 0
  function updateSlider() {
    const cardWidth = track.children[0].offsetWidth + 24
    track.style.transform = `translateX(-${currentPos * cardWidth}px)`
  }
  document.addEventListener('click', (e) => {
    if (e.target.closest('#nextBtn')) {
      const max = window.innerWidth >= 1024 ? track.children.length - 3 : window.innerWidth >= 768 ? track.children.length - 2 : track.children.length - 1
      if (currentPos < max) { currentPos++; updateSlider() }
    }
    if (e.target.closest('#prevBtn')) {
      if (currentPos > 0) { currentPos--; updateSlider() }
    }
  })
  window.addEventListener('scroll', () => {
    const header = document.querySelector('header')
    if (header) {
      if (window.scrollY > 20) header.classList.add('shadow-md')
      else header.classList.remove('shadow-md')
    }
  })
})
</script>