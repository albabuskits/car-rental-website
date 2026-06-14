<template>
  <div class="flex min-h-screen text-on-surface bg-surface">
    <nav class="hidden lg:flex flex-col h-screen fixed right-0 top-0 border-l border-outline-variant bg-surface-container-low w-64 z-50">
      <div class="p-lg"><h1 class="font-headline-md text-headline-md text-primary tracking-tight">عرب للإدارة</h1><p class="font-label-sm text-on-surface-variant mt-xs">مدير الأسطول</p></div>
      <div class="mt-md flex-grow space-y-xs px-sm">
        <a class="flex items-center gap-sm px-md py-sm rounded-lg active-nav-bg text-secondary font-bold transition-all hover:bg-surface-container-high scale-98" href="#"><span class="material-symbols-outlined">dashboard</span><span class="font-label-md text-label-md">لوحة التحكم</span></a>
        <a class="flex items-center gap-sm px-md py-sm rounded-lg text-on-surface-variant font-medium transition-all hover:bg-surface-container-high duration-200" href="#"><span class="material-symbols-outlined">directions_car</span><span class="font-label-md text-label-md">السيارات</span></a>
        <a class="flex items-center gap-sm px-md py-sm rounded-lg text-on-surface-variant font-medium transition-all hover:bg-surface-container-high duration-200" href="#"><span class="material-symbols-outlined">calendar_month</span><span class="font-label-md text-label-md">الحجوزات</span></a>
        <a class="flex items-center gap-sm px-md py-sm rounded-lg text-on-surface-variant font-medium transition-all hover:bg-surface-container-high duration-200" href="#"><span class="material-symbols-outlined">settings</span><span class="font-label-md text-label-md">الإعدادات</span></a>
      </div>
      <div class="p-lg mt-auto border-t border-outline-variant">
        <button class="w-full py-md bg-primary-container text-on-secondary rounded-lg font-label-md flex items-center justify-center gap-xs hover:opacity-90 transition-all"><span class="material-symbols-outlined text-[20px]">add</span>إضافة سيارة جديدة</button>
        <div class="mt-lg flex items-center gap-sm">
          <img class="w-10 h-10 rounded-full object-cover" src="/images/admin-profile.jpg"/>
          <div><p class="font-label-md text-on-surface">أليكس ريفيرا</p><p class="text-[12px] text-on-surface-variant">مسؤول النظام</p></div>
        </div>
      </div>
    </nav>
    <main class="lg:mr-64 min-h-screen w-full">
      <header class="h-16 flex items-center justify-between px-gutter bg-surface custom-shadow sticky top-0 z-40">
        <div class="flex items-center gap-md">
          <button class="lg:hidden p-xs text-on-surface"><span class="material-symbols-outlined">menu</span></button>
          <h2 class="font-headline-md text-headline-md text-on-surface">نظرة عامة على لوحة التحكم</h2>
        </div>
        <div class="flex items-center gap-md">
          <button class="p-xs text-on-surface-variant hover:text-primary transition-colors"><span class="material-symbols-outlined">notifications</span></button>
          <div class="h-8 w-[1px] bg-outline-variant"></div>
          <div class="flex items-center gap-xs"><span class="font-label-sm text-on-surface-variant">آخر تحديث: 12:45 م</span><span class="material-symbols-outlined text-[18px] text-secondary">sync</span></div>
        </div>
      </header>
      <div class="p-gutter max-w-[1280px] mx-auto space-y-xl">
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-lg">
          <div class="bg-surface custom-shadow p-lg rounded-xl flex flex-col justify-between border border-transparent hover:border-secondary-container transition-all group">
            <div class="flex justify-between items-start">
              <div class="w-12 h-12 bg-surface-container-high rounded-lg flex items-center justify-center text-secondary group-hover:bg-secondary group-hover:text-on-secondary transition-colors"><span class="material-symbols-outlined">directions_car</span></div>
              <span class="text-label-sm flex items-center text-green-600"><span class="material-symbols-outlined text-[16px]">trending_up</span>+12%</span>
            </div>
            <div class="mt-md"><p class="font-label-sm text-on-surface-variant">إجمالي السيارات</p><h3 class="font-display-lg text-display-lg text-on-surface mt-xs tracking-tight">142</h3></div>
          </div>
          <div class="bg-surface custom-shadow p-lg rounded-xl flex flex-col justify-between border border-transparent hover:border-secondary-container transition-all group">
            <div class="flex justify-between items-start">
              <div class="w-12 h-12 bg-surface-container-high rounded-lg flex items-center justify-center text-secondary group-hover:bg-secondary group-hover:text-on-secondary transition-colors"><span class="material-symbols-outlined">event_available</span></div>
              <span class="text-label-sm flex items-center"><span class="material-symbols-outlined text-[16px]">trending_down</span>-2%</span>
            </div>
            <div class="mt-md"><p class="font-label-sm text-on-surface-variant">الحجوزات النشطة</p><h3 class="font-display-lg text-display-lg text-on-surface mt-xs tracking-tight">38</h3></div>
          </div>
          <div class="bg-surface custom-shadow p-lg rounded-xl flex flex-col justify-between border border-transparent hover:border-secondary-container transition-all group">
            <div class="flex justify-between items-start">
              <div class="w-12 h-12 bg-surface-container-high rounded-lg flex items-center justify-center text-secondary group-hover:bg-secondary group-hover:text-on-secondary transition-colors"><span class="material-symbols-outlined">group_add</span></div>
              <span class="text-label-sm flex items-center text-green-600"><span class="material-symbols-outlined text-[16px]">trending_up</span>+24%</span>
            </div>
            <div class="mt-md"><p class="font-label-sm text-on-surface-variant">عملاء جدد</p><h3 class="font-display-lg text-display-lg text-on-surface mt-xs tracking-tight">512</h3></div>
          </div>
          <div class="bg-primary-container p-lg rounded-xl flex flex-col justify-between text-on-secondary overflow-hidden relative">
            <div class="absolute -left-4 -top-4 opacity-10"><span class="material-symbols-outlined text-[120px]">payments</span></div>
            <div class="z-10"><p class="font-label-sm text-on-primary-container">إجمالي الإيرادات الشهرية</p><h3 class="font-display-lg text-display-lg mt-xs tracking-tight">$42.8k</h3></div>
            <button class="mt-md z-10 w-full py-sm bg-on-secondary text-primary font-label-md rounded-lg flex items-center justify-center gap-xs hover:bg-surface-container-lowest transition-colors">عرض التقرير <span class="material-symbols-outlined text-[18px] rtl-flip">arrow_back</span></button>
          </div>
        </section>
        <section class="bg-surface custom-shadow rounded-xl overflow-hidden border border-outline-variant">
          <div class="p-lg flex flex-col md:flex-row justify-between items-start md:items-center gap-md bg-surface">
            <div><h4 class="font-headline-md text-headline-md text-on-surface">أحدث الحجوزات</h4><p class="font-body-md text-on-surface-variant">إدارة أحدث حجوزات واستئجار السيارات.</p></div>
            <div class="flex gap-sm w-full md:w-auto">
              <div class="relative flex-grow md:w-64"><span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span><input class="w-full pr-10 pl-4 py-2 border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none text-body-md" placeholder="ابحث عن معرف الحجز..." type="text"/></div>
              <button class="px-md py-2 border border-outline-variant rounded-lg font-label-md text-on-surface flex items-center gap-xs hover:bg-surface-container-low transition-colors"><span class="material-symbols-outlined">filter_list</span>تصفية</button>
            </div>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full border-collapse">
              <thead><tr class="bg-surface-container-low">
                <th class="text-right p-md font-label-md text-on-surface border-b border-outline-variant">معرف الحجز</th>
                <th class="text-right p-md font-label-md text-on-surface border-b border-outline-variant">العميل</th>
                <th class="text-right p-md font-label-md text-on-surface border-b border-outline-variant">السيارة</th>
                <th class="text-right p-md font-label-md text-on-surface border-b border-outline-variant">المدة</th>
                <th class="text-right p-md font-label-md text-on-surface border-b border-outline-variant">الحالة</th>
                <th class="text-left p-md font-label-md text-on-surface border-b border-outline-variant">الإجراءات</th>
              </tr></thead>
              <tbody class="divide-y divide-outline-variant">
                <tr class="hover:bg-surface-container-low transition-colors">
                  <td class="p-md font-label-md text-secondary">#ARB-9281</td>
                  <td class="p-md"><div class="flex items-center gap-sm"><div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center text-xs font-bold text-primary">م.ج</div><div><p class="font-label-md text-on-surface">محمد جابر</p><p class="text-[12px] text-on-surface-variant">mohamed@example.com</p></div></div></td>
                  <td class="p-md"><p class="font-label-md text-on-surface">مرسيدس-بنز S-Class</p><p class="text-[12px] text-on-surface-variant">سيدان فاخرة</p></td>
                  <td class="p-md font-body-md text-on-surface-variant">12 مايو - 15 مايو</td>
                  <td class="p-md"><span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-[12px] font-bold">مؤكد</span></td>
                  <td class="p-md text-left"><button class="p-xs text-on-surface-variant hover:text-secondary transition-colors"><span class="material-symbols-outlined">visibility</span></button><button class="p-xs text-on-surface-variant hover:text-error transition-colors"><span class="material-symbols-outlined">cancel</span></button></td>
                </tr>
                <tr class="hover:bg-surface-container-low transition-colors">
                  <td class="p-md font-label-md text-secondary">#ARB-9285</td>
                  <td class="p-md"><div class="flex items-center gap-sm"><div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center text-xs font-bold text-primary">س.م</div><div><p class="font-label-md text-on-surface">سارة ميلر</p><p class="text-[12px] text-on-surface-variant">sarah.m@webmail.com</p></div></div></td>
                  <td class="p-md"><p class="font-label-md text-on-surface">تسلا موديل 3</p><p class="text-[12px] text-on-surface-variant">كهربائية رياضية</p></td>
                  <td class="p-md font-body-md text-on-surface-variant">14 مايو - 20 مايو</td>
                  <td class="p-md"><span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-[12px] font-bold">قيد التنفيذ</span></td>
                  <td class="p-md text-left"><button class="p-xs text-on-surface-variant hover:text-secondary transition-colors"><span class="material-symbols-outlined">visibility</span></button><button class="p-xs text-on-surface-variant hover:text-error transition-colors"><span class="material-symbols-outlined">cancel</span></button></td>
                </tr>
                <tr class="hover:bg-surface-container-low transition-colors">
                  <td class="p-md font-label-md text-secondary">#ARB-9290</td>
                  <td class="p-md"><div class="flex items-center gap-sm"><div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center text-xs font-bold text-primary">ر.ك</div><div><p class="font-label-md text-on-surface">روبرت كينغ</p><p class="text-[12px] text-on-surface-variant">r.king@corplogistics.com</p></div></div></td>
                  <td class="p-md"><p class="font-label-md text-on-surface">لاند روفر ديفندر</p><p class="text-[12px] text-on-surface-variant">دفع رباعي فاخر</p></td>
                  <td class="p-md font-body-md text-on-surface-variant">18 مايو - 21 مايو</td>
                  <td class="p-md"><span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-[12px] font-bold">معلق</span></td>
                  <td class="p-md text-left"><button class="p-xs text-on-surface-variant hover:text-secondary transition-colors"><span class="material-symbols-outlined">visibility</span></button><button class="p-xs text-on-surface-variant hover:text-error transition-colors"><span class="material-symbols-outlined">cancel</span></button></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="p-md bg-surface-container-low flex justify-between items-center border-t border-outline-variant">
            <p class="font-label-sm text-on-surface-variant">عرض 3 من 42 حجزاً</p>
            <div class="flex gap-xs">
              <button class="p-xs border border-outline-variant rounded hover:bg-surface transition-colors disabled:opacity-50" disabled><span class="material-symbols-outlined rtl-flip">chevron_right</span></button>
              <button class="px-3 py-1 bg-secondary text-on-secondary rounded font-label-sm">1</button>
              <button class="px-3 py-1 border border-outline-variant rounded font-label-sm hover:bg-surface">2</button>
              <button class="px-3 py-1 border border-outline-variant rounded font-label-sm hover:bg-surface">3</button>
              <button class="p-xs border border-outline-variant rounded hover:bg-surface transition-colors"><span class="material-symbols-outlined rtl-flip">chevron_left</span></button>
            </div>
          </div>
        </section>
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-lg">
          <div class="lg:col-span-1 bg-surface custom-shadow rounded-xl p-lg border border-outline-variant">
            <h4 class="font-label-md text-on-surface mb-md">حالة صحة الأسطول</h4>
            <div class="space-y-md">
              <div><div class="flex justify-between text-label-sm mb-xs"><span class="text-on-surface-variant">قيد التشغيل</span><span class="text-on-surface">88%</span></div><div class="w-full h-2 bg-surface-container-high rounded-full overflow-hidden"><div class="h-full bg-green-500 w-[88%]"></div></div></div>
              <div><div class="flex justify-between text-label-sm mb-xs"><span class="text-on-surface-variant">قيد الصيانة</span><span class="text-on-surface">8%</span></div><div class="w-full h-2 bg-surface-container-high rounded-full overflow-hidden"><div class="h-full bg-yellow-500 w-[8%]"></div></div></div>
              <div><div class="flex justify-between text-label-sm mb-xs"><span class="text-on-surface-variant">يتطلب فحصاً</span><span class="text-on-surface">4%</span></div><div class="w-full h-2 bg-surface-container-high rounded-full overflow-hidden"><div class="h-full bg-error w-[4%]"></div></div></div>
            </div>
            <div class="mt-xl pt-lg border-t border-outline-variant flex items-center justify-between"><div class="flex items-center gap-xs text-secondary"><span class="material-symbols-outlined">build</span><span class="font-label-md">سجل الصيانة</span></div><span class="material-symbols-outlined text-on-surface-variant rtl-flip">arrow_back</span></div>
          </div>
          <div class="lg:col-span-2 relative h-[320px] rounded-xl overflow-hidden bg-surface-container-highest custom-shadow group">
            <img class="w-full h-full object-cover grayscale-[20%] group-hover:grayscale-0 transition-all duration-700" src="/images/fleet-map.jpg"/>
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            <div class="absolute bottom-6 right-6 text-white"><h5 class="font-headline-md text-headline-md">توزيع الأسطول</h5><p class="font-body-md opacity-90">تم تفعيل التتبع GPS المباشر لـ 142 مركبة.</p></div>
            <button class="absolute top-6 left-6 p-sm bg-white/20 backdrop-blur-md text-white rounded-full hover:bg-white/40 transition-all"><span class="material-symbols-outlined">map</span></button>
          </div>
        </section>
      </div>
      <footer class="w-full py-xl px-gutter bg-on-surface text-surface-container-lowest mt-xl">
        <div class="max-w-[1280px] mx-auto grid grid-cols-1 md:grid-cols-3 gap-lg">
          <div><h5 class="font-headline-md font-bold text-surface-container-lowest mb-md">عرب لتأجير السيارات</h5><p class="font-body-md text-surface-variant">تقديم حلول تأجير سيارات مهنية للسفر المؤسسي والشخصي منذ 2024.</p></div>
          <div class="flex flex-col gap-sm"><h6 class="font-label-md text-secondary-fixed">روابط سريعة</h6><a class="font-label-sm text-surface-variant hover:text-surface-container-lowest transition-colors" href="#">سياسة الخصوصية</a><a class="font-label-sm text-surface-variant hover:text-surface-container-lowest transition-colors" href="#">شروط الخدمة</a><a class="font-label-sm text-surface-variant hover:text-surface-container-lowest transition-colors" href="#">الأسئلة الشائعة</a></div>
          <div class="flex flex-col gap-sm"><h6 class="font-label-md text-secondary-fixed">دعم الاتصال</h6><p class="font-label-sm text-surface-variant">admin-support@arhabrentals.com</p><p class="font-label-sm text-surface-variant">+1 (555) 012-3456</p><div class="flex gap-md mt-sm"><span class="material-symbols-outlined text-surface-variant hover:text-secondary-fixed cursor-pointer">share</span><span class="material-symbols-outlined text-surface-variant hover:text-secondary-fixed cursor-pointer">help_center</span></div></div>
        </div>
        <div class="max-w-[1280px] mx-auto mt-xl pt-lg border-t border-surface-variant/20 flex flex-col md:flex-row justify-between items-center gap-md"><p class="font-label-sm text-surface-variant">© 2024 مكتب عرب لتأجير السيارات. جميع الحقوق محفوظة.</p><div class="flex gap-md"><span class="font-label-sm text-surface-variant">الإصدار 1.2.0 (مستقر)</span></div></div>
      </footer>
    </main>
  </div>
</template>