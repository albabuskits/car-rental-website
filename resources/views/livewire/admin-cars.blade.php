<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-md mb-xl">
        <div>
            <h2 class="font-headline-lg text-headline-lg text-on-surface">إدارة الأسطول</h2>
            <p class="text-on-surface-variant font-body-md text-body-md mt-xs">الإشراف على أسطولك النشط والمخزون في جميع المناطق.</p>
        </div>
        <button wire:click="openCreateModal" class="bg-primary text-on-primary font-label-md text-label-md px-lg py-sm rounded-lg flex items-center gap-xs hover:opacity-90 active:scale-95 transition-all shadow-md">
            <span class="material-symbols-outlined">add</span>إضافة سيارة جديدة
        </button>
    </div>

    @if (session()->has('message'))
    <div class="bg-green-100 text-green-700 px-md py-sm rounded-lg font-label-md mb-lg flex items-center gap-sm">
        <span class="material-symbols-outlined">check_circle</span>
        {{ session('message') }}
    </div>
    @endif

    <div class="bg-surface custom-shadow rounded-xl p-md mb-lg flex flex-col md:flex-row gap-md items-center justify-between">
        <div class="relative w-full md:w-96">
            <span class="material-symbols-outlined absolute right-sm top-1/2 -translate-y-1/2 text-outline">search</span>
            <input wire:model.live.debounce.300ms="search" class="w-full pr-10 pl-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary transition-all outline-none text-body-md" placeholder="ابحث عن طراز أو علامة تجارية..." type="text"/>
        </div>
        <div class="flex gap-sm overflow-x-auto w-full md:w-auto pb-xs md:pb-0">
            <button wire:click="$set('statusFilter', '')" class="px-sm py-xs rounded-full font-label-md text-label-md whitespace-nowrap {{ empty($statusFilter) ? 'bg-primary-container text-on-primary-container' : 'bg-surface-container-low text-on-surface-variant border border-outline-variant hover:bg-surface-container-high' }}">
                جميع السيارات ({{ $totalCars }})
            </button>
            <button wire:click="$set('statusFilter', 'available')" class="px-sm py-xs rounded-full font-label-md text-label-md whitespace-nowrap {{ $statusFilter === 'available' ? 'bg-primary-container text-on-primary-container' : 'bg-surface-container-low text-on-surface-variant border border-outline-variant hover:bg-surface-container-high' }}">
                متاحة ({{ $availableCount }})
            </button>
            <button wire:click="$set('statusFilter', 'rented')" class="px-sm py-xs rounded-full font-label-md text-label-md whitespace-nowrap {{ $statusFilter === 'rented' ? 'bg-primary-container text-on-primary-container' : 'bg-surface-container-low text-on-surface-variant border border-outline-variant hover:bg-surface-container-high' }}">
                مستأجرة ({{ $rentedCount }})
            </button>
            <button wire:click="$set('statusFilter', 'maintenance')" class="px-sm py-xs rounded-full font-label-md text-label-md whitespace-nowrap {{ $statusFilter === 'maintenance' ? 'bg-primary-container text-on-primary-container' : 'bg-surface-container-low text-on-surface-variant border border-outline-variant hover:bg-surface-container-high' }}">
                صيانة ({{ $maintenanceCount }})
            </button>
        </div>
    </div>

    <div class="bg-surface custom-shadow rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-outline-variant">
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">معرف السيارة</th>
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">تفاصيل السيارة</th>
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">الحالة</th>
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">السعر / اليوم</th>
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant text-left">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($cars as $car)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-md py-md font-label-sm text-label-sm text-outline">#VH-{{ $car->id }}</td>
                        <td class="px-md py-md">
                            <div class="flex items-center gap-sm">
                                <div class="w-16 h-10 rounded bg-slate-100 overflow-hidden flex-shrink-0 flex items-center justify-center text-on-surface-variant">
                                    @php $firstImage = $car->images->first(); @endphp
                                    @if($firstImage)
                                    <img src="{{ asset('storage/' . $firstImage->image_path) }}" alt="{{ $car->brand }} {{ $car->model }}" class="w-full h-full object-cover"/>
                                    @elseif($car->image)
                                    <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->brand }} {{ $car->model }}" class="w-full h-full object-cover"/>
                                    @else
                                    <span class="material-symbols-outlined">directions_car</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-label-md text-label-md text-on-surface">{{ $car->brand }} {{ $car->model }}</p>
                                    <p class="text-xs text-on-surface-variant">{{ $car->category }} • {{ $car->fuel_type }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-md py-md">
                            @php
                                $carStatusMap = [
                                    'available' => ['class' => 'status-badge-available', 'label' => 'متاحة'],
                                    'rented' => ['class' => 'status-badge-rented', 'label' => 'مستأجرة'],
                                    'maintenance' => ['class' => 'status-badge-maintenance', 'label' => 'قيد الخدمة'],
                                ];
                                $cs = $carStatusMap[$car->status] ?? ['class' => 'status-badge-completed', 'label' => $car->status];
                            @endphp
                            <span class="status-badge {{ $cs['class'] }}">{{ $cs['label'] }}</span>
                        </td>
                        <td class="px-md py-md font-label-md text-label-md text-on-surface">${{ number_format($car->price_per_day, 2) }}</td>
                        <td class="px-md py-md text-left">
                            <button wire:click="openEditModal({{ $car->id }})" class="p-xs hover:bg-surface-container-high rounded transition-colors text-on-surface-variant">
                                <span class="material-symbols-outlined">edit</span>
                            </button>
                            <button wire:click="confirmDelete({{ $car->id }})" class="p-xs hover:bg-surface-container-high rounded transition-colors text-error">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-md py-xl text-center text-on-surface-variant font-body-md">لا توجد سيارات متطابقة.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-md py-sm bg-slate-50 flex items-center justify-between">
            <p class="text-xs text-on-surface-variant">عرض {{ $cars->firstItem() ?? 0 }} إلى {{ $cars->lastItem() ?? 0 }} من {{ $cars->total() }} سيارة</p>
            <div class="flex items-center gap-xs">
                @if ($cars->onFirstPage())
                <button class="w-8 h-8 rounded border border-outline-variant flex items-center justify-center text-outline opacity-50" disabled>
                    <span class="material-symbols-outlined text-[18px] rtl-flip">chevron_right</span>
                </button>
                @else
                <button wire:click="previousPage" class="w-8 h-8 rounded border border-outline-variant flex items-center justify-center text-outline hover:bg-white">
                    <span class="material-symbols-outlined text-[18px] rtl-flip">chevron_right</span>
                </button>
                @endif
                <span class="px-3 py-1 font-label-sm text-label-sm text-on-surface-variant">{{ $cars->currentPage() }}</span>
                @if ($cars->hasMorePages())
                <button wire:click="nextPage" class="w-8 h-8 rounded border border-outline-variant flex items-center justify-center text-outline hover:bg-white">
                    <span class="material-symbols-outlined text-[18px] rtl-flip">chevron_left</span>
                </button>
                @else
                <button class="w-8 h-8 rounded border border-outline-variant flex items-center justify-center text-outline opacity-50" disabled>
                    <span class="material-symbols-outlined text-[18px] rtl-flip">chevron_left</span>
                </button>
                @endif
            </div>
        </div>
    </div>

    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm transition-opacity duration-300" wire:click.self="closeModal">
        <div class="bg-surface w-full max-w-2xl rounded-2xl modal-shadow overflow-hidden transform transition-all duration-300 scale-100 opacity-100" @click.stop>
            <header class="px-lg py-md border-b border-outline-variant flex items-center justify-between">
                <h3 class="font-headline-md text-headline-md text-on-surface">{{ $editingCar ? 'تعديل السيارة' : 'إضافة سيارة جديدة' }}</h3>
                <button wire:click="closeModal" class="p-xs rounded-full hover:bg-surface-container-high text-on-surface-variant transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </header>
            <form wire:submit="save" class="p-lg space-y-md overflow-y-auto max-h-[716px]">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface">العلامة التجارية</label>
                        <input wire:model="brand" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" placeholder="مثال: مرسيدس-بنز" type="text"/>
                        @error('brand') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface">اسم الموديل</label>
                        <input wire:model="model" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" placeholder="مثال: S-Class" type="text"/>
                        @error('model') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface">الفئة</label>
                        <select wire:model="category" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none bg-white">
                            <option value="economy">اقتصادية</option>
                            <option value="luxury">فاخرة</option>
                            <option value="suv">دفع رباعي</option>
                            <option value="sports">رياضية</option>
                            <option value="sedan">سيدان</option>
                        </select>
                    </div>
                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface">نوع الوقود</label>
                        <select wire:model="fuel_type" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none bg-white">
                            <option value="gasoline">بنزين</option>
                            <option value="diesel">ديزل</option>
                            <option value="electric">كهربائي</option>
                            <option value="hybrid">هايبرد</option>
                        </select>
                    </div>
                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface">السعر (يومي)</label>
                        <div class="relative">
                            <span class="absolute right-sm top-1/2 -translate-y-1/2 text-outline">$</span>
                            <input wire:model="price_per_day" class="w-full pr-8 pl-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" placeholder="0.00" type="number" step="0.01"/>
                        </div>
                        @error('price_per_day') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface">سنة الصنع</label>
                        <input wire:model="year" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" placeholder="مثال: 2024" type="text"/>
                    </div>
                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface">ناقل الحركة</label>
                        <select wire:model="transmission" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none bg-white">
                            <option value="automatic">أوتوماتيك</option>
                            <option value="manual">يدوي</option>
                        </select>
                    </div>
                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface">عدد المقاعد</label>
                        <input wire:model="seats" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="number" min="1" max="15"/>
                    </div>
                </div>
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">الوصف</label>
                    <textarea wire:model="description" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" rows="3" placeholder="وصف السيارة..."></textarea>
                </div>
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">صور السيارة (يمكنك اختيار عدة صور)</label>
                    <input wire:model="newImages" type="file" accept="image/*" multiple class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none file:bg-surface-container-high file:border-0 file:px-sm file:py-xs file:rounded file:font-label-md file:text-label-md file:text-on-surface hover:file:bg-surface-container-higher cursor-pointer"/>
                    @error('newImages.*') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                    @error('newImages') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                    @if(!empty($existingImages))
                    <div class="mt-xs grid grid-cols-4 gap-sm">
                        @foreach($existingImages as $img)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $img['image_path']) }}" class="w-full h-20 object-cover rounded border border-outline-variant"/>
                            @if($img['is_primary'])<span class="absolute top-0 right-0 bg-secondary text-white text-[10px] px-1 rounded-bl rounded-tr">أساسية</span>@endif
                            <button type="button" wire:click="removeExistingImage({{ $img['id'] }})" class="absolute top-0 left-0 bg-error/80 text-white rounded-full w-5 h-5 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-xs" title="حذف">×</button>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    @if(!empty($newImages))
                    <div class="mt-xs grid grid-cols-4 gap-sm">
                        @foreach($newImages as $index => $img)
                        <div class="relative group">
                            <img src="{{ $img->temporaryUrl() }}" class="w-full h-20 object-cover rounded border border-outline-variant"/>
                            <button type="button" wire:click="removeNewImage({{ $index }})" class="absolute top-0 left-0 bg-error/80 text-white rounded-full w-5 h-5 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-xs" title="إزالة">×</button>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="flex items-center gap-xs">
                    <input wire:model="ac" type="checkbox" id="ac" class="rounded border-outline-variant text-secondary focus:ring-secondary"/>
                    <label for="ac" class="font-label-md text-on-surface">تكييف</label>
                </div>
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">الحالة</label>
                    <select wire:model="status" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none bg-white">
                        <option value="available">متاحة</option>
                        <option value="rented">مستأجرة</option>
                        <option value="maintenance">صيانة</option>
                    </select>
                </div>
                <footer class="flex justify-end gap-md pt-md border-t border-outline-variant">
                    <button type="button" wire:click="closeModal" class="px-lg py-sm font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors">إلغاء</button>
                    <button type="submit" class="bg-primary text-on-primary px-xl py-sm rounded-lg font-label-md text-label-md hover:opacity-90 active:scale-95 transition-all">{{ $editingCar ? 'تحديث السيارة' : 'حفظ السيارة' }}</button>
                </footer>
            </form>
        </div>
    </div>
    @endif

    @if($confirmingDelete)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm" wire:click.self="cancelDelete">
        <div class="bg-surface w-full max-w-md rounded-2xl modal-shadow p-lg" @click.stop>
            <div class="text-center">
                <span class="material-symbols-outlined text-5xl text-error">warning</span>
                <h3 class="font-headline-md text-headline-md text-on-surface mt-md">تأكيد الحذف</h3>
                <p class="font-body-md text-on-surface-variant mt-xs">هل أنت متأكد من حذف هذه السيارة؟ لا يمكن التراجع عن هذا الإجراء.</p>
            </div>
            <div class="flex justify-center gap-md mt-lg">
                <button wire:click="cancelDelete" class="px-lg py-sm border border-outline-variant rounded-lg font-label-md text-on-surface hover:bg-surface-container-low transition-colors">إلغاء</button>
                <button wire:click="delete({{ $confirmingDelete }})" class="px-lg py-sm bg-error text-on-error rounded-lg font-label-md hover:opacity-90 transition-all">حذف</button>
            </div>
        </div>
    </div>
    @endif
</div>