<template>
  <div class="flex min-h-screen">
    <aside class="hidden lg:flex flex-col h-screen fixed right-0 top-0 border-l border-outline-variant bg-surface-container-low w-64 z-40">
      <div class="p-md">
        <h1 class="font-headline-md text-headline-md text-primary mb-xl">عرب للإدارة</h1>
        <nav class="space-y-xs">
          <router-link class="flex items-center gap-sm px-sm py-xs rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-all" to="/admin"><span class="material-symbols-outlined">dashboard</span><span class="font-label-md text-label-md">لوحة التحكم</span></router-link>
          <a class="flex items-center gap-sm px-sm py-xs rounded-lg text-secondary font-bold bg-surface-container-high transition-all" href="#"><span class="material-symbols-outlined">directions_car</span><span class="font-label-md text-label-md">السيارات</span></a>
          <router-link class="flex items-center gap-sm px-sm py-xs rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-all" to="/admin/bookings"><span class="material-symbols-outlined">calendar_month</span><span class="font-label-md text-label-md">الحجوزات</span></router-link>
          <router-link class="flex items-center gap-sm px-sm py-xs rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-all" to="/admin/control-center"><span class="material-symbols-outlined">edit_note</span><span class="font-label-md text-label-md">إدارة المحتوى</span></router-link>
          <a class="flex items-center gap-sm px-sm py-xs rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-all" href="#"><span class="material-symbols-outlined">settings</span><span class="font-label-md text-label-md">الإعدادات</span></a>
        </nav>
      </div>
      <div class="mt-auto p-md border-t border-outline-variant">
        <div class="flex items-center gap-sm">
          <img class="w-10 h-10 rounded-full object-cover" src="/images/cm-profile.jpg"/>
          <div><p class="font-label-md text-label-md text-on-surface">مدير الأسطول</p><p class="text-xs text-on-surface-variant">admin@arhab.com</p></div>
        </div>
      </div>
    </aside>
    <main class="flex-1 lg:mr-64 p-gutter md:p-xl transition-all duration-300">
      <header class="flex flex-col md:flex-row md:items-center justify-between gap-md mb-xl">
        <div><h2 class="font-headline-lg text-headline-lg text-on-surface">إدارة الأسطول</h2><p class="text-on-surface-variant font-body-md text-body-md mt-xs">الإشراف على أسطولك النشط والمخزون في جميع المناطق.</p></div>
        <button class="bg-primary text-on-primary font-label-md text-label-md px-lg py-sm rounded-lg flex items-center gap-xs hover:opacity-90 active:scale-95 transition-all shadow-md" @click="toggleModal(true)"><span class="material-symbols-outlined">add</span>إضافة سيارة جديدة</button>
      </header>
      <section class="bg-surface custom-shadow rounded-xl p-md mb-lg flex flex-col md:flex-row gap-md items-center justify-between">
        <div class="relative w-full md:w-96"><span class="material-symbols-outlined absolute right-sm top-1/2 -translate-y-1/2 text-outline">search</span><input class="w-full pr-10 pl-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary transition-all outline-none text-body-md" placeholder="ابحث عن طراز أو علامة تجارية..." type="text"/></div>
        <div class="flex gap-sm overflow-x-auto w-full md:w-auto pb-xs md:pb-0">
          <button class="bg-primary-container text-on-primary-container px-sm py-xs rounded-full font-label-md text-label-md whitespace-nowrap">جميع السيارات (42)</button>
          <button class="bg-surface-container-low text-on-surface-variant border border-outline-variant px-sm py-xs rounded-full font-label-md text-label-md whitespace-nowrap hover:bg-surface-container-high">متاحة</button>
          <button class="bg-surface-container-low text-on-surface-variant border border-outline-variant px-sm py-xs rounded-full font-label-md text-label-md whitespace-nowrap hover:bg-surface-container-high">مستأجرة</button>
          <button class="bg-surface-container-low text-on-surface-variant border border-outline-variant px-sm py-xs rounded-full font-label-md text-label-md whitespace-nowrap hover:bg-surface-container-high">صيانة</button>
        </div>
      </section>
      <section class="bg-surface custom-shadow rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full text-right border-collapse">
            <thead><tr class="bg-slate-50 border-b border-outline-variant">
              <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">معرف السيارة</th>
              <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">تفاصيل السيارة</th>
              <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">الحالة</th>
              <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">السعر / اليوم</th>
              <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant text-left">الإجراءات</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-100">
              <tr class="hover:bg-slate-50 transition-colors group">
                <td class="px-md py-md font-label-sm text-label-sm text-outline">#VH-8821</td>
                <td class="px-md py-md"><div class="flex items-center gap-sm"><div class="w-16 h-10 rounded bg-slate-100 overflow-hidden flex-shrink-0"><img class="w-full h-full object-cover" src="/images/cm-tesla.jpg"/></div><div><p class="font-label-md text-label-md text-on-surface">تسلا موديل 3</p><p class="text-xs text-on-surface-variant">فاخرة • كهربائية</p></div></div></td>
                <td class="px-md py-md"><span class="inline-flex items-center px-xs py-[2px] rounded bg-green-100 text-green-800 text-[10px] font-bold uppercase tracking-wider">متاحة</span></td>
                <td class="px-md py-md font-label-md text-label-md text-on-surface">$120.00</td>
                <td class="px-md py-md text-left"><button class="p-xs hover:bg-surface-container-high rounded transition-colors text-on-surface-variant"><span class="material-symbols-outlined">more_vert</span></button></td>
              </tr>
              <tr class="hover:bg-slate-50 transition-colors group">
                <td class="px-md py-md font-label-sm text-label-sm text-outline">#VH-9012</td>
                <td class="px-md py-md"><div class="flex items-center gap-sm"><div class="w-16 h-10 rounded bg-slate-100 overflow-hidden flex-shrink-0"><img class="w-full h-full object-cover" src="/images/cm-bmw.jpg"/></div><div><p class="font-label-md text-label-md text-on-surface">بي إم دبليو الفئة الخامسة</p><p class="text-xs text-on-surface-variant">تنفيذية • هايبرد</p></div></div></td>
                <td class="px-md py-md"><span class="inline-flex items-center px-xs py-[2px] rounded bg-blue-100 text-blue-800 text-[10px] font-bold uppercase tracking-wider">مستأجرة</span></td>
                <td class="px-md py-md font-label-md text-label-md text-on-surface">$145.00</td>
                <td class="px-md py-md text-left"><button class="p-xs hover:bg-surface-container-high rounded transition-colors text-on-surface-variant"><span class="material-symbols-outlined">more_vert</span></button></td>
              </tr>
              <tr class="hover:bg-slate-50 transition-colors group">
                <td class="px-md py-md font-label-sm text-label-sm text-outline">#VH-7743</td>
                <td class="px-md py-md"><div class="flex items-center gap-sm"><div class="w-16 h-10 rounded bg-slate-100 overflow-hidden flex-shrink-0"><img class="w-full h-full object-cover" src="/images/cm-landrover.jpg"/></div><div><p class="font-label-md text-label-md text-on-surface">لاند روفر ديفندر</p><p class="text-xs text-on-surface-variant">دفع رباعي • AWD</p></div></div></td>
                <td class="px-md py-md"><span class="inline-flex items-center px-xs py-[2px] rounded bg-amber-100 text-amber-800 text-[10px] font-bold uppercase tracking-wider">قيد الخدمة</span></td>
                <td class="px-md py-md font-label-md text-label-md text-on-surface">$180.00</td>
                <td class="px-md py-md text-left"><button class="p-xs hover:bg-surface-container-high rounded transition-colors text-on-surface-variant"><span class="material-symbols-outlined">more_vert</span></button></td>
              </tr>
              <tr class="hover:bg-slate-50 transition-colors group">
                <td class="px-md py-md font-label-sm text-label-sm text-outline">#VH-1109</td>
                <td class="px-md py-md"><div class="flex items-center gap-sm"><div class="w-16 h-10 rounded bg-slate-100 overflow-hidden flex-shrink-0"><img class="w-full h-full object-cover" src="/images/cm-porsche.jpg"/></div><div><p class="font-label-md text-label-md text-on-surface">بورش 911</p><p class="text-xs text-on-surface-variant">رياضية • بنزين</p></div></div></td>
                <td class="px-md py-md"><span class="inline-flex items-center px-xs py-[2px] rounded bg-green-100 text-green-800 text-[10px] font-bold uppercase tracking-wider">متاحة</span></td>
                <td class="px-md py-md font-label-md text-label-md text-on-surface">$350.00</td>
                <td class="px-md py-md text-left"><button class="p-xs hover:bg-surface-container-high rounded transition-colors text-on-surface-variant"><span class="material-symbols-outlined">more_vert</span></button></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="px-md py-sm bg-slate-50 flex items-center justify-between">
          <p class="text-xs text-on-surface-variant">عرض 4 من 42 سيارة</p>
          <div class="flex items-center gap-xs">
            <button class="w-8 h-8 rounded border border-outline-variant flex items-center justify-center text-outline hover:bg-white disabled:opacity-50" disabled><span class="material-symbols-outlined text-[18px] rtl-flip">chevron_right</span></button>
            <button class="w-8 h-8 rounded bg-primary text-on-primary flex items-center justify-center font-label-sm text-label-sm">1</button>
            <button class="w-8 h-8 rounded border border-outline-variant flex items-center justify-center font-label-sm text-label-sm text-on-surface-variant hover:bg-white">2</button>
            <button class="w-8 h-8 rounded border border-outline-variant flex items-center justify-center text-outline hover:bg-white"><span class="material-symbols-outlined text-[18px] rtl-flip">chevron_left</span></button>
          </div>
        </div>
      </section>
    </main>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300" id="carModal">
      <div class="bg-surface w-full max-w-2xl rounded-2xl modal-shadow overflow-hidden transform scale-95 transition-transform duration-300">
        <header class="px-lg py-md border-b border-outline-variant flex items-center justify-between">
          <h3 class="font-headline-md text-headline-md text-on-surface">إضافة سيارة جديدة</h3>
          <button class="p-xs rounded-full hover:bg-surface-container-high text-on-surface-variant transition-colors" @click="toggleModal(false)"><span class="material-symbols-outlined">close</span></button>
        </header>
        <form class="p-lg space-y-md overflow-y-auto max-h-[716px]">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
            <div class="space-y-xs"><label class="font-label-md text-label-md text-on-surface">العلامة التجارية</label><input class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" placeholder="مثال: مرسيدس-بنز" type="text"/></div>
            <div class="space-y-xs"><label class="font-label-md text-label-md text-on-surface">اسم الموديل</label><input class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" placeholder="مثال: S-Class" type="text"/></div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
            <div class="space-y-xs"><label class="font-label-md text-label-md text-on-surface">الفئة</label><select class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none bg-white"><option>اقتصادية</option><option>فاخرة</option><option>دفع رباعي</option><option>رياضية</option></select></div>
            <div class="space-y-xs"><label class="font-label-md text-label-md text-on-surface">نوع الوقود</label><select class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none bg-white"><option>بنزين</option><option>ديزل</option><option>كهربائي</option><option>هايبرد</option></select></div>
            <div class="space-y-xs"><label class="font-label-md text-label-md text-on-surface">السعر (يومي)</label><div class="relative"><span class="absolute right-sm top-1/2 -translate-y-1/2 text-outline">$</span><input class="w-full pr-8 pl-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" placeholder="0.00" type="number"/></div></div>
          </div>
          <div class="space-y-xs"><label class="font-label-md text-label-md text-on-surface">صورة السيارة</label><div class="border-2 border-dashed border-outline-variant rounded-xl p-xl flex flex-col items-center justify-center gap-xs cursor-pointer hover:bg-slate-50 hover:border-secondary transition-all group"><span class="material-symbols-outlined text-outline group-hover:text-secondary text-4xl">cloud_upload</span><p class="font-label-md text-label-md text-on-surface">انقر للرفع أو اسحب وأفلت</p><p class="text-xs text-outline">PNG, JPG أو WEBP (حد أقصى 5 ميجابايت)</p><input class="hidden" id="car-image-upload" type="file"/></div></div>
        </form>
        <footer class="px-lg py-md border-t border-outline-variant flex justify-end gap-md bg-slate-50">
          <button class="px-lg py-sm font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors" @click="toggleModal(false)">إلغاء</button>
          <button class="bg-primary text-on-primary px-xl py-sm rounded-lg font-label-md text-label-md hover:opacity-90 active:scale-95 transition-all">حفظ السيارة</button>
        </footer>
      </div>
    </div>
  </div>
</template>

<script setup>
function toggleModal(show) {
  const modal = document.getElementById('carModal')
  if (!modal) return
  const content = modal.querySelector('.transform')
  if (show) {
    modal.classList.remove('hidden')
    setTimeout(() => {
      modal.classList.add('opacity-100')
      modal.classList.remove('opacity-0')
      content.classList.add('scale-100')
      content.classList.remove('scale-95')
    }, 10)
  } else {
    modal.classList.add('opacity-0')
    modal.classList.remove('opacity-100')
    content.classList.add('scale-95')
    content.classList.remove('scale-100')
    setTimeout(() => { modal.classList.add('hidden') }, 300)
  }
}

import { onMounted } from 'vue'
onMounted(() => {
  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') toggleModal(false)
  })
})
</script>