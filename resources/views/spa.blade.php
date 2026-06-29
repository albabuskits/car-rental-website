<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>عرب لتأجير السيارات - أفضل خدمة تأجير سيارات في اليمن</title>
  <meta name="description" content="عرب لتأجير السيارات يقدم أسطولاً متنوعاً من السيارات الحديثة للإيجار في اليمن. احجز سيارتك الآن بأفضل الأسعار."/>
  <meta property="og:title" content="عرب لتأجير السيارات - أفضل خدمة تأجير سيارات في اليمن"/>
  <meta property="og:description" content="عرب لتأجير السيارات يقدم أسطولاً متنوعاً من السيارات الحديثة للإيجار. احجز سيارتك الآن."/>
  <meta property="og:type" content="website"/>
  <meta property="og:url" content="{{ url()->current() }}"/>
  <meta property="og:image" content="{{ url('/images/og-image.jpg') }}"/>
  <meta name="twitter:card" content="summary_large_image"/>
  <meta name="twitter:title" content="عرب لتأجير السيارات"/>
  <meta name="twitter:description" content="أفضل خدمة تأجير سيارات في اليمن. أسطول متنوع، أسعار تنافسية."/>
  <link rel="canonical" href="{{ url()->current() }}"/>
  <link rel="manifest" href="/manifest.json"/>
  <meta name="theme-color" content="#00288e"/>
  <meta name="apple-mobile-web-app-capable" content="yes"/>
  <meta name="apple-mobile-web-app-status-bar-style" content="default"/>
  <link href="https://cdn.jsdelivr.net/npm/@n8n/chat/dist/style.css" rel="stylesheet" />
  <style>
    /* Hide Powered by n8n branding */
    .chat-powered-by,
    .chat-get-started-footer .chat-powered-by,
    a[href*="n8n.io"] {
      display: none !important;
    }
  </style>
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
  <script type="module">
    import { createChat } from 'https://cdn.jsdelivr.net/npm/@n8n/chat/dist/chat.bundle.es.js';

    createChat({
      webhookUrl: 'https://nafithatalsouq733.app.n8n.cloud/webhook/150c1932-9c66-475a-8055-b5b7e3c05981/chat',
      showWelcomeScreen: false,
      defaultLanguage: 'ar',
      initialMessages: [
        'مرحباً بك في عرب لتأجير السيارات! 👋',
        'معك حمود، المساعد الذكي لخدمة العملاء. كيف يمكنني مساعدتك اليوم؟'
      ],
      i18n: {
        ar: {
          title: 'عرب لتأجير السيارات',
          subtitle: 'المساعد الذكي لخدمة العملاء',
          inputPlaceholder: 'اكتب رسالتك هنا...',
        }
      }
    });
  </script>
</body>
</html>
