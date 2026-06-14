<template>
  <div>
    <AppHeader />
    <main class="pb-xl" style="padding-top: 5rem">
      <div class="max-w-[1280px] mx-auto px-gutter">
        <section class="mb-xl text-center">
          <h1 class="font-display-lg text-display-lg text-on-surface mb-xs">تواصل معنا</h1>
          <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">سواء كان لديك سؤال حول أسطولنا أو أسعارنا أو حسابات الشركات، فإن فريقنا المخصص هنا لتقديم دعم عالي الأداء.</p>
        </section>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-lg">
          <div class="lg:col-span-5 space-y-lg">
            <div class="bg-surface dark:bg-surface-container-high p-lg rounded-xl contact-shadow border border-outline-variant h-full flex flex-col justify-between">
              <div>
                <h2 class="font-headline-md text-headline-md text-primary mb-md">معلومات الاتصال</h2>
                <div class="space-y-md">
                  <div class="flex items-start gap-md">
                    <div class="w-12 h-12 bg-surface-container-low flex items-center justify-center rounded-lg text-primary"><span class="material-symbols-outlined">phone</span></div>
                    <div><p class="font-label-md text-label-md text-on-surface-variant">رقم الهاتف</p><p class="font-headline-md text-headline-md text-on-surface font-semibold">+1 (555) 000-ARHAB</p></div>
                  </div>
                  <div class="flex items-start gap-md">
                    <div class="w-12 h-12 bg-surface-container-low flex items-center justify-center rounded-lg text-primary"><span class="material-symbols-outlined">mail</span></div>
                    <div><p class="font-label-md text-label-md text-on-surface-variant">البريد الإلكتروني</p><p class="font-headline-md text-headline-md text-on-surface font-semibold">concierge@arhab.rentals</p></div>
                  </div>
                  <div class="flex items-start gap-md">
                    <div class="w-12 h-12 bg-surface-container-low flex items-center justify-center rounded-lg text-primary"><span class="material-symbols-outlined">location_on</span></div>
                    <div><p class="font-label-md text-label-md text-on-surface-variant">المقر الرئيسي</p><p class="font-body-md text-body-md text-on-surface">1200 مركز الأعمال، الطابق 4<br/>المنطقة المالية، دبي، الإمارات</p></div>
                  </div>
                </div>
              </div>
              <div class="pt-lg mt-xl border-t border-outline-variant">
                <h3 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-md">تواصل معنا</h3>
                <div class="flex gap-md">
                  <a class="w-10 h-10 flex items-center justify-center rounded-full bg-primary-container text-on-primary hover:scale-110 transition-transform" href="#"><span class="material-symbols-outlined">share</span></a>
                  <a class="w-10 h-10 flex items-center justify-center rounded-full border border-primary-container text-primary hover:bg-primary-container hover:text-on-primary transition-all" href="#"><span class="material-symbols-outlined">language</span></a>
                </div>
              </div>
            </div>
          </div>
          <div class="lg:col-span-7">
            <div class="bg-surface dark:bg-surface-container-high p-lg rounded-xl contact-shadow border border-outline-variant">
              <form class="space-y-md" id="contactForm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                  <div class="space-y-xs"><label class="font-label-md text-label-md text-on-surface-variant">الاسم الكامل</label><input class="w-full h-12 px-md border-outline-variant rounded-lg focus:ring-secondary focus:border-secondary transition-all" placeholder="محمد أحمد" required type="text"/></div>
                  <div class="space-y-xs"><label class="font-label-md text-label-md text-on-surface-variant">البريد الإلكتروني</label><input class="w-full h-12 px-md border-outline-variant rounded-lg focus:ring-secondary focus:border-secondary transition-all" placeholder="mohamed@example.com" required type="email"/></div>
                </div>
                <div class="space-y-xs"><label class="font-label-md text-label-md text-on-surface-variant">الموضوع</label>
                  <select class="w-full h-12 px-md border-outline-variant rounded-lg focus:ring-secondary focus:border-secondary transition-all appearance-none bg-no-repeat">
                    <option>استفسار عام</option>
                    <option>شراكة مؤسسية</option>
                    <option>تخصيص الأسطول</option>
                    <option>تعديل الحجز</option>
                    <option>دعم الفواتير</option>
                  </select>
                </div>
                <div class="space-y-xs"><label class="font-label-md text-label-md text-on-surface-variant">رسالتك</label><textarea class="w-full p-md border-outline-variant rounded-lg focus:ring-secondary focus:border-secondary transition-all" placeholder="كيف يمكن لفريق الخدمات اللوجستية لدينا مساعدتك اليوم؟" required rows="5"></textarea></div>
                <button class="w-full h-12 bg-primary text-on-primary font-label-md text-label-md rounded-lg hover:opacity-95 active:scale-[0.98] transition-all flex items-center justify-center gap-sm" type="submit">
                  <span>إرسال الرسالة</span>
                  <span class="material-symbols-outlined text-[18px] rtl-flip">send</span>
                </button>
              </form>
            </div>
          </div>
        </div>
        <section class="mt-xl relative rounded-2xl overflow-hidden h-[450px] shadow-lg border border-outline-variant">
          <div class="absolute inset-0 z-0 bg-surface-container-high">
            <img class="w-full h-full object-cover filter grayscale-[40%] contrast-[1.1]" src="/images/contact-map.jpg"/>
          </div>
          <div class="absolute top-md right-md z-10 glass-card p-md rounded-xl max-w-sm pointer-events-none">
            <h3 class="font-headline-md text-headline-md text-primary mb-xs">اعثر علينا</h3>
            <p class="font-body-md text-body-md text-on-surface mb-md">يقع مكتبنا الرئيسي في قلب المدينة، ويمكن الوصول إليه بسهولة من جميع الطرق السريعة الرئيسية.</p>
            <div class="flex items-center gap-xs text-primary font-label-md"><span class="material-symbols-outlined">directions</span><span>اتجاهات الوصول</span></div>
          </div>
        </section>
        <section class="mt-xl text-center py-xl bg-surface-container-low rounded-2xl">
          <h2 class="font-headline-md text-headline-md text-on-surface mb-md">لا يزال لديك أسئلة؟</h2>
          <p class="font-body-md text-body-md text-on-surface-variant mb-lg">تحقق من الأسئلة الشائعة للحصول على إجابات سريعة.</p>
          <a class="inline-flex items-center gap-sm px-lg py-md border-2 border-primary text-primary font-label-md rounded-lg hover:bg-primary hover:text-on-primary transition-all cursor-pointer">
            <span>زيارة مركز المساعدة</span>
            <span class="material-symbols-outlined rtl-flip">arrow_back</span>
          </a>
        </section>
      </div>
    </main>
    <AppFooter />
  </div>
</template>

<script setup>
import AppHeader from '@/components/AppHeader.vue'
import AppFooter from '@/components/AppFooter.vue'
</script>