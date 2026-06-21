<div>
    <div class="flex justify-end mb-lg">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="px-md py-sm bg-error text-on-error rounded-lg font-label-md text-label-md flex items-center gap-xs hover:opacity-90 transition-all">
                <span class="material-symbols-outlined text-[18px]">logout</span>تسجيل الخروج
            </button>
        </form>
    </div>
    @if (session()->has('message'))
    <div class="bg-green-100 text-green-700 px-md py-sm rounded-lg font-label-md mb-lg flex items-center gap-sm">
        <span class="material-symbols-outlined">check_circle</span>
        {{ session('message') }}
    </div>
    @endif

    <header class="mb-xl flex flex-col md:flex-row md:items-center justify-between gap-md">
        <div>
            <nav class="flex items-center gap-xs text-on-surface-variant mb-xs">
                <span class="font-label-sm text-label-sm">الإدارة</span>
                <span class="material-symbols-outlined text-[16px] rtl-flip">chevron_left</span>
                <span class="font-label-sm text-label-sm text-primary font-bold">إدارة الحجوزات</span>
            </nav>
            <h2 class="font-headline-lg text-headline-lg text-on-surface">إدارة الحجوزات</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">نظرة عامة وإجراءات لطلبات تأجير السيارات الحالية.</p>
        </div>
        <div class="flex items-center gap-sm">
            <button class="bg-surface border border-outline-variant text-on-surface-variant px-md py-xs rounded-lg flex items-center gap-xs font-label-md text-label-md hover:bg-surface-container hover:border-primary transition-all">
                <span class="material-symbols-outlined">file_download</span>تصدير CSV
            </button>
        </div>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-md mb-xl">
        <div class="md:col-span-1 bg-primary-container text-on-primary-container p-lg rounded-xl shadow-sm border border-primary/10">
            <div class="flex items-center justify-between mb-sm">
                <span class="font-label-md text-label-md">الطلبات المعلقة</span>
                <span class="material-symbols-outlined">pending</span>
            </div>
            <p class="text-[32px] font-bold leading-none mb-1">{{ $pendingCount }}</p>
            <p class="font-label-sm text-label-sm opacity-80">في انتظار المراجعة</p>
        </div>
        <div class="md:col-span-1 bg-surface border border-outline-variant p-lg rounded-xl shadow-sm">
            <div class="flex items-center justify-between mb-sm">
                <span class="font-label-md text-label-md text-on-surface-variant">تمت الموافقة اليوم</span>
                <span class="material-symbols-outlined text-secondary">check_circle</span>
            </div>
            <p class="text-[32px] font-bold leading-none mb-1 text-on-surface">{{ $confirmedToday }}</p>
            <p class="font-label-sm text-label-sm text-on-surface-variant">معدل موافقة 82%</p>
        </div>
        <div class="md:col-span-2 bg-surface border border-outline-variant p-lg rounded-xl shadow-sm flex items-center justify-between">
            <div>
                <span class="font-label-md text-label-md text-on-surface-variant mb-xs block">استخدام الأسطول النشط</span>
                <p class="text-[32px] font-bold leading-none mb-1 text-on-surface">89%</p>
                <p class="font-label-sm text-label-sm text-on-surface-variant">142 سيارة على الطريق حالياً</p>
            </div>
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
        <div class="relative flex-1 w-full">
            <span class="absolute right-md top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant">search</span>
            <input wire:model.live.debounce.300ms="search" class="w-full pr-xl pl-md py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary bg-surface text-body-md outline-none" placeholder="ابحث باسم العميل أو طراز السيارة..." type="text"/>
        </div>
        <div class="flex items-center gap-xs overflow-x-auto pb-1 md:pb-0 w-full md:w-auto">
            <button wire:click="$set('statusFilter', '')" class="whitespace-nowrap px-md py-xs rounded-full font-label-md text-label-md transition-all {{ empty($statusFilter) ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-low border border-outline-variant text-on-surface-variant hover:border-secondary' }}">جميع الحجوزات</button>
            <button wire:click="$set('statusFilter', 'pending')" class="whitespace-nowrap px-md py-xs rounded-full font-label-md text-label-md transition-all {{ $statusFilter === 'pending' ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-low border border-outline-variant text-on-surface-variant hover:border-secondary' }}">معلقة</button>
            <button wire:click="$set('statusFilter', 'confirmed')" class="whitespace-nowrap px-md py-xs rounded-full font-label-md text-label-md transition-all {{ $statusFilter === 'confirmed' ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-low border border-outline-variant text-on-surface-variant hover:border-secondary' }}">موافق عليها</button>
            <button wire:click="$set('statusFilter', 'cancelled')" class="whitespace-nowrap px-md py-xs rounded-full font-label-md text-label-md transition-all {{ $statusFilter === 'cancelled' ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-low border border-outline-variant text-on-surface-variant hover:border-secondary' }}">ملغية</button>
        </div>
        <div class="flex items-center gap-sm w-full md:w-auto">
            <div class="h-8 w-[1px] bg-outline-variant hidden md:block"></div>
            <button class="flex items-center gap-xs text-on-surface-variant font-label-md text-label-md hover:text-primary transition-colors">
                <span class="material-symbols-outlined">calendar_today</span>آخر 30 يوماً <span class="material-symbols-outlined">expand_more</span>
            </button>
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
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-surface-container-low transition-colors group">
                        <td class="px-md py-md">
                            <div class="flex items-center gap-sm">
                                <div class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center text-primary font-bold">
                                    {{ mb_substr($booking->customer_name, 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-label-md text-label-md text-on-surface">{{ $booking->customer_name }}</p>
                                    <p class="font-label-sm text-label-sm text-on-surface-variant">{{ $booking->customer_email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-md py-md">
                            <div>
                                <p class="font-label-md text-label-md text-on-surface">{{ $booking->car?->brand ?? 'غير محدد' }} {{ $booking->car?->model ?? '' }}</p>
                                <p class="font-label-sm text-label-sm text-on-surface-variant">{{ $booking->car?->category ?? '' }}</p>
                            </div>
                        </td>
                        <td class="px-md py-md">
                            <div class="font-label-md text-label-md text-on-surface">{{ $booking->pickup_date->format('d M') }} - {{ $booking->return_date->format('d M') }}</div>
                            <p class="font-label-sm text-label-sm text-on-surface-variant">{{ $booking->pickup_date->diffInDays($booking->return_date) }} أيام</p>
                        </td>
                        <td class="px-md py-md"><span class="font-label-md text-label-md text-on-surface">${{ number_format($booking->total_price, 2) }}</span></td>
                        <td class="px-md py-md">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'confirmed' => 'bg-green-100 text-green-800',
                                    'active' => 'bg-blue-100 text-blue-800',
                                    'completed' => 'bg-gray-100 text-gray-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                                $statusLabels = [
                                    'pending' => 'معلق',
                                    'confirmed' => 'موافق',
                                    'active' => 'قيد التنفيذ',
                                    'completed' => 'مكتمل',
                                    'cancelled' => 'ملغي',
                                ];
                            @endphp
                            <span class="px-sm py-1 rounded-full {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }} text-[12px] font-bold uppercase tracking-tight">{{ $statusLabels[$booking->status] ?? $booking->status }}</span>
                        </td>
                        <td class="px-md py-md text-left">
                            <div class="flex items-center justify-end gap-xs">
                                @if($booking->status === 'pending')
                                <button wire:click="updateStatus({{ $booking->id }}, 'confirmed')" class="p-2 rounded-lg text-primary hover:bg-primary/10 transition-colors" title="موافقة">
                                    <span class="material-symbols-outlined">check_circle</span>
                                </button>
                                <button wire:click="updateStatus({{ $booking->id }}, 'cancelled')" class="p-2 rounded-lg text-error hover:bg-error/10 transition-colors" title="رفض">
                                    <span class="material-symbols-outlined">cancel</span>
                                </button>
                                @endif
                                @if($booking->status !== 'completed')
                                <button wire:click="openEditModal({{ $booking->id }})" class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors" title="تعديل">
                                    <span class="material-symbols-outlined">edit</span>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-md py-xl text-center text-on-surface-variant font-body-md">لا توجد حجوزات متطابقة.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-md py-md bg-surface-container-low border-t border-outline-variant flex items-center justify-between">
            <p class="font-label-sm text-label-sm text-on-surface-variant">عرض {{ $bookings->firstItem() ?? 0 }} إلى {{ $bookings->lastItem() ?? 0 }} من {{ $bookings->total() }} حجزاً</p>
            <div class="flex items-center gap-xs">
                @if ($bookings->onFirstPage())
                <button class="p-2 rounded-lg border border-outline-variant opacity-30" disabled>
                    <span class="material-symbols-outlined rtl-flip">chevron_right</span>
                </button>
                @else
                <button wire:click="previousPage" class="p-2 rounded-lg border border-outline-variant hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined rtl-flip">chevron_right</span>
                </button>
                @endif
                <span class="w-8 h-8 rounded-lg bg-primary text-on-primary font-bold text-label-sm flex items-center justify-center">{{ $bookings->currentPage() }}</span>
                @if ($bookings->hasMorePages())
                <button wire:click="nextPage" class="p-2 rounded-lg border border-outline-variant hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined rtl-flip">chevron_left</span>
                </button>
                @else
                <button class="p-2 rounded-lg border border-outline-variant opacity-30" disabled>
                    <span class="material-symbols-outlined rtl-flip">chevron_left</span>
                </button>
                @endif
            </div>
        </div>
    </div>

    @if($showEditModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm" wire:click.self="closeEditModal">
        <div class="bg-surface w-full max-w-lg rounded-2xl modal-shadow overflow-hidden" @click.stop>
            <header class="px-lg py-md border-b border-outline-variant flex items-center justify-between">
                <h3 class="font-headline-md text-headline-md text-on-surface">تعديل الحجز</h3>
                <button wire:click="closeEditModal" class="p-xs rounded-full hover:bg-surface-container-high text-on-surface-variant transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </header>
            <form wire:submit="updateBooking" class="p-lg space-y-md">
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">اسم العميل</label>
                    <input wire:model="customer_name" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="text"/>
                    @error('customer_name') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-md">
                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface">البريد الإلكتروني</label>
                        <input wire:model="customer_email" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="email"/>
                        @error('customer_email') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface">رقم الهاتف</label>
                        <input wire:model="customer_phone" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="text"/>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-md">
                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface">تاريخ الاستلام</label>
                        <input wire:model="pickup_date" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="datetime-local"/>
                        @error('pickup_date') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface">تاريخ الإرجاع</label>
                        <input wire:model="return_date" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="datetime-local"/>
                        @error('return_date') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-md">
                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface">السعر الإجمالي</label>
                        <input wire:model="total_price" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="number" step="0.01"/>
                        @error('total_price') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface">الحالة</label>
                        <select wire:model="status" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none bg-white">
                            <option value="pending">معلق</option>
                            <option value="confirmed">موافق</option>
                            <option value="active">قيد التنفيذ</option>
                            <option value="completed">مكتمل</option>
                            <option value="cancelled">ملغي</option>
                        </select>
                    </div>
                </div>
                <footer class="flex justify-end gap-md pt-md border-t border-outline-variant">
                    <button type="button" wire:click="closeEditModal" class="px-lg py-sm font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors">إلغاء</button>
                    <button type="submit" class="bg-primary text-on-primary px-xl py-sm rounded-lg font-label-md text-label-md hover:opacity-90 active:scale-95 transition-all">تحديث الحجز</button>
                </footer>
            </form>
        </div>
    </div>
    @endif

    <div class="mt-xl glass-card rounded-xl p-md flex items-start gap-md border-r-4 border-secondary shadow-sm">
        <div class="p-xs rounded-full bg-secondary-fixed text-on-secondary-fixed">
            <span class="material-symbols-outlined">lightbulb</span>
        </div>
        <div>
            <h4 class="font-label-md text-label-md text-on-surface">نصيحة: الموافقة الجماعية</h4>
            <p class="font-body-md text-body-md text-on-surface-variant">يمكنك تحديد طلبات معلقة متعددة للموافقة عليها مرة واحدة. اضغط مع الاستمرار على مفتاح Shift أثناء النقر على مربعات الاختيار (الميزة قريباً!).</p>
        </div>
        <button class="mr-auto text-on-surface-variant hover:text-on-surface transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>
</div>