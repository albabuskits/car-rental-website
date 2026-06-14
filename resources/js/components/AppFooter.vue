<template>
  <footer class="bg-primary-container dark:bg-[#0f172a] text-surface-container-lowest dark:text-on-surface w-full py-xl px-gutter">
    <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-lg max-w-[1280px] mx-auto border-b border-outline-variant/20 dark:border-outline-variant/10 pb-xl">
      <div>
        <div class="text-headline-md font-bold text-on-primary-container dark:text-on-surface mb-md">عرب لتأجير السيارات</div>
        <p class="text-on-primary-container/70 dark:text-on-surface-variant text-body-md mb-lg max-w-sm">حلول تنقل راقية للأفراد وشركات. جودة تثق بها، وخدمة تستحقها.</p>
        <div class="flex gap-md">
          <a class="text-on-primary-container/70 dark:text-on-surface-variant hover:text-on-primary-container dark:hover:text-on-surface transition-colors" href="#"><span class="material-symbols-outlined">alternate_email</span></a>
          <a class="text-on-primary-container/70 dark:text-on-surface-variant hover:text-on-primary-container dark:hover:text-on-surface transition-colors" href="#"><span class="material-symbols-outlined">public</span></a>
        </div>
      </div>
      <div class="grid grid-cols-2 gap-md">
        <div>
          <h4 class="font-bold mb-md text-on-primary-container dark:text-on-surface">الشركة</h4>
          <ul class="flex flex-col gap-xs">
            <li><router-link class="text-on-primary-container/70 dark:text-on-surface-variant hover:text-on-primary-container dark:hover:text-on-surface transition-colors text-label-sm" to="/about-us">من نحن</router-link></li>
            <li><router-link class="text-on-primary-container/70 dark:text-on-surface-variant hover:text-on-primary-container dark:hover:text-on-surface transition-colors text-label-sm" to="/cars">أسطولنا</router-link></li>
            <li><a class="text-on-primary-container/70 dark:text-on-surface-variant hover:text-on-primary-container dark:hover:text-on-surface transition-colors text-label-sm" href="#">المواقع</a></li>
            <li><a class="text-on-primary-container/70 dark:text-on-surface-variant hover:text-on-primary-container dark:hover:text-on-surface transition-colors text-label-sm" href="#">الوظائف</a></li>
          </ul>
        </div>
        <div>
          <h4 class="font-bold mb-md text-on-primary-container dark:text-on-surface">الدعم</h4>
          <ul class="flex flex-col gap-xs">
            <li><a class="text-on-primary-container/70 dark:text-on-surface-variant hover:text-on-primary-container dark:hover:text-on-surface transition-colors text-label-sm" href="#">سياسة الخصوصية</a></li>
            <li><a class="text-on-primary-container/70 dark:text-on-surface-variant hover:text-on-primary-container dark:hover:text-on-surface transition-colors text-label-sm" href="#">شروط الخدمة</a></li>
            <li><a class="text-on-primary-container/70 dark:text-on-surface-variant hover:text-on-primary-container dark:hover:text-on-surface transition-colors text-label-sm" href="#">الأسئلة الشائعة</a></li>
            <li><router-link class="text-on-primary-container/70 dark:text-on-surface-variant hover:text-on-primary-container dark:hover:text-on-surface transition-colors text-label-sm" to="/contact-us">اتصل بنا</router-link></li>
          </ul>
        </div>
      </div>
      <div>
        <h4 class="font-bold mb-md text-on-primary-container dark:text-on-surface">معلومات الاتصال</h4>
        <ul class="flex flex-col gap-md">
          <li class="flex gap-md"><span class="material-symbols-outlined text-on-primary-container dark:text-on-surface">location_on</span><span class="text-label-sm text-on-primary-container/70 dark:text-on-surface-variant">شارع الشيخ زايد، دبي، الإمارات</span></li>
          <li class="flex gap-md"><span class="material-symbols-outlined text-on-primary-container dark:text-on-surface">call</span><span class="text-label-sm text-on-primary-container/70 dark:text-on-surface-variant">+971 4 000 0000</span></li>
          <li class="flex gap-md"><span class="material-symbols-outlined text-on-primary-container dark:text-on-surface">mail</span><span class="text-label-sm text-on-primary-container/70 dark:text-on-surface-variant">info@arhabcarrental.com</span></li>
        </ul>
      </div>
    </div>
    <div class="max-w-[1280px] mx-auto pt-lg flex flex-col md:flex-row justify-between items-center gap-md">
      <p class="text-label-sm text-on-primary-container/70 dark:text-on-surface-variant">© 2024 مكتب عرب لتأجير السيارات. جميع الحقوق محفوظة.</p>
    </div>
  </footer>
</template>