<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-md mb-lg">
        <div class="flex items-center gap-sm">
            <span class="status-badge status-badge-pending">{{ $pendingCount }} قيد الانتظار</span>
            <span class="status-badge status-badge-confirmed">{{ $verifiedCount }} موثقة</span>
            <span class="status-badge status-badge-cancelled">{{ $rejectedCount }} مرفوضة</span>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-md mb-lg">
        <div class="flex-1 relative">
            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="بحث بالاسم أو رقم الرخصة..."
                class="w-full pr-10 pl-4 py-sm rounded-xl border border-outline-variant bg-surface text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary font-body-md">
        </div>
        <select wire:model.live="statusFilter"
            class="px-md py-sm rounded-xl border border-outline-variant bg-surface text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary font-body-md">
            <option value="">جميع الحالات</option>
            <option value="pending">قيد الانتظار</option>
            <option value="verified">موثقة</option>
            <option value="rejected">مرفوضة</option>
        </select>
    </div>

    <div class="space-y-md">
        @forelse($licenses as $license)
            <div wire:click="viewLicense({{ $license->id }})" class="cursor-pointer bg-surface rounded-xl border border-outline-variant p-lg card-shadow hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-md">
                        <div class="w-12 h-12 rounded-full bg-surface-container-high flex items-center justify-center">
                            <span class="material-symbols-outlined text-secondary">badge</span>
                        </div>
                        <div>
                            <p class="font-label-md text-on-surface font-bold">{{ $license->full_name ?: '—' }}</p>
                            <p class="font-body-sm text-on-surface-variant">رقم {{ $license->license_number ?: '—' }}</p>
                        </div>
                    </div>
                    <div class="text-left">
                        @if($license->status === 'verified')
                            <span class="status-badge status-badge-confirmed">موثقة</span>
                        @elseif($license->status === 'rejected')
                            <span class="status-badge status-badge-cancelled">مرفوضة</span>
                        @else
                            <span class="status-badge status-badge-pending">قيد الانتظار</span>
                        @endif
                        <p class="font-body-sm text-on-surface-variant mt-xs">{{ $license->user?->name }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-xl">
                <span class="material-symbols-outlined text-[48px] text-outline">badge</span>
                <p class="font-body-md text-on-surface-variant mt-md">لا توجد رخص قيادة.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-lg" dir="ltr">
        {{ $licenses->links() }}
    </div>

    @if($showModal && $selectedLicense)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-md" wire:click.self="closeModal">
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="relative bg-surface rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto modal-shadow p-xl">
                <div class="flex justify-between items-start mb-lg">
                    <h3 class="font-headline-md text-headline-md text-on-surface">تفاصيل الرخصة</h3>
                    <button wire:click="closeModal" class="p-xs text-on-surface-variant hover:text-on-surface">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="space-y-md">
                    @if($selectedLicense->license_image)
                        <div class="rounded-xl overflow-hidden border border-outline-variant">
                            <img src="{{ Storage::url($selectedLicense->license_image) }}" alt="صورة الرخصة" class="w-full h-auto max-h-64 object-contain bg-surface-container-low">
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-md">
                        <div>
                            <p class="font-label-sm text-on-surface-variant">الاسم الكامل</p>
                            <p class="font-label-md text-on-surface">{{ $selectedLicense->full_name ?: '—' }}</p>
                        </div>
                        <div>
                            <p class="font-label-sm text-on-surface-variant">رقم الرخصة</p>
                            <p class="font-label-md text-on-surface">{{ $selectedLicense->license_number ?: '—' }}</p>
                        </div>
                        <div>
                            <p class="font-label-sm text-on-surface-variant">تاريخ الميلاد</p>
                            <p class="font-label-md text-on-surface">{{ $selectedLicense->date_of_birth?->format('Y-m-d') ?: '—' }}</p>
                        </div>
                        <div>
                            <p class="font-label-sm text-on-surface-variant">تاريخ الإصدار</p>
                            <p class="font-label-md text-on-surface">{{ $selectedLicense->issue_date?->format('Y-m-d') ?: '—' }}</p>
                        </div>
                        <div>
                            <p class="font-label-sm text-on-surface-variant">تاريخ الانتهاء</p>
                            <p class="font-label-md text-on-surface">{{ $selectedLicense->expiration_date?->format('Y-m-d') ?: '—' }}</p>
                        </div>
                        <div>
                            <p class="font-label-sm text-on-surface-variant">الحالة</p>
                            @if($selectedLicense->status === 'verified')
                                <span class="status-badge status-badge-confirmed">موثقة</span>
                            @elseif($selectedLicense->status === 'rejected')
                                <span class="status-badge status-badge-cancelled">مرفوضة</span>
                            @else
                                <span class="status-badge status-badge-pending">قيد الانتظار</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <p class="font-label-sm text-on-surface-variant">العنوان</p>
                        <p class="font-label-md text-on-surface">{{ $selectedLicense->address ?: '—' }}</p>
                    </div>

                    <div>
                        <p class="font-label-sm text-on-surface-variant">المستخدم</p>
                        <p class="font-label-md text-on-surface">{{ $selectedLicense->user?->name }} ({{ $selectedLicense->user?->email }})</p>
                    </div>

                    @if($selectedLicense->extracted_data)
                        <div>
                            <p class="font-label-sm text-on-surface-variant mb-sm">البيانات المستخرجة</p>
                            <pre class="font-body-sm bg-surface-container-low p-md rounded-xl border border-outline-variant overflow-x-auto">{{ json_encode($selectedLicense->extracted_data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    @endif

                    <div class="flex items-center gap-md pt-md border-t border-outline-variant">
                        @if($selectedLicense->status !== 'verified')
                            <button wire:click="verify({{ $selectedLicense->id }})"
                                class="flex items-center gap-xs px-lg py-sm bg-green-600 text-white rounded-xl font-bold font-label-md hover:bg-green-700 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">check_circle</span> توثيق
                            </button>
                        @endif
                        @if($selectedLicense->status !== 'rejected')
                            <button wire:click="reject({{ $selectedLicense->id }})"
                                class="flex items-center gap-xs px-lg py-sm bg-red-600 text-white rounded-xl font-bold font-label-md hover:bg-red-700 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">cancel</span> رفض
                            </button>
                        @endif
                        @if($selectedLicense->status !== 'pending')
                            <button wire:click="resetStatus({{ $selectedLicense->id }})"
                                class="flex items-center gap-xs px-lg py-sm bg-surface-container-high text-on-surface rounded-xl font-bold font-label-md hover:bg-surface-container-highest transition-colors">
                                <span class="material-symbols-outlined text-[18px]">refresh</span> إعادة تعيين
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
