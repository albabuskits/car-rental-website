<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>عرب لتأجير السيارات</title>
  @vite(['resources/js/main.js'])
  <script>
    (function() {
      var theme = localStorage.getItem('theme') || 'auto';
      if (theme === 'dark' || (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
      }
    })();
  </script>
</head>
<body class="bg-surface text-on-surface" style="font-family: 'Cairo', 'Inter', sans-serif;">
  <div id="app"></div>
</body>
</html>
