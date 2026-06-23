<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>لوحة المستخدم - {{ config('app.name', 'عرب') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script>
        (function() {
            var theme = localStorage.getItem('theme') || 'auto';
            if (theme === 'dark' || (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>
<body class="font-sans antialiased bg-surface text-on-surface">
    <div class="flex min-h-screen">
        <nav class="hidden lg:flex flex-col h-screen fixed right-0 top-0 border-l border-outline-variant bg-surface-container-low w-64 z-50">
            <div class="p-lg">
                <h1 class="font-headline-md text-headline-md text-primary tracking-tight">عرب</h1>
                <p class="font-label-sm text-on-surface-variant mt-xs">لوحة المستخدم</p>
            </div>
            <div class="mt-md flex-grow space-y-xs px-sm">
                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-sm px-md py-sm rounded-lg {{ request()->routeIs('user.dashboard') ? 'active-nav-bg text-secondary font-bold' : 'text-on-surface-variant font-medium' }} transition-all hover:bg-surface-container-high duration-200">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="font-label-md text-label-md">لوحتي</span>
                </a>
                <a href="{{ route('user.bookings') }}" class="flex items-center gap-sm px-md py-sm rounded-lg {{ request()->routeIs('user.bookings') ? 'active-nav-bg text-secondary font-bold' : 'text-on-surface-variant font-medium' }} transition-all hover:bg-surface-container-high duration-200">
                    <span class="material-symbols-outlined">calendar_month</span>
                    <span class="font-label-md text-label-md">حجوزاتي</span>
                </a>
                <a href="{{ route('user.messages') }}" class="flex items-center gap-sm px-md py-sm rounded-lg {{ request()->routeIs('user.messages') ? 'active-nav-bg text-secondary font-bold' : 'text-on-surface-variant font-medium' }} transition-all hover:bg-surface-container-high duration-200">
                    <span class="material-symbols-outlined">mail</span>
                    <span class="font-label-md text-label-md">رسائلي</span>
                </a>
                <a href="{{ route('user.profile') }}" class="flex items-center gap-sm px-md py-sm rounded-lg {{ request()->routeIs('user.profile') ? 'active-nav-bg text-secondary font-bold' : 'text-on-surface-variant font-medium' }} transition-all hover:bg-surface-container-high duration-200">
                    <span class="material-symbols-outlined">person</span>
                    <span class="font-label-md text-label-md">ملفي الشخصي</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-md border-t border-outline-variant pt-md">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-sm px-md py-sm rounded-lg text-error font-medium transition-all hover:bg-error/10 duration-200">
                        <span class="material-symbols-outlined">logout</span>
                        <span class="font-label-md text-label-md">تسجيل الخروج</span>
                    </button>
                </form>
            </div>
            <div class="p-lg mt-auto border-t border-outline-variant">
                <div class="flex items-center gap-sm">
                    <img class="w-10 h-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=00288e&color=fff" alt="{{ auth()->user()->name }}"/>
                    <div>
                        <p class="font-label-md text-on-surface">{{ auth()->user()->name }}</p>
                        <p class="text-[12px] text-on-surface-variant">{{ auth()->user()->roles->first()?->name ?? 'مستخدم' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-md">
                    @csrf
                    <button type="submit" class="w-full py-sm bg-surface-container-high text-on-surface rounded-lg font-label-md flex items-center justify-center gap-xs hover:bg-surface-container-highest transition-colors">
                        <span class="material-symbols-outlined text-[18px]">logout</span>تسجيل الخروج
                    </button>
                </form>
            </div>
        </nav>
        <main class="lg:mr-64 min-h-screen w-full">
            <header class="h-16 flex items-center justify-between px-gutter bg-surface custom-shadow sticky top-0 z-40">
                <div class="flex items-center gap-md">
                    <button class="lg:hidden p-xs text-on-surface" onclick="document.getElementById('mobileSidebar').classList.toggle('hidden')">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <h2 class="font-headline-md text-headline-md text-on-surface">@yield('page-title', 'لوحة المستخدم')</h2>
                </div>
                <div class="flex items-center gap-md">
                    <livewire:notification-bell />
                    <div class="relative" id="theme-dropdown-container">
                        <button onclick="toggleThemeDropdown()" class="p-xs text-on-surface-variant hover:text-secondary transition-colors" title="تغيير المظهر">
                            <span class="material-symbols-outlined" id="theme-icon">dark_mode</span>
                        </button>
                        <div id="theme-dropdown" class="absolute left-0 top-full mt-xs w-40 bg-surface custom-shadow rounded-xl border border-outline-variant overflow-hidden z-50 hidden">
                            <button onclick="setTheme('light')" class="w-full px-md py-sm flex items-center gap-sm font-label-md text-label-md text-on-surface hover:bg-surface-container-high transition-colors">
                                <span class="material-symbols-outlined text-[18px]">light_mode</span> فاتح
                            </button>
                            <button onclick="setTheme('dark')" class="w-full px-md py-sm flex items-center gap-sm font-label-md text-label-md text-on-surface hover:bg-surface-container-high transition-colors">
                                <span class="material-symbols-outlined text-[18px]">dark_mode</span> داكن
                            </button>
                            <button onclick="setTheme('auto')" class="w-full px-md py-sm flex items-center gap-sm font-label-md text-label-md text-on-surface hover:bg-surface-container-high transition-colors">
                                <span class="material-symbols-outlined text-[18px]">settings_brightness</span> تلقائي
                            </button>
                        </div>
                    </div>
                </div>
            </header>
            <div class="p-gutter max-w-[1280px] mx-auto space-y-xl">
                @yield('content')
            </div>
        </main>
    </div>
    <div id="mobileSidebar" class="fixed inset-0 z-50 hidden lg:hidden">
        <div class="absolute inset-0 bg-black/40" onclick="document.getElementById('mobileSidebar').classList.add('hidden')"></div>
        <nav class="absolute right-0 top-0 h-full w-72 bg-surface-container-low border-l border-outline-variant p-lg overflow-y-auto">
            <div class="flex justify-between items-center mb-lg">
                <h1 class="font-headline-md text-headline-md text-primary tracking-tight">عرب</h1>
                <button onclick="document.getElementById('mobileSidebar').classList.add('hidden')" class="p-xs text-on-surface-variant">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="space-y-xs">
                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-sm px-md py-sm rounded-lg {{ request()->routeIs('user.dashboard') ? 'active-nav-bg text-secondary font-bold' : 'text-on-surface-variant font-medium' }}"><span class="material-symbols-outlined">dashboard</span><span class="font-label-md">لوحتي</span></a>
                <a href="{{ route('user.bookings') }}" class="flex items-center gap-sm px-md py-sm rounded-lg {{ request()->routeIs('user.bookings') ? 'active-nav-bg text-secondary font-bold' : 'text-on-surface-variant font-medium' }}"><span class="material-symbols-outlined">calendar_month</span><span class="font-label-md">حجوزاتي</span></a>
                <a href="{{ route('user.messages') }}" class="flex items-center gap-sm px-md py-sm rounded-lg {{ request()->routeIs('user.messages') ? 'active-nav-bg text-secondary font-bold' : 'text-on-surface-variant font-medium' }}"><span class="material-symbols-outlined">mail</span><span class="font-label-md">رسائلي</span></a>
                <a href="{{ route('user.profile') }}" class="flex items-center gap-sm px-md py-sm rounded-lg {{ request()->routeIs('user.profile') ? 'active-nav-bg text-secondary font-bold' : 'text-on-surface-variant font-medium' }}"><span class="material-symbols-outlined">person</span><span class="font-label-md">ملفي الشخصي</span></a>
                <form method="POST" action="{{ route('logout') }}" class="border-t border-outline-variant pt-md mt-md">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-sm px-md py-sm rounded-lg text-error font-medium transition-all hover:bg-error/10"><span class="material-symbols-outlined">logout</span><span class="font-label-md">تسجيل الخروج</span></button>
                </form>
            </div>
        </nav>
    </div>
    @livewireScripts
    <script>
        function toggleThemeDropdown() {
            document.getElementById('theme-dropdown').classList.toggle('hidden');
        }
        function closeThemeDropdown() {
            document.getElementById('theme-dropdown').classList.add('hidden');
        }
        document.addEventListener('click', function(e) {
            var container = document.getElementById('theme-dropdown-container');
            if (container && !container.contains(e.target)) closeThemeDropdown();
        });
        function getPreferredTheme() {
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }
        function applyTheme(theme) {
            var isDark = theme === 'dark' || (theme === 'auto' && getPreferredTheme() === 'dark');
            document.documentElement.classList.toggle('dark', isDark);
            var icon = document.getElementById('theme-icon');
            if (icon) icon.textContent = isDark ? 'dark_mode' : 'light_mode';
        }
        function setTheme(theme) {
            localStorage.setItem('theme', theme);
            applyTheme(theme);
            closeThemeDropdown();
        }
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function() {
            var theme = localStorage.getItem('theme') || 'auto';
            if (theme === 'auto') applyTheme('auto');
        });
        var savedTheme = localStorage.getItem('theme') || 'auto';
        applyTheme(savedTheme);

        function updateTime() {
            var now = new Date();
            var h = now.getHours(), m = String(now.getMinutes()).padStart(2, '0');
            var el = document.getElementById('header-time');
            if (el) el.textContent = (h % 12 || 12) + ':' + m + ' ' + (h >= 12 ? 'م' : 'ص');
        }
        updateTime();
        setInterval(updateTime, 30000);
    </script>
</body>
</html>
