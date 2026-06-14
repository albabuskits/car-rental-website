<template>
  <div class="min-h-screen bg-surface flex flex-col">
    <AppHeader />
    <main class="flex-1 flex items-center justify-center px-gutter pt-24">
      <div class="text-center max-w-md">
        <div class="text-[120px] font-bold text-primary/20 leading-none mb-4">404</div>
        <h1 class="text-headline-lg font-headline-lg font-bold text-on-surface mb-2">الصفحة غير موجودة</h1>
        <p class="text-body-md font-body-md text-on-surface-variant mb-8">عذراً، الصفحة التي تبحث عنها غير موجودة أو تم نقلها.</p>
        <router-link to="/" class="inline-block bg-primary text-on-primary px-6 py-3 rounded-lg font-label-md text-label-md hover:bg-primary-container transition-all active:scale-95">
          العودة إلى الرئيسية
        </router-link>
      </div>
    </main>
    <AppFooter />
  </div>
</template>

<script setup>
import AppHeader from '@/components/AppHeader.vue'
import AppFooter from '@/components/AppFooter.vue'
</script>
