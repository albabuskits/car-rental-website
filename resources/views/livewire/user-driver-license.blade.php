<div>
    @if (session()->has('message'))
    <div class="bg-green-100 text-green-700 px-md py-sm rounded-lg font-label-md mb-lg flex items-center gap-sm">
        <span class="material-symbols-outlined">check_circle</span>
        {{ session('message') }}
    </div>
    @endif

    <div class="bg-surface custom-shadow rounded-xl border border-outline-variant p-lg">
        <div class="flex items-center justify-between mb-lg">
            <div>
                <h3 class="font-headline-md text-headline-md text-on-surface">رخصة القيادة</h3>
                <p class="text-on-surface-variant font-body-md">أضف بيانات رخصة القيادة للتحقق من هويتك</p>
            </div>
            @if($license && !$editing)
            <div class="flex items-center gap-sm">
                <span class="status-badge {{ $license->is_verified ? 'status-badge-confirmed' : ($license->status === 'rejected' ? 'status-badge-cancelled' : 'status-badge-pending') }}">
                    {{ $license->is_verified ? 'موثقة' : ($license->status === 'rejected' ? 'مرفوضة' : 'قيد المراجعة') }}
                </span>
                <button wire:click="startEdit" class="text-secondary font-label-sm hover:underline">تعديل</button>
            </div>
            @endif
        </div>

        @if(!$license || $editing)
        <form wire:submit="saveLicense" class="space-y-md">
            <div class="space-y-xs">
                <label class="font-label-md text-label-md text-on-surface">صورة الرخصة (وجه)</label>
                <div class="flex items-center gap-md">
                    <div class="flex-1">
                        <input wire:model="licenseImage" type="file" accept="image/*" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none file:bg-surface-container-high file:border-0 file:px-sm file:py-xs file:rounded file:font-label-md file:text-label-md file:text-on-surface hover:file:bg-surface-container-higher cursor-pointer"/>
                        @error('licenseImage') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                    </div>
                    @if($licenseImage && !$errors->has('licenseImage'))
                    <button type="button" wire:click="scanLicense" class="bg-secondary text-on-secondary px-lg py-xs rounded-lg font-label-md text-label-md hover:opacity-90 transition-all flex items-center gap-xs">
                        <span class="material-symbols-outlined text-[18px]">document_scanner</span> مسح ضوئي
                    </button>
                    @endif
                </div>
                @if($licenseImage && !$errors->has('licenseImage'))
                <div class="mt-xs">
                    <img src="{{ $licenseImage->temporaryUrl() }}" class="w-48 h-32 object-cover rounded-lg border border-outline-variant"/>
                </div>
                @endif
                @if($license && $license->license_image && !$licenseImage)
                <div class="mt-xs">
                    <img src="{{ asset('storage/' . $license->license_image) }}" class="w-48 h-32 object-cover rounded-lg border border-outline-variant"/>
                </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">الاسم الكامل</label>
                    <input wire:model="full_name" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="text"/>
                    @error('full_name') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">رقم الرخصة</label>
                    <input wire:model="license_number" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="text"/>
                    @error('license_number') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">تاريخ الميلاد</label>
                    <input wire:model="date_of_birth" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="date"/>
                </div>
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">تاريخ الإصدار</label>
                    <input wire:model="issue_date" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="date"/>
                </div>
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">تاريخ الانتهاء</label>
                    <input wire:model="expiration_date" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="date"/>
                    @error('expiration_date') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">العنوان</label>
                    <input wire:model="address" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="text"/>
                </div>
            </div>

            <div class="flex justify-end gap-md pt-md border-t border-outline-variant">
                @if($license)
                <button type="button" wire:click="cancelEdit" class="px-lg py-sm font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors">إلغاء</button>
                @endif
                <button type="submit" class="bg-primary text-on-primary px-xl py-sm rounded-lg font-label-md text-label-md hover:opacity-90 active:scale-95 transition-all">حفظ</button>
            </div>
        </form>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
            @if($license->license_image)
            <div class="md:col-span-2 mb-md">
                <img src="{{ asset('storage/' . $license->license_image) }}" class="w-48 h-32 object-cover rounded-lg border border-outline-variant"/>
            </div>
            @endif
            <div>
                <label class="font-label-sm text-label-sm text-on-surface-variant">الاسم الكامل</label>
                <p class="font-label-md text-label-md text-on-surface">{{ $license->full_name ?? '—' }}</p>
            </div>
            <div>
                <label class="font-label-sm text-label-sm text-on-surface-variant">رقم الرخصة</label>
                <p class="font-label-md text-label-md text-on-surface">{{ $license->license_number ?? '—' }}</p>
            </div>
            <div>
                <label class="font-label-sm text-label-sm text-on-surface-variant">تاريخ الميلاد</label>
                <p class="font-body-md text-body-md text-on-surface">{{ $license->date_of_birth?->format('Y-m-d') ?? '—' }}</p>
            </div>
            <div>
                <label class="font-label-sm text-label-sm text-on-surface-variant">تاريخ الإصدار</label>
                <p class="font-body-md text-body-md text-on-surface">{{ $license->issue_date?->format('Y-m-d') ?? '—' }}</p>
            </div>
            <div>
                <label class="font-label-sm text-label-sm text-on-surface-variant">تاريخ الانتهاء</label>
                <p class="font-body-md text-body-md text-on-surface {{ $license->expiration_date?->isPast() ? 'text-error font-bold' : '' }}">{{ $license->expiration_date?->format('Y-m-d') ?? '—' }}</p>
            </div>
            <div>
                <label class="font-label-sm text-label-sm text-on-surface-variant">العنوان</label>
                <p class="font-body-md text-body-md text-on-surface">{{ $license->address ?? '—' }}</p>
            </div>
        </div>
        @endif
    </div>
</div>
