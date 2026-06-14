<div>
    <div class="flex justify-end mb-lg">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="px-md py-sm bg-error text-on-error rounded-lg font-label-md text-label-md flex items-center gap-xs hover:opacity-90 transition-all">
                <span class="material-symbols-outlined text-[18px]">logout</span>تسجيل الخروج
            </button>
        </form>
    </div>
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-lg">
        <div class="bg-surface custom-shadow p-lg rounded-xl flex flex-col justify-between border border-transparent hover:border-secondary-container transition-all group">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 bg-surface-container-high rounded-lg flex items-center justify-center text-secondary group-hover:bg-secondary group-hover:text-on-secondary transition-colors">
                    <span class="material-symbols-outlined">directions_car</span>
                </div>
                <span class="text-label-sm flex items-center text-green-600">
                    <span class="material-symbols-outlined text-[16px]">trending_up</span>+12%
                </span>
            </div>
            <div class="mt-md">
                <p class="font-label-sm text-on-surface-variant">إجمالي السيارات</p>
                <h3 class="font-display-lg text-display-lg text-on-surface mt-xs tracking-tight">{{ $totalCars }}</h3>
            </div>
        </div>
        <div class="bg-surface custom-shadow p-lg rounded-xl flex flex-col justify-between border border-transparent hover:border-secondary-container transition-all group">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 bg-surface-container-high rounded-lg flex items-center justify-center text-secondary group-hover:bg-secondary group-hover:text-on-secondary transition-colors">
                    <span class="material-symbols-outlined">event_available</span>
                </div>
                <span class="text-label-sm flex items-center">
                    <span class="material-symbols-outlined text-[16px]">trending_down</span>-2%
                </span>
            </div>
            <div class="mt-md">
                <p class="font-label-sm text-on-surface-variant">الحجوزات النشطة</p>
                <h3 class="font-display-lg text-display-lg text-on-surface mt-xs tracking-tight">{{ $activeBookings }}</h3>
            </div>
        </div>
        <div class="bg-surface custom-shadow p-lg rounded-xl flex flex-col justify-between border border-transparent hover:border-secondary-container transition-all group">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 bg-surface-container-high rounded-lg flex items-center justify-center text-secondary group-hover:bg-secondary group-hover:text-on-secondary transition-colors">
                    <span class="material-symbols-outlined">group_add</span>
                </div>
                <span class="text-label-sm flex items-center text-green-600">
                    <span class="material-symbols-outlined text-[16px]">trending_up</span>+24%
                </span>
            </div>
            <div class="mt-md">
                <p class="font-label-sm text-on-surface-variant">المستخدمون المسجلون</p>
                <h3 class="font-display-lg text-display-lg text-on-surface mt-xs tracking-tight">{{ $totalUsers }}</h3>
            </div>
        </div>
        <div class="bg-primary-container p-lg rounded-xl flex flex-col justify-between text-on-secondary overflow-hidden relative">
            <div class="absolute -left-4 -top-4 opacity-10">
                <span class="material-symbols-outlined text-[120px]">payments</span>
            </div>
            <div class="z-10">
                <p class="font-label-sm text-on-primary-container">إجمالي الإيرادات الشهرية</p>
                <h3 class="font-display-lg text-display-lg mt-xs tracking-tight">${{ number_format($monthlyRevenue, 1) }}k</h3>
            </div>
            <button class="mt-md z-10 w-full py-sm bg-on-secondary text-primary font-label-md rounded-lg flex items-center justify-center gap-xs hover:bg-surface-container-lowest transition-colors">
                عرض التقرير <span class="material-symbols-outlined text-[18px] rtl-flip">arrow_back</span>
            </button>
        </div>
    </section>
    <section class="bg-surface custom-shadow rounded-xl overflow-hidden border border-outline-variant">
        <div class="p-lg flex flex-col md:flex-row justify-between items-start md:items-center gap-md bg-surface">
            <div>
                <h4 class="font-headline-md text-headline-md text-on-surface">أحدث الحجوزات</h4>
                <p class="font-body-md text-on-surface-variant">إدارة أحدث حجوزات واستئجار السيارات.</p>
            </div>
            <div class="flex gap-sm w-full md:w-auto">
                <div class="relative flex-grow md:w-64">
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                    <input wire:model.live.debounce.300ms="search" class="w-full pr-10 pl-4 py-2 border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none text-body-md" placeholder="ابحث عن حجز..." type="text"/>
                </div>
                <button class="px-md py-2 border border-outline-variant rounded-lg font-label-md text-on-surface flex items-center gap-xs hover:bg-surface-container-low transition-colors">
                    <span class="material-symbols-outlined">filter_list</span>تصفية
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-surface-container-low">
                        <th class="text-right p-md font-label-md text-on-surface border-b border-outline-variant">معرف الحجز</th>
                        <th class="text-right p-md font-label-md text-on-surface border-b border-outline-variant">العميل</th>
                        <th class="text-right p-md font-label-md text-on-surface border-b border-outline-variant">السيارة</th>
                        <th class="text-right p-md font-label-md text-on-surface border-b border-outline-variant">المدة</th>
                        <th class="text-right p-md font-label-md text-on-surface border-b border-outline-variant">الحالة</th>
                        <th class="text-left p-md font-label-md text-on-surface border-b border-outline-variant">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($recentBookings as $booking)
                    <tr class="hover:bg-surface-container-low transition-colors">
                        <td class="p-md font-label-md text-secondary">#ARB-{{ $booking['id'] }}</td>
                        <td class="p-md">
                            <div class="flex items-center gap-sm">
                                <div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center text-xs font-bold text-primary">
                                    {{ mb_substr($booking['customer_name'], 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-label-md text-on-surface">{{ $booking['customer_name'] }}</p>
                                    <p class="text-[12px] text-on-surface-variant">{{ $booking['customer_email'] }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-md">
                            <p class="font-label-md text-on-surface">{{ $booking['car']['brand'] ?? '' }} {{ $booking['car']['model'] ?? '' }}</p>
                            <p class="text-[12px] text-on-surface-variant">{{ $booking['car']['category'] ?? '' }}</p>
                        </td>
                        <td class="p-md font-body-md text-on-surface-variant">
                            {{ \Carbon\Carbon::parse($booking['pickup_date'])->format('d M') }} - {{ \Carbon\Carbon::parse($booking['return_date'])->format('d M') }}
                        </td>
                        <td class="p-md">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'confirmed' => 'bg-green-100 text-green-700',
                                    'active' => 'bg-blue-100 text-blue-700',
                                    'completed' => 'bg-gray-100 text-gray-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                ];
                                $statusLabels = [
                                    'pending' => 'معلق',
                                    'confirmed' => 'مؤكد',
                                    'active' => 'قيد التنفيذ',
                                    'completed' => 'مكتمل',
                                    'cancelled' => 'ملغي',
                                ];
                                $color = $statusColors[$booking['status']] ?? 'bg-gray-100 text-gray-700';
                                $label = $statusLabels[$booking['status']] ?? $booking['status'];
                            @endphp
                            <span class="px-3 py-1 rounded-full {{ $color }} text-[12px] font-bold">{{ $label }}</span>
                        </td>
                        <td class="p-md text-left">
                            <button wire:click="viewBooking({{ $booking['id'] }})" class="p-xs text-on-surface-variant hover:text-secondary transition-colors">
                                <span class="material-symbols-outlined">visibility</span>
                            </button>
                            @if($booking['status'] === 'pending')
                            <button wire:click="cancelBooking({{ $booking['id'] }})" class="p-xs text-on-surface-variant hover:text-error transition-colors">
                                <span class="material-symbols-outlined">cancel</span>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-md text-center text-on-surface-variant font-body-md">لا توجد حجوزات حالياً</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-md bg-surface-container-low flex justify-between items-center border-t border-outline-variant">
            <p class="font-label-sm text-on-surface-variant">عرض {{ count($recentBookings) }} من {{ \App\Models\Booking::count() }} حجزاً</p>
            <div class="flex gap-xs">
                <button class="p-xs border border-outline-variant rounded hover:bg-surface transition-colors disabled:opacity-50" disabled>
                    <span class="material-symbols-outlined rtl-flip">chevron_right</span>
                </button>
                <button class="px-3 py-1 bg-secondary text-on-secondary rounded font-label-sm">1</button>
                <button class="px-3 py-1 border border-outline-variant rounded font-label-sm hover:bg-surface">2</button>
                <button class="px-3 py-1 border border-outline-variant rounded font-label-sm hover:bg-surface">3</button>
                <button class="p-xs border border-outline-variant rounded hover:bg-surface transition-colors">
                    <span class="material-symbols-outlined rtl-flip">chevron_left</span>
                </button>
            </div>
        </div>
    </section>
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-lg">
        <div class="lg:col-span-1 bg-surface custom-shadow rounded-xl p-lg border border-outline-variant">
            <h4 class="font-label-md text-on-surface mb-md">حالة صحة الأسطول</h4>
            <div class="space-y-md">
                @php
                    $total = max($totalCars, 1);
                    $availPct = round(($availableCars / $total) * 100);
                    $maintPct = round(($maintenanceCars / $total) * 100);
                    $inspectPct = round(($inspectionCars / $total) * 100);
                @endphp
                <div>
                    <div class="flex justify-between text-label-sm mb-xs">
                        <span class="text-on-surface-variant">قيد التشغيل</span>
                        <span class="text-on-surface">{{ $availPct }}%</span>
                    </div>
                    <div class="w-full h-2 bg-surface-container-high rounded-full overflow-hidden">
                        <div class="h-full bg-green-500" style="width: {{ $availPct }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-label-sm mb-xs">
                        <span class="text-on-surface-variant">قيد الصيانة</span>
                        <span class="text-on-surface">{{ $maintPct }}%</span>
                    </div>
                    <div class="w-full h-2 bg-surface-container-high rounded-full overflow-hidden">
                        <div class="h-full bg-yellow-500" style="width: {{ $maintPct }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-label-sm mb-xs">
                        <span class="text-on-surface-variant">يتطلب فحصاً</span>
                        <span class="text-on-surface">{{ $inspectPct }}%</span>
                    </div>
                    <div class="w-full h-2 bg-surface-container-high rounded-full overflow-hidden">
                        <div class="h-full bg-error" style="width: {{ $inspectPct }}%"></div>
                    </div>
                </div>
            </div>
            <div class="mt-xl pt-lg border-t border-outline-variant flex items-center justify-between">
                <div class="flex items-center gap-xs text-secondary">
                    <span class="material-symbols-outlined">build</span>
                    <span class="font-label-md">سجل الصيانة</span>
                </div>
                <span class="material-symbols-outlined text-on-surface-variant rtl-flip">arrow_back</span>
            </div>
        </div>
        <div class="lg:col-span-2 relative h-[320px] rounded-xl overflow-hidden custom-shadow group">
            <div id="fleet-map" class="w-full h-full z-0"></div>
            <div class="absolute bottom-6 right-6 z-[1000] pointer-events-none">
                <h5 class="font-headline-md text-headline-md text-white drop-shadow-lg">توزيع الأسطول</h5>
                <p class="font-body-md text-white/90 drop-shadow">تم تفعيل التتبع GPS المباشر لـ {{ $totalCars }} مركبة.</p>
            </div>
        </div>
    </section>
</div>