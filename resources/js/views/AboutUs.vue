<template>
  <div>
    <AppHeader />
    <main>
      <section class="relative h-[614px] flex items-center justify-center overflow-hidden bg-on-surface">
        <div class="absolute inset-0 opacity-40">
          <img class="w-full h-full object-cover" src="/images/about-banner.jpg"/>
        </div>
        <div class="relative z-10 text-center px-gutter">
          <h1 class="font-display-lg text-display-lg text-white mb-md">إعادة تعريف الرحلة</h1>
          <p class="font-body-lg text-body-lg text-surface-container-lowest max-w-2xl mx-auto opacity-90">عرب لتأجير السيارات تقدم أكثر من مجرد مركبات. نحن نوفر حرية الاستكشاف بثقة، وراحة راقية، وخدمة لا مثيل لها.</p>
        </div>
        <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-surface to-transparent"></div>
      </section>
      <section class="py-xl px-gutter max-w-[1280px] mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-xl items-center">
          <div class="space-y-md">
            <span class="text-primary font-label-md text-label-md tracking-wider uppercase">قصتنا</span>
            <h2 class="font-headline-lg text-headline-lg text-on-surface">الدقة في كل ميل</h2>
            <p class="text-on-surface-variant font-body-md text-body-md leading-relaxed">تأسست عرب برؤية لإحداث ثورة في صناعة تأجير السيارات، ونمت من خدمة محلية إلى شركة رائدة إقليمياً. نحن نؤمن بأن الخدمات اللوجستية المهنية يجب أن تكون سلسة وشفافة ومصممة خصيصاً لتلبية احتياجات المسافر العصري.</p>
            <p class="text-on-surface-variant font-body-md text-body-md leading-relaxed">أسطولنا هو مجموعة منتقاة من المركبات عالية الأداء، تتراوح بين سيارات السيدان المؤسسية وسيارات الدفع الرباعي الفاخرة، مما يضمن أن كل عميل يجد الخيار الأمثل لوجهته.</p>
            <div class="flex gap-lg pt-md">
              <div><div class="text-primary font-headline-lg text-headline-lg">15+</div><div class="text-on-surface-variant font-label-sm text-label-sm">سنوات خبرة</div></div>
              <div><div class="text-primary font-headline-lg text-headline-lg">200+</div><div class="text-on-surface-variant font-label-sm text-label-sm">أسطول مميز</div></div>
              <div><div class="text-primary font-headline-lg text-headline-lg">50k</div><div class="text-on-surface-variant font-label-sm text-label-sm">عملاء سعداء</div></div>
            </div>
          </div>
          <div class="relative">
            <div class="rounded-xl overflow-hidden card-shadow">
              <img class="w-full aspect-[4/3] object-cover" src="/images/about-story.jpg"/>
            </div>
          </div>
        </div>
      </section>
      <section class="bg-surface-container-low py-xl px-gutter">
        <div class="max-w-[1280px] mx-auto">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
            <div class="md:col-span-2 bg-white p-xl rounded-xl card-shadow flex flex-col justify-center">
              <div class="bg-primary-container/10 w-12 h-12 rounded-lg flex items-center justify-center mb-md text-primary-container"><span class="material-symbols-outlined">rocket_launch</span></div>
              <h3 class="font-headline-md text-headline-md mb-sm">مهمتنا</h3>
              <p class="text-on-surface-variant font-body-md text-body-md">تقديم تجربة تأجير سيارات عالمية المستوى من خلال الجمع بين أحدث التقنيات والرعاية الشخصية للعملاء، مما يضمن أن تكون كل رحلة آمنة وأنيقة وفعالة.</p>
            </div>
            <div class="bg-primary-container p-xl rounded-xl card-shadow text-white">
              <div class="bg-white/20 w-12 h-12 rounded-lg flex items-center justify-center mb-md"><span class="material-symbols-outlined">visibility</span></div>
              <h3 class="font-headline-md text-headline-md mb-sm text-white">رؤيتنا</h3>
              <p class="text-on-primary-container font-body-md text-body-md">أن نكون الاسم الأكثر ثقة في مجال التنقل في جميع أنحاء المنطقة، واضعين المعيار الذهبي للجودة والخدمة المهنية في تأجير السيارات.</p>
            </div>
          </div>
        </div>
      </section>
      <section class="py-xl px-gutter max-w-[1280px] mx-auto">
        <div class="text-center mb-xl">
          <h2 class="font-headline-lg text-headline-lg mb-sm">لماذا تختار عرب؟</h2>
          <p class="text-on-surface-variant max-w-xl mx-auto">مبنية على أساس من الموثوقية والمعايير الراقية.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-lg">
          <div class="group p-lg bg-white rounded-xl card-shadow hover:bg-primary transition-all duration-300">
            <div class="w-12 h-12 rounded-lg bg-surface-container flex items-center justify-center mb-md group-hover:bg-white/20"><span class="material-symbols-outlined text-primary group-hover:text-white">payments</span></div>
            <h4 class="font-label-md text-label-md font-bold mb-xs group-hover:text-white">أفضل الأسعار</h4>
            <p class="text-on-surface-variant text-label-sm group-hover:text-white/80">أسعار تنافسية بدون رسوم خفية. نحن نقدر الشفافية في أسعارنا.</p>
          </div>
          <div class="group p-lg bg-white rounded-xl card-shadow hover:bg-primary transition-all duration-300">
            <div class="w-12 h-12 rounded-lg bg-surface-container flex items-center justify-center mb-md group-hover:bg-white/20"><span class="material-symbols-outlined text-primary group-hover:text-white">support_agent</span></div>
            <h4 class="font-label-md text-label-md font-bold mb-xs group-hover:text-white">دعم 24/7</h4>
            <p class="text-on-surface-variant text-label-sm group-hover:text-white/80">فريقنا المخصص متاح دائماً لمساعدتك، ليلاً ونهاراً.</p>
          </div>
          <div class="group p-lg bg-white rounded-xl card-shadow hover:bg-primary transition-all duration-300">
            <div class="w-12 h-12 rounded-lg bg-surface-container flex items-center justify-center mb-md group-hover:bg-white/20"><span class="material-symbols-outlined text-primary group-hover:text-white">verified_user</span></div>
            <h4 class="font-label-md text-label-md font-bold mb-xs group-hover:text-white">تأمين كامل</h4>
            <p class="text-on-surface-variant text-label-sm group-hover:text-white/80">خيارات تغطية شاملة لمنحك راحة بال كاملة على الطريق.</p>
          </div>
          <div class="group p-lg bg-white rounded-xl card-shadow hover:bg-primary transition-all duration-300">
            <div class="w-12 h-12 rounded-lg bg-surface-container flex items-center justify-center mb-md group-hover:bg-white/20"><span class="material-symbols-outlined text-primary group-hover:text-white">car_repair</span></div>
            <h4 class="font-label-md text-label-md font-bold mb-xs group-hover:text-white">أسطول نظيف</h4>
            <p class="text-on-surface-variant text-label-sm group-hover:text-white/80">كل مركبة تخضع لفحص صارم من 50 نقطة قبل كل تأجير.</p>
          </div>
        </div>
      </section>
      <section class="bg-on-tertiary-fixed dark:bg-surface-container-high py-xl px-gutter">
        <div class="max-w-[1280px] mx-auto">
          <div class="flex flex-col md:flex-row md:justify-between md:items-end mb-xl gap-md">
            <div><h2 class="font-headline-lg text-headline-lg text-white dark:text-on-surface mb-sm">العقول وراء عرب</h2><p class="text-on-tertiary-container dark:text-on-surface-variant max-w-xl">فريق من خبراء الصناعة المكرسين لإعادة تعريف معايير تأجير السيارات.</p></div>
            <button class="border border-outline-variant text-white dark:text-on-surface px-md py-xs rounded-lg hover:bg-white/10 dark:hover:bg-surface-container-highest transition-all font-label-md text-label-md">انضم إلى فريقنا</button>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-lg">
            <div class="group"><div class="relative aspect-square rounded-xl overflow-hidden mb-md grayscale group-hover:grayscale-0 transition-all duration-500"><img class="w-full h-full object-cover" src="/images/team-khaled.jpg"/></div><h5 class="text-white dark:text-on-surface font-headline-md text-headline-md mb-xs">خالد المنصور</h5><p class="text-on-tertiary-container dark:text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wider">المدير العام</p></div>
            <div class="group"><div class="relative aspect-square rounded-xl overflow-hidden mb-md grayscale group-hover:grayscale-0 transition-all duration-500"><img class="w-full h-full object-cover" src="/images/team-sara.jpg"/></div><h5 class="text-white dark:text-on-surface font-headline-md text-headline-md mb-xs">سارة جينكينز</h5><p class="text-on-tertiary-container dark:text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wider">رئيس العمليات</p></div>
            <div class="group"><div class="relative aspect-square rounded-xl overflow-hidden mb-md grayscale group-hover:grayscale-0 transition-all duration-500"><img class="w-full h-full object-cover" src="/images/team-omar.jpg"/></div><h5 class="text-white dark:text-on-surface font-headline-md text-headline-md mb-xs">عمر رشيد</h5><p class="text-on-tertiary-container dark:text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wider">مدير الأسطول</p></div>
            <div class="group"><div class="relative aspect-square rounded-xl overflow-hidden mb-md grayscale group-hover:grayscale-0 transition-all duration-500"><img class="w-full h-full object-cover" src="/images/team-lina.jpg"/></div><h5 class="text-white dark:text-on-surface font-headline-md text-headline-md mb-xs">لينا تشين</h5><p class="text-on-tertiary-container dark:text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wider">تجربة العملاء</p></div>
          </div>
        </div>
      </section>
      <section class="py-xl px-gutter text-center bg-surface">
        <div class="max-w-2xl mx-auto py-xl bg-white rounded-2xl card-shadow border border-surface-container">
          <h2 class="font-headline-lg text-headline-lg mb-md">هل أنت مستعد لبدء رحلتك؟</h2>
          <p class="text-on-surface-variant mb-xl">اختبر فرق عرب اليوم مع أسطولنا المميز وخدمتنا المهنية.</p>
          <div class="flex flex-col sm:flex-row gap-md justify-center">
            <button class="bg-primary text-white px-xl py-md rounded-lg font-bold hover:opacity-90 active:scale-95 transition-all" @click="$router.push('/cars')">تصفح السيارات</button>
            <button class="border-2 border-primary text-primary px-xl py-md rounded-lg font-bold hover:bg-primary/5 active:scale-95 transition-all" @click="$router.push('/contact-us')">اتصل بنا</button>
          </div>
        </div>
      </section>
    </main>
    <AppFooter />
  </div>
</template>

<script setup>
import AppHeader from '@/components/AppHeader.vue'
import AppFooter from '@/components/AppFooter.vue'
</script>