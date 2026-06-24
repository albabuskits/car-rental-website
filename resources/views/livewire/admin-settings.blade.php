<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-md mb-xl">
        <div>
            <h2 class="font-headline-lg text-headline-lg text-on-surface">الإعدادات</h2>
            <p class="text-on-surface-variant font-body-md text-body-md mt-xs">إعدادات الموقع والتطبيق.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-md mt-md">
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">نسبة الضريبة (%)</label>
                    <input wire:model="tax_rate" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="number" step="0.01" min="0" max="100"/>
                    @error('tax_rate') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">الإلغاء (ساعات)</label>
                    <input wire:model="booking_cancellation_hours" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="number" min="0"/>
                    @error('booking_cancellation_hours') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                </div>
            </div>

    @if (session()->has('message'))
    <div class="flash-message flash-message-success">
        <span class="material-symbols-outlined text-[18px]">check_circle</span>
        {{ session('message') }}
    </div>
    @endif

    <form wire:submit="save" class="space-y-lg">
        <div class="bg-surface custom-shadow rounded-xl p-lg">
            <h3 class="font-headline-md text-headline-md text-on-surface mb-md">معلومات الموقع</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">اسم الموقع</label>
                    <input wire:model="site_name" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="text"/>
                    @error('site_name') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">بريد الاتصال</label>
                    <input wire:model="contact_email" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="email"/>
                    @error('contact_email') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">رقم الهاتف</label>
                    <input wire:model="contact_phone" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="text"/>
                    @error('contact_phone') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">العنوان</label>
                    <input wire:model="address" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="text"/>
                </div>
            </div>
            <div class="mt-md space-y-xs">
                <label class="font-label-md text-label-md text-on-surface">نبذة عن الموقع</label>
                <textarea wire:model="about_text" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" rows="4"></textarea>
            </div>
        </div>

        <div class="bg-surface custom-shadow rounded-xl p-lg">
            <h3 class="font-headline-md text-headline-md text-on-surface mb-md">روابط التواصل الاجتماعي</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">فيسبوك</label>
                    <input wire:model="facebook_url" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="url" placeholder="https://facebook.com/..."/>
                    @error('facebook_url') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">تويتر</label>
                    <input wire:model="twitter_url" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="url" placeholder="https://twitter.com/..."/>
                    @error('twitter_url') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">انستغرام</label>
                    <input wire:model="instagram_url" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="url" placeholder="https://instagram.com/..."/>
                    @error('instagram_url') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="bg-surface custom-shadow rounded-xl p-lg">
            <h3 class="font-headline-md text-headline-md text-on-surface mb-md">إعدادات الحجوزات</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">العملة</label>
                    <select wire:model="currency" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none bg-white">
                        <option value="USD">USD - دولار أمريكي</option>
                        <option value="SAR">SAR - ريال سعودي</option>
                        <option value="AED">AED - درهم إماراتي</option>
                        <option value="QAR">QAR - ريال قطري</option>
                        <option value="EUR">EUR - يورو</option>
                    </select>
                </div>
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">تفعيل الضريبة</label>
                    <button wire:click="toggleTax" type="button" class="flex items-center gap-3 mt-1">
                        <div class="w-11 h-6 rounded-full transition-colors relative {{ $tax_enabled ? 'bg-secondary' : 'bg-gray-300' }}">
                            <div class="w-5 h-5 bg-white rounded-full shadow absolute top-[2px] transition-all {{ $tax_enabled ? 'left-[22px]' : 'left-[2px]' }}"></div>
                        </div>
                        <span class="text-sm font-label-md text-label-md text-on-surface-variant">{{ $tax_enabled ? 'مفعل' : 'معطل' }}</span>
                    </button>
                    @error('tax_enabled') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">مبلغ الضريبة الثابت ($)</label>
                    <input wire:model="tax_amount" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="number" step="0.01" min="0"/>
                    @error('tax_amount') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-primary text-on-primary px-xl py-sm rounded-lg font-label-md text-label-md hover:opacity-90 active:scale-95 transition-all shadow-md">حفظ الإعدادات</button>
        </div>
    </form>
</div>
