<div>
    @if (session()->has('message'))
    <div class="flash-message flash-message-success">
        <span class="material-symbols-outlined text-[18px]">check_circle</span>
        {{ session('message') }}
    </div>
    @endif

    <div class="flex justify-end mb-lg">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="px-md py-sm bg-error text-on-error rounded-lg font-label-md text-label-md flex items-center gap-xs hover:opacity-90 transition-all">
                <span class="material-symbols-outlined text-[18px]">logout</span>تسجيل الخروج
            </button>
        </form>
    </div>

    <div class="flex gap-xs mb-xl overflow-x-auto pb-xs">
        <button wire:click="switchTab('overview')" class="px-md py-sm rounded-lg font-label-md text-label-md whitespace-nowrap {{ $tab === 'overview' ? 'bg-primary text-on-primary' : 'bg-surface-container-low text-on-surface-variant border border-outline-variant hover:bg-surface-container-high' }}">
            <span class="material-symbols-outlined text-[18px] align-middle">dashboard</span> نظرة عامة
        </button>
        <button wire:click="switchTab('bookings')" class="px-md py-sm rounded-lg font-label-md text-label-md whitespace-nowrap {{ $tab === 'bookings' ? 'bg-primary text-on-primary' : 'bg-surface-container-low text-on-surface-variant border border-outline-variant hover:bg-surface-container-high' }}">
            <span class="material-symbols-outlined text-[18px] align-middle">calendar_month</span> حجوزاتي
        </button>
        <button wire:click="switchTab('messages')" class="px-md py-sm rounded-lg font-label-md text-label-md whitespace-nowrap {{ $tab === 'messages' ? 'bg-primary text-on-primary' : 'bg-surface-container-low text-on-surface-variant border border-outline-variant hover:bg-surface-container-high' }}">
            <span class="material-symbols-outlined text-[18px] align-middle">mail</span> الرسائل
        </button>
        <button wire:click="switchTab('license')" class="px-md py-sm rounded-lg font-label-md text-label-md whitespace-nowrap {{ $tab === 'license' ? 'bg-primary text-on-primary' : 'bg-surface-container-low text-on-surface-variant border border-outline-variant hover:bg-surface-container-high' }}">
            <span class="material-symbols-outlined text-[18px] align-middle">badge</span> رخصة القيادة
        </button>
        <button wire:click="switchTab('profile')" class="px-md py-sm rounded-lg font-label-md text-label-md whitespace-nowrap {{ $tab === 'profile' ? 'bg-primary text-on-primary' : 'bg-surface-container-low text-on-surface-variant border border-outline-variant hover:bg-surface-container-high' }}">
            <span class="material-symbols-outlined text-[18px] align-middle">person</span> الملف الشخصي
        </button>
    </div>

    @if($tab === 'overview')
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-lg mb-xl">
        <div class="bg-surface custom-shadow p-lg rounded-xl border border-outline-variant">
            <div class="flex items-center gap-sm">
                <div class="w-10 h-10 bg-surface-container-high rounded-lg flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined">calendar_month</span>
                </div>
                <div>
                    <p class="font-label-sm text-on-surface-variant">إجمالي الحجوزات</p>
                    <h3 class="font-headline-md text-headline-md text-on-surface">{{ $totalBookings }}</h3>
                </div>
            </div>
        </div>
        <div class="bg-surface custom-shadow p-lg rounded-xl border border-outline-variant">
            <div class="flex items-center gap-sm">
                <div class="w-10 h-10 bg-surface-container-high rounded-lg flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined">pending</span>
                </div>
                <div>
                    <p class="font-label-sm text-on-surface-variant">قيد الانتظار</p>
                    <h3 class="font-headline-md text-headline-md text-on-surface">{{ $pendingBookings }}</h3>
                </div>
            </div>
        </div>
        <div class="bg-surface custom-shadow p-lg rounded-xl border border-outline-variant">
            <div class="flex items-center gap-sm">
                <div class="w-10 h-10 bg-surface-container-high rounded-lg flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined">check_circle</span>
                </div>
                <div>
                    <p class="font-label-sm text-on-surface-variant">نشطة</p>
                    <h3 class="font-headline-md text-headline-md text-on-surface">{{ $activeBookings }}</h3>
                </div>
            </div>
        </div>
        <div class="bg-surface custom-shadow p-lg rounded-xl border border-outline-variant">
            <div class="flex items-center gap-sm">
                <div class="w-10 h-10 bg-surface-container-high rounded-lg flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined">directions_car</span>
                </div>
                <div>
                    <p class="font-label-sm text-on-surface-variant">السيارات المتاحة</p>
                    <h3 class="font-headline-md text-headline-md text-on-surface">{{ $availableCars }}</h3>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-surface custom-shadow rounded-xl border border-outline-variant p-lg mb-xl">
        <div class="flex items-center justify-between">
            <h3 class="font-headline-md text-headline-md text-on-surface">تأجير سيارة</h3>
            <a href="{{ url('/cars') }}" class="bg-primary text-on-primary px-xl py-sm rounded-lg font-label-md text-label-md hover:opacity-90 active:scale-95 transition-all flex items-center gap-xs">
                <span class="material-symbols-outlined text-[18px]">search</span>
                تصفح السيارات المتاحة
            </a>
        </div>
    </section>

    <section class="bg-surface custom-shadow rounded-xl border border-outline-variant p-lg">
        <h3 class="font-headline-md text-headline-md text-on-surface mb-md">أحدث حجوزاتي</h3>
        @if($bookings->count() > 0)
        <div class="space-y-sm">
            @foreach($bookings->take(5) as $booking)
            <div class="flex items-center justify-between p-md bg-surface-container-low rounded-lg">
                <div>
                    <p class="font-label-md text-on-surface">{{ $booking->car?->brand ?? 'سيارة' }} {{ $booking->car?->model ?? '' }}</p>
                    <p class="text-xs text-on-surface-variant">{{ \Carbon\Carbon::parse($booking->pickup_date)->format('Y-m-d') }} → {{ \Carbon\Carbon::parse($booking->return_date)->format('Y-m-d') }}</p>
                </div>
                @php
                    $statusMap = ['pending' => ['class' => 'status-badge-pending', 'label' => 'معلق'], 'confirmed' => ['class' => 'status-badge-confirmed', 'label' => 'مؤكد'], 'active' => ['class' => 'status-badge-active', 'label' => 'نشط'], 'completed' => ['class' => 'status-badge-completed', 'label' => 'مكتمل'], 'cancelled' => ['class' => 'status-badge-cancelled', 'label' => 'ملغي']];
                    $s = $statusMap[$booking->status] ?? ['class' => 'status-badge-completed', 'label' => $booking->status];
                @endphp
                <span class="status-badge {{ $s['class'] }}">{{ $s['label'] }}</span>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-on-surface-variant font-body-md text-center py-lg">لا توجد حجوزات بعد. <a href="{{ url('/cars') }}" class="text-secondary hover:underline">تصفح السيارات</a></p>
        @endif
    </section>
    @endif

    @if($tab === 'bookings')
    <section class="bg-surface custom-shadow rounded-xl border border-outline-variant overflow-hidden">
        <div class="p-lg">
            <h3 class="font-headline-md text-headline-md text-on-surface">حجوزاتي</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-surface-container-low">
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">السيارة</th>
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">تاريخ البداية</th>
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">تاريخ النهاية</th>
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">المبلغ</th>
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">الحالة</th>
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/50">
                    @forelse($bookings as $booking)
                    <tr class="table-row-hover">
                        <td class="px-md py-md font-label-md text-on-surface">{{ $booking->car?->brand ?? '—' }} {{ $booking->car?->model ?? '' }}</td>
                        <td class="px-md py-md text-on-surface-variant">{{ \Carbon\Carbon::parse($booking->pickup_date)->format('Y-m-d') }}</td>
                        <td class="px-md py-md text-on-surface-variant">{{ \Carbon\Carbon::parse($booking->return_date)->format('Y-m-d') }}</td>
                        <td class="px-md py-md font-label-md text-on-surface">${{ number_format($booking->total_price, 2) }}</td>
                        <td class="px-md py-md">
                            @php
                                $sm = ['pending' => ['class' => 'status-badge-pending', 'label' => 'معلق'], 'confirmed' => ['class' => 'status-badge-confirmed', 'label' => 'مؤكد'], 'active' => ['class' => 'status-badge-active', 'label' => 'نشط'], 'completed' => ['class' => 'status-badge-completed', 'label' => 'مكتمل'], 'cancelled' => ['class' => 'status-badge-cancelled', 'label' => 'ملغي']];
                                $st = $sm[$booking->status] ?? ['class' => 'status-badge-completed', 'label' => $booking->status];
                            @endphp
                            <span class="status-badge {{ $st['class'] }}">{{ $st['label'] }}</span>
                        </td>
                        <td class="px-md py-md">
                            @if($booking->status === 'pending')
                            <button wire:click="cancelBooking({{ $booking->id }})" wire:confirm="هل أنت متأكد من إلغاء هذا الحجز؟" class="text-error font-label-sm text-label-sm hover:underline flex items-center gap-xs">
                                <span class="material-symbols-outlined text-[16px]">cancel</span> إلغاء
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-md py-xl text-center text-on-surface-variant font-body-md">لا توجد حجوزات.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-md py-sm bg-surface-container-low border-t border-outline-variant/50 flex items-center justify-between">
            <p class="font-label-sm text-label-sm text-on-surface-variant">عرض {{ $bookings->firstItem() ?? 0 }} إلى {{ $bookings->lastItem() ?? 0 }} من {{ $bookings->total() }}</p>
            <div class="flex items-center gap-1">
                @if ($bookings->onFirstPage())
                <button class="w-8 h-8 flex items-center justify-center border border-outline-variant rounded-lg text-on-surface-variant opacity-30" disabled>
                    <span class="material-symbols-outlined text-[18px] rtl-flip">chevron_right</span>
                </button>
                @else
                <button wire:click="previousPage" class="w-8 h-8 flex items-center justify-center border border-outline-variant rounded-lg text-on-surface-variant hover:bg-surface transition-colors">
                    <span class="material-symbols-outlined text-[18px] rtl-flip">chevron_right</span>
                </button>
                @endif
                <span class="w-8 h-8 rounded-lg bg-secondary text-on-secondary font-bold text-label-sm flex items-center justify-center">{{ $bookings->currentPage() }}</span>
                @if ($bookings->hasMorePages())
                <button wire:click="nextPage" class="w-8 h-8 flex items-center justify-center border border-outline-variant rounded-lg text-on-surface-variant hover:bg-surface transition-colors">
                    <span class="material-symbols-outlined text-[18px] rtl-flip">chevron_left</span>
                </button>
                @else
                <button class="w-8 h-8 flex items-center justify-center border border-outline-variant rounded-lg text-on-surface-variant opacity-30" disabled>
                    <span class="material-symbols-outlined text-[18px] rtl-flip">chevron_left</span>
                </button>
                @endif
            </div>
        </div>
    </section>
    @endif

    @if($tab === 'messages')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-lg">
        <section class="bg-surface custom-shadow rounded-xl border border-outline-variant p-lg">
            <h3 class="font-headline-md text-headline-md text-on-surface mb-md">إرسال رسالة إلى الإدارة</h3>
            <form wire:submit="sendMessage" class="space-y-md">
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">الموضوع</label>
                    <input wire:model="messageSubject" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" placeholder="مثال: طلب تمديد الحجز" type="text"/>
                    @error('messageSubject') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">الرسالة</label>
                    <textarea wire:model="messageBody" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" rows="5" placeholder="اكتب رسالتك هنا..."></textarea>
                    @error('messageBody') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="bg-primary text-on-primary px-xl py-sm rounded-lg font-label-md text-label-md hover:opacity-90 active:scale-95 transition-all">إرسال الرسالة</button>
            </form>
        </section>
        <section class="bg-surface custom-shadow rounded-xl border border-outline-variant p-lg">
            <h3 class="font-headline-md text-headline-md text-on-surface mb-md">الرسائل السابقة</h3>
            @if($messages->count() > 0)
            <div class="space-y-sm">
                @foreach($messages as $msg)
                <div class="p-md bg-surface-container-low rounded-lg {{ !$msg->is_read ? 'border-r-4 border-secondary' : '' }}">
                    <div class="flex justify-between items-start">
                        <p class="font-label-md text-on-surface">{{ $msg->subject }}</p>
                        <span class="text-xs text-on-surface-variant">{{ $msg->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-on-surface-variant mt-xs line-clamp-2">{{ $msg->message }}</p>
                    @if($msg->admin_reply)
                    <div class="mt-xs p-sm bg-primary-container/20 rounded-lg text-sm text-on-surface">
                        <span class="font-bold text-xs text-primary">رد الإدارة: </span>{{ $msg->admin_reply }}
                    </div>
                    @endif
                    <div class="mt-xs">
                        @if($msg->admin_reply)
                        <span class="text-xs text-green-600 font-bold">✔ تم الرد</span>
                        @elseif($msg->is_read)
                        <span class="text-xs text-green-600 font-bold">✔ تمت القراءة</span>
                        @else
                        <span class="text-xs text-yellow-600 font-bold">⏳ قيد المراجعة</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-on-surface-variant font-body-md text-center py-lg">لا توجد رسائل سابقة.</p>
            @endif
        </section>
    </div>
    @endif

    @if($tab === 'license')
    @livewire('user-driver-license', key('user-driver-license'))
    @endif

    @if($tab === 'profile')
    <section class="bg-surface custom-shadow rounded-xl border border-outline-variant p-lg max-w-2xl">
        <h3 class="font-headline-md text-headline-md text-on-surface mb-md">الملف الشخصي</h3>
        <div class="flex items-center gap-lg mb-lg">
            <img class="w-20 h-20 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=00288e&color=fff&size=80" alt="{{ $user->name }}"/>
            <div>
                <h4 class="font-headline-md text-headline-md text-on-surface">{{ $user->name }}</h4>
                <p class="text-on-surface-variant">{{ $user->email }}</p>
                <p class="text-xs text-on-surface-variant">عضو منذ {{ $user->created_at->format('Y-m-d') }}</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
            <div>
                <label class="font-label-sm text-label-sm text-on-surface-variant">الاسم</label>
                <p class="font-label-md text-label-md text-on-surface">{{ $user->name }}</p>
            </div>
            <div>
                <label class="font-label-sm text-label-sm text-on-surface-variant">البريد الإلكتروني</label>
                <p class="font-label-md text-label-md text-on-surface">{{ $user->email }}</p>
            </div>
            <div>
                <label class="font-label-sm text-label-sm text-on-surface-variant">الدور</label>
                <p class="font-label-md text-label-md text-on-surface">{{ $user->roles->first()?->name === 'admin' ? 'مدير' : 'مستخدم' }}</p>
            </div>
            <div>
                <label class="font-label-sm text-label-sm text-on-surface-variant">تاريخ التسجيل</label>
                <p class="font-label-md text-label-md text-on-surface">{{ $user->created_at->format('Y-m-d') }}</p>
            </div>
        </div>
        <div class="mt-lg pt-lg border-t border-outline-variant">
            <a href="{{ route('profile') }}" class="text-secondary font-label-md hover:underline">تعديل الملف الشخصي →</a>
        </div>
    </section>
    @endif
</div>
