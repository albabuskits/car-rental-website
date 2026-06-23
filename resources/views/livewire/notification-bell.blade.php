<div class="relative" x-data="{ open: false }" wire:poll.10s="loadNotifications">
    <button @click="open = !open; if(open) $wire.toggleDropdown()" class="relative p-xs text-on-surface-variant hover:text-secondary transition-colors" title="الإشعارات">
        <span class="material-symbols-outlined">notifications</span>
        @if($unreadCount > 0)
        <span class="absolute -top-0.5 -right-0.5 bg-error text-on-error text-[10px] font-bold px-1 py-0.5 rounded-full min-w-[16px] text-center leading-tight">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
        @endif
    </button>
    <div x-show="open" @click.outside="open = false; $wire.showDropdown = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute left-0 top-full mt-xs w-80 bg-surface custom-shadow rounded-xl border border-outline-variant overflow-hidden z-50">
        <div class="px-md py-sm border-b border-outline-variant flex items-center justify-between">
            <h4 class="font-label-md text-label-md text-on-surface">الإشعارات</h4>
            @auth
            @if(auth()->user()->hasRole('admin'))
            <a href="{{ route('admin.bookings') }}" class="text-label-sm text-secondary hover:underline">عرض الكل</a>
            @else
            <a href="/dashboard" class="text-label-sm text-secondary hover:underline">عرض الكل</a>
            @endif
            @endauth
        </div>
        <div class="max-h-80 overflow-y-auto">
            @forelse($notifications as $log)
            <div @click="open = false; window.location.href = '{{ $log['url'] }}'" class="flex items-start gap-sm px-md py-sm hover:bg-surface-container-high transition-colors border-b border-outline-variant/50 last:border-0 cursor-pointer">
                <span class="material-symbols-outlined text-[20px] mt-0.5 {{ $log['icon_color'] }}">{{ $log['icon'] }}</span>
                <div class="flex-1 min-w-0">
                    <p class="font-label-sm text-label-sm text-on-surface truncate">{{ $log['description'] }}</p>
                    <p class="text-[11px] text-on-surface-variant mt-0.5" dir="ltr">{{ $log['time'] }}</p>
                </div>
                <button @click.stop="open = false; $wire.dismiss({{ $log['id'] }})" class="p-1 rounded text-on-surface-variant/50 hover:text-on-surface-variant hover:bg-surface-container-high transition-colors flex-shrink-0" title="تجاهل">
                    <span class="material-symbols-outlined text-[16px]">close</span>
                </button>
            </div>
            @empty
            <div class="px-md py-lg text-center text-on-surface-variant">
                <span class="material-symbols-outlined text-3xl block mb-sm">notifications_none</span>
                <p class="font-body-md text-body-md">لا توجد إشعارات جديدة</p>
            </div>
            @endforelse
        </div>
        <div class="px-md py-sm border-t border-outline-variant bg-surface-container-low">
            @auth
            @if(auth()->user()->hasRole('admin'))
            <a href="{{ route('admin.bookings') }}" class="block w-full text-center py-sm bg-surface text-on-surface rounded-lg font-label-md text-label-md hover:bg-surface-container-high transition-colors">
                عرض جميع طلبات الحجز
            </a>
            @else
            <a href="/dashboard" class="block w-full text-center py-sm bg-surface text-on-surface rounded-lg font-label-md text-label-md hover:bg-surface-container-high transition-colors">
                الذهاب إلى لوحة المستخدم
            </a>
            @endif
            @endauth
        </div>
    </div>
</div>
