<template>
  <div class="flex min-h-screen text-on-surface bg-background">
    <aside class="hidden lg:flex flex-col h-screen fixed right-0 top-0 border-l border-outline-variant bg-surface-container-low w-64 z-50">
      <div class="p-lg"><h1 class="font-headline-md text-headline-md text-primary">عرب للإدارة</h1><p class="font-label-sm text-label-sm text-on-surface-variant opacity-70">مدير الأسطول</p></div>
      <nav class="flex-1 px-sm mt-md space-y-xs">
        <router-link class="flex items-center gap-sm px-md py-sm rounded-lg hover:bg-surface-container-high transition-all text-on-surface-variant" to="/admin"><span class="material-symbols-outlined">dashboard</span><span class="font-label-md text-label-md">لوحة التحكم</span></router-link>
        <router-link class="flex items-center gap-sm px-md py-sm rounded-lg hover:bg-surface-container-high transition-all text-on-surface-variant" to="/admin/cars"><span class="material-symbols-outlined">directions_car</span><span class="font-label-md text-label-md">السيارات</span></router-link>
        <a class="flex items-center gap-sm px-md py-sm rounded-lg transition-all text-secondary font-bold bg-surface-container-high" href="#"><span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">calendar_month</span><span class="font-label-md text-label-md">الحجوزات</span></a>
        <router-link class="flex items-center gap-sm px-md py-sm rounded-lg hover:bg-surface-container-high transition-all text-on-surface-variant" to="/admin/control-center"><span class="material-symbols-outlined">edit_note</span><span class="font-label-md text-label-md">إدارة المحتوى</span></router-link>
        <a class="flex items-center gap-sm px-md py-sm rounded-lg hover:bg-surface-container-high transition-all text-on-surface-variant" href="#"><span class="material-symbols-outlined">settings</span><span class="font-label-md text-label-md">الإعدادات</span></a>
      </nav>
      <div class="p-lg mt-auto">
        <button class="w-full bg-primary text-on-primary font-label-md text-label-md py-sm rounded-lg flex items-center justify-center gap-xs hover:opacity-90 transition-all shadow-sm"><span class="material-symbols-outlined text-[18px]">add</span>إضافة سيارة جديدة</button>
        <div class="mt-lg flex items-center gap-sm pt-lg border-t border-outline-variant">
          <img class="w-10 h-10 rounded-full object-cover" src="/images/bm-profile.jpg"/>
          <div><p class="font-label-md text-label-md text-on-surface">أليكس ريفيرا</p><p class="font-label-sm text-label-sm text-on-surface-variant">مسؤول أول</p></div>
        </div>
      </div>
    </aside>
    <main class="flex-1 lg:mr-64 p-gutter lg:p-xl min-w-0">
      <header class="mb-xl flex flex-col md:flex-row md:items-center justify-between gap-md">
        <div>
          <nav class="flex items-center gap-xs text-on-surface-variant mb-xs"><span class="font-label-sm text-label-sm">الإدارة</span><span class="material-symbols-outlined text-[16px] rtl-flip">chevron_left</span><span class="font-label-sm text-label-sm text-primary font-bold">إدارة الحجوزات</span></nav>
          <h2 class="font-headline-lg text-headline-lg text-on-surface">إدارة الحجوزات</h2>
          <p class="font-body-md text-body-md text-on-surface-variant">نظرة عامة وإجراءات لطلبات تأجير السيارات الحالية.</p>
        </div>
        <div class="flex items-center gap-sm">
          <button class="bg-surface border border-outline-variant text-on-surface-variant px-md py-xs rounded-lg flex items-center gap-xs font-label-md text-label-md hover:bg-surface-container hover:border-primary transition-all"><span class="material-symbols-outlined">file_download</span>تصدير CSV</button>
        </div>
      </header>
      <div class="grid grid-cols-1 md:grid-cols-4 gap-md mb-xl">
        <div class="md:col-span-1 bg-primary-container text-on-primary-container p-lg rounded-xl shadow-sm border border-primary/10">
          <div class="flex items-center justify-between mb-sm"><span class="font-label-md text-label-md">الطلبات المعلقة</span><span class="material-symbols-outlined">pending</span></div>
          <p class="text-[32px] font-bold leading-none mb-1">24</p>
          <p class="font-label-sm text-label-sm opacity-80">+5 عن أمس</p>
        </div>
        <div class="md:col-span-1 bg-surface border border-outline-variant p-lg rounded-xl shadow-sm">
          <div class="flex items-center justify-between mb-sm"><span class="font-label-md text-label-md text-on-surface-variant">تمت الموافقة اليوم</span><span class="material-symbols-outlined text-secondary">check_circle</span></div>
          <p class="text-[32px] font-bold leading-none mb-1 text-on-surface">18</p>
          <p class="font-label-sm text-label-sm text-on-surface-variant">معدل موافقة 82%</p>
        </div>
        <div class="md:col-span-2 bg-surface border border-outline-variant p-lg rounded-xl shadow-sm flex items-center justify-between">
          <div><span class="font-label-md text-label-md text-on-surface-variant mb-xs block">استخدام الأسطول النشط</span><p class="text-[32px] font-bold leading-none mb-1 text-on-surface">89%</p><p class="font-label-sm text-label-sm text-on-surface-variant">142 سيارة على الطريق حالياً</p></div>
          <div class="w-32 h-16 bg-surface-container rounded-lg overflow-hidden flex items-end">
            <div class="flex-1 bg-primary/20 h-1/2 mx-[1px]"></div>
            <div class="flex-1 bg-primary/30 h-2/3 mx-[1px]"></div>
            <div class="flex-1 bg-primary/40 h-3/4 mx-[1px]"></div>
            <div class="flex-1 bg-primary/50 h-4/5 mx-[1px]"></div>
            <div class="flex-1 bg-primary h-full mx-[1px]"></div>
          </div>
        </div>
      </div>
      <div class="bg-surface border border-outline-variant rounded-xl p-md mb-lg shadow-sm flex flex-col md:flex-row items-center gap-md">
        <div class="relative flex-1 w-full"><span class="absolute right-md top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant">search</span><input class="w-full pr-xl pl-md py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary bg-surface text-body-md outline-none" placeholder="ابحث باسم العميل أو طراز السيارة..." type="text"/></div>
        <div class="flex items-center gap-xs overflow-x-auto pb-1 md:pb-0 w-full md:w-auto">
          <button class="whitespace-nowrap px-md py-xs rounded-full bg-primary text-on-primary font-label-md text-label-md transition-all shadow-sm">جميع الحجوزات</button>
          <button class="whitespace-nowrap px-md py-xs rounded-full bg-surface-container-low border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:border-secondary transition-all">معلقة</button>
          <button class="whitespace-nowrap px-md py-xs rounded-full bg-surface-container-low border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:border-secondary transition-all">موافق عليها</button>
          <button class="whitespace-nowrap px-md py-xs rounded-full bg-surface-container-low border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:border-secondary transition-all">مرفوضة</button>
        </div>
        <div class="flex items-center gap-sm w-full md:w-auto">
          <div class="h-8 w-[1px] bg-outline-variant hidden md:block"></div>
          <button class="flex items-center gap-xs text-on-surface-variant font-label-md text-label-md hover:text-primary transition-colors"><span class="material-symbols-outlined">calendar_today</span>آخر 30 يوماً <span class="material-symbols-outlined">expand_more</span></button>
        </div>
      </div>
      <div class="bg-surface border border-outline-variant rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
          <table class="w-full text-right border-collapse">
            <thead class="bg-surface-container-low">
              <tr>
                <th class="px-md py-md font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">العميل</th>
                <th class="px-md py-md font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">السيارة</th>
                <th class="px-md py-md font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">المدة</th>
                <th class="px-md py-md font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">السعر الإجمالي</th>
                <th class="px-md py-md font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">الحالة</th>
                <th class="px-md py-md font-label-md text-label-md text-on-surface-variant uppercase tracking-wider text-left">الإجراءات</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant">
              <tr class="hover:bg-surface-container-low transition-colors group">
                <td class="px-md py-md"><div class="flex items-center gap-sm"><div class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center text-primary font-bold">م.ج</div><div><p class="font-label-md text-label-md text-on-surface">محمد جابر</p><p class="font-label-sm text-label-sm text-on-surface-variant">mohamed@email.com</p></div></div></td>
                <td class="px-md py-md"><div><p class="font-label-md text-label-md text-on-surface">تسلا موديل S</p><p class="font-label-sm text-label-sm text-on-surface-variant">كهربائية • أبيض</p></div></td>
                <td class="px-md py-md"><div class="font-label-md text-label-md text-on-surface">24 أكتوبر - 28 أكتوبر</div><p class="font-label-sm text-label-sm text-on-surface-variant">4 أيام</p></td>
                <td class="px-md py-md"><span class="font-label-md text-label-md text-on-surface">$520.00</span></td>
                <td class="px-md py-md"><span class="px-sm py-1 rounded-full bg-yellow-100 text-yellow-800 text-[12px] font-bold uppercase tracking-tight">معلق</span></td>
                <td class="px-md py-md text-left"><div class="flex items-center justify-end gap-xs opacity-0 group-hover:opacity-100 transition-opacity"><button class="p-2 rounded-lg text-primary hover:bg-primary/10 transition-colors"><span class="material-symbols-outlined">check_circle</span></button><button class="p-2 rounded-lg text-error hover:bg-error/10 transition-colors"><span class="material-symbols-outlined">cancel</span></button><button class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined">edit</span></button></div></td>
              </tr>
              <tr class="hover:bg-surface-container-low transition-colors group">
                <td class="px-md py-md"><div class="flex items-center gap-sm"><div class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center text-primary font-bold">س.م</div><div><p class="font-label-md text-label-md text-on-surface">سارة ميلر</p><p class="font-label-sm text-label-sm text-on-surface-variant">s.miller@corporate.com</p></div></div></td>
                <td class="px-md py-md"><div><p class="font-label-md text-label-md text-on-surface">بي إم دبليو X5 M</p><p class="font-label-sm text-label-sm text-on-surface-variant">دفع رباعي • أسود</p></div></td>
                <td class="px-md py-md"><div class="font-label-md text-label-md text-on-surface">25 أكتوبر - 30 أكتوبر</div><p class="font-label-sm text-label-sm text-on-surface-variant">5 أيام</p></td>
                <td class="px-md py-md"><span class="font-label-md text-label-md text-on-surface">$850.00</span></td>
                <td class="px-md py-md"><span class="px-sm py-1 rounded-full bg-green-100 text-green-800 text-[12px] font-bold uppercase tracking-tight">موافق</span></td>
                <td class="px-md py-md text-left"><div class="flex items-center justify-end gap-xs opacity-0 group-hover:opacity-100 transition-opacity"><button class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined">edit</span></button><button class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined">more_vert</span></button></div></td>
              </tr>
              <tr class="hover:bg-surface-container-low transition-colors group">
                <td class="px-md py-md"><div class="flex items-center gap-sm"><div class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center text-primary font-bold">م.ك</div><div><p class="font-label-md text-label-md text-on-surface">مايكل كيم</p><p class="font-label-sm text-label-sm text-on-surface-variant">m.kim@tech.org</p></div></div></td>
                <td class="px-md py-md"><div><p class="font-label-md text-label-md text-on-surface">لاند روفر ديفندر</p><p class="font-label-sm text-label-sm text-on-surface-variant">دفع رباعي • أخضر</p></div></td>
                <td class="px-md py-md"><div class="font-label-md text-label-md text-on-surface">26 أكتوبر - 27 أكتوبر</div><p class="font-label-sm text-label-sm text-on-surface-variant">يوم واحد</p></td>
                <td class="px-md py-md"><span class="font-label-md text-label-md text-on-surface">$210.00</span></td>
                <td class="px-md py-md"><span class="px-sm py-1 rounded-full bg-red-100 text-red-800 text-[12px] font-bold uppercase tracking-tight">مرفوض</span></td>
                <td class="px-md py-md text-left"><div class="flex items-center justify-end gap-xs opacity-0 group-hover:opacity-100 transition-opacity"><button class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined">edit</span></button><button class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined">more_vert</span></button></div></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="px-md py-md bg-surface-container-low border-t border-outline-variant flex items-center justify-between">
          <p class="font-label-sm text-label-sm text-on-surface-variant">عرض 1 إلى 3 من 24 حجزاً</p>
          <div class="flex items-center gap-xs">
            <button class="p-2 rounded-lg border border-outline-variant hover:bg-surface-container transition-colors disabled:opacity-30" disabled><span class="material-symbols-outlined rtl-flip">chevron_right</span></button>
            <button class="w-8 h-8 rounded-lg bg-primary text-on-primary font-bold text-label-sm">1</button>
            <button class="w-8 h-8 rounded-lg border border-outline-variant hover:bg-surface-container text-on-surface font-label-sm transition-colors">2</button>
            <button class="w-8 h-8 rounded-lg border border-outline-variant hover:bg-surface-container text-on-surface font-label-sm transition-colors">3</button>
            <button class="p-2 rounded-lg border border-outline-variant hover:bg-surface-container transition-colors"><span class="material-symbols-outlined rtl-flip">chevron_left</span></button>
          </div>
        </div>
      </div>
      <div class="mt-xl glass-card rounded-xl p-md flex items-start gap-md border-r-4 border-secondary shadow-sm">
        <div class="p-xs rounded-full bg-secondary-fixed text-on-secondary-fixed"><span class="material-symbols-outlined">lightbulb</span></div>
        <div><h4 class="font-label-md text-label-md text-on-surface">نصيحة: الموافقة الجماعية</h4><p class="font-body-md text-body-md text-on-surface-variant">يمكنك تحديد طلبات معلقة متعددة للموافقة عليها مرة واحدة. اضغط مع الاستمرار على مفتاح Shift أثناء النقر على مربعات الاختيار (الميزة قريباً!).</p></div>
        <button class="mr-auto text-on-surface-variant hover:text-on-surface transition-colors"><span class="material-symbols-outlined">close</span></button>
      </div>
    </main>
  </div>
</template>