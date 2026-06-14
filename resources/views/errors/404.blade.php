<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - الصفحة غير موجودة</title>
    @vite('resources/css/app.css')
    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-surface min-h-screen flex flex-col">
    <header class="fixed top-0 left-0 w-full z-50 bg-surface shadow-sm h-16 flex items-center">
        <div class="flex justify-between items-center w-full px-gutter max-w-[1280px] mx-auto h-16">
            <a href="/" class="text-headline-md font-headline-lg font-bold text-primary">عرب لتأجير السيارات</a>
        </div>
    </header>

    <main class="flex-1 flex items-center justify-center px-gutter pt-24">
        <div class="text-center max-w-md">
            <div class="text-[120px] font-bold text-primary/20 leading-none mb-4">404</div>
            <h1 class="text-headline-lg font-headline-lg font-bold text-on-surface mb-2">الصفحة غير موجودة</h1>
            <p class="text-body-md font-body-md text-on-surface-variant mb-8">عذراً، الصفحة التي تبحث عنها غير موجودة أو تم نقلها.</p>
            <a href="/" class="inline-block bg-primary text-on-primary px-6 py-3 rounded-lg font-label-md text-label-md hover:bg-primary-container transition-all active:scale-95">
                العودة إلى الرئيسية
            </a>
        </div>
    </main>

    <footer class="bg-primary-container dark:bg-[#0f172a] py-6 text-center">
        <p class="text-body-md font-body-md text-on-surface-variant">جميع الحقوق محفوظة &copy; {{ date('Y') }} عرب لتأجير السيارات</p>
    </footer>
</body>
</html>
