<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-md mb-xl">
        <div>
            <h2 class="font-headline-lg text-headline-lg text-on-surface">سجل النشاطات</h2>
            <p class="text-on-surface-variant font-body-md text-body-md mt-xs">تتبع جميع التعديلات والإجراءات في النظام</p>
        </div>
        <div class="flex items-center gap-md">
            <div class="bg-surface-container-high px-md py-sm rounded-xl text-center">
                <p class="font-label-sm text-label-sm text-on-surface-variant">سجل اليوم</p>
                <p class="font-headline-md text-headline-md text-primary">{{ $todayLogs }}</p>
            </div>
            <div class="bg-surface-container-high px-md py-sm rounded-xl text-center">
                <p class="font-label-sm text-label-sm text-on-surface-variant">إجمالي السجل</p>
                <p class="font-headline-md text-headline-md text-primary">{{ $totalLogs }}</p>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
    <div class="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 px-lg py-md rounded-xl mb-lg flex items-center gap-sm">
        <span class="material-symbols-outlined">check_circle</span>
        {{ session('message') }}
    </div>
    @endif

    <div class="bg-surface custom-shadow rounded-xl p-md mb-lg">
        <div class="flex flex-col lg:flex-row gap-md">
            <div class="flex-1">
                <div class="relative">
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="بحث في النشاطات..."
                        class="w-full pr-10 pl-4 py-2 rounded-lg border border-outline-variant bg-surface text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/40 font-body-md text-body-md"/>
                </div>
            </div>
            <select wire:model.live="actionFilter"
                class="rounded-lg border border-outline-variant bg-surface text-on-surface px-md py-2 focus:outline-none focus:ring-2 focus:ring-primary/40">
                <option value="">جميع الإجراءات</option>
                @foreach($filterOptions['actions'] as $action)
                <option value="{{ $action }}">{{ $action === 'created' ? 'إضافة' : ($action === 'updated' ? 'تعديل' : ($action === 'deleted' ? 'حذف' : $action)) }}</option>
                @endforeach
            </select>
            <select wire:model.live="subjectFilter"
                class="rounded-lg border border-outline-variant bg-surface text-on-surface px-md py-2 focus:outline-none focus:ring-2 focus:ring-primary/40">
                <option value="">جميع الكيانات</option>
                @foreach($filterOptions['subjects'] as $subject)
                <option value="{{ $subject }}">{{ class_basename($subject) }}</option>
                @endforeach
            </select>
            <div class="flex items-center gap-xs">
                <input wire:model.live="dateFrom" type="date"
                    class="rounded-lg border border-outline-variant bg-surface text-on-surface px-md py-2 focus:outline-none focus:ring-2 focus:ring-primary/40"/>
                <span class="text-on-surface-variant">-</span>
                <input wire:model.live="dateTo" type="date"
                    class="rounded-lg border border-outline-variant bg-surface text-on-surface px-md py-2 focus:outline-none focus:ring-2 focus:ring-primary/40"/>
            </div>
            @if($search || $actionFilter || $subjectFilter || $userIdFilter || $dateFrom || $dateTo)
            <button wire:click="clearFilters"
                class="px-md py-2 rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container-high transition-colors font-label-md text-label-md">
                مسح الفلترة
            </button>
            @endif
        </div>
    </div>

    <div class="bg-surface custom-shadow rounded-xl overflow-hidden">
        <table class="w-full text-right border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-outline-variant">
                    <th class="px-md py-sm font-label-sm text-label-sm text-on-surface-variant">الحدث</th>
                    <th class="px-md py-sm font-label-sm text-label-sm text-on-surface-variant">المستخدم</th>
                    <th class="px-md py-sm font-label-sm text-label-sm text-on-surface-variant">الإجراء</th>
                    <th class="px-md py-sm font-label-sm text-label-sm text-on-surface-variant">التفاصيل</th>
                    <th class="px-md py-sm font-label-sm text-label-sm text-on-surface-variant">التاريخ</th>
                    <th class="px-md py-sm font-label-sm text-label-sm text-on-surface-variant"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                @forelse($logs as $log)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors group">
                    <td class="px-md py-md">
                        <div class="flex items-center gap-sm">
                            <span class="material-symbols-outlined text-[20px] {{
                                $log->action === 'created' ? 'text-green-500' : ($log->action === 'updated' ? 'text-amber-500' : 'text-red-500')
                            }}">{{
                                $log->action === 'created' ? 'add_circle' : ($log->action === 'updated' ? 'edit' : 'delete')
                            }}</span>
                            <span class="font-label-md text-label-md text-on-surface">{{ class_basename($log->subject_type) }}</span>
                        </div>
                    </td>
                    <td class="px-md py-md">
                        <span class="font-label-md text-label-md text-on-surface">{{ $log->user->name ?? 'غير معروف' }}</span>
                    </td>
                    <td class="px-md py-md">
                        <span class="inline-flex items-center px-sm py-0.5 rounded-full text-label-sm font-label-sm {{
                            $log->action === 'created' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : ($log->action === 'updated' ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300')
                        }}">{{
                            $log->action === 'created' ? 'إضافة' : ($log->action === 'updated' ? 'تعديل' : 'حذف')
                        }}</span>
                    </td>
                    <td class="px-md py-md">
                        <p class="font-body-md text-body-md text-on-surface truncate max-w-xs">{{ $log->description }}</p>
                    </td>
                    <td class="px-md py-md">
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-on-surface-variant whitespace-nowrap" dir="ltr">{{ $log->created_at->format('Y-m-d') }}</span>
                            <span class="font-label-sm text-label-sm text-on-surface-variant/70 whitespace-nowrap" dir="ltr">{{ $log->created_at->format('h:i A') }}</span>
                        </div>
                    </td>
                    <td class="px-md py-md text-center">
                        <button wire:click="openDetails({{ $log->id }})"
                            class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors"
                            title="عرض التفاصيل">
                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-md py-xl text-center text-on-surface-variant">
                        <span class="material-symbols-outlined text-4xl block mb-sm">history</span>
                        <p>لا توجد نشاطات مسجلة.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-md py-sm bg-slate-50 dark:bg-slate-800/50 flex items-center justify-between">
            <p class="text-xs text-on-surface-variant">
                عرض {{ $logs->firstItem() ?? 0 }} إلى {{ $logs->lastItem() ?? 0 }} من {{ $logs->total() }} نشاط
            </p>
            <div class="flex items-center gap-xs">
                @if ($logs->onFirstPage())
                <button class="w-8 h-8 rounded border border-outline-variant dark:border-slate-600 flex items-center justify-center text-outline opacity-50 cursor-not-allowed" disabled>
                    <span class="material-symbols-outlined text-[18px] rtl-flip">chevron_right</span>
                </button>
                @else
                <button wire:click="previousPage"
                    class="w-8 h-8 rounded border border-outline-variant dark:border-slate-600 flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined text-[18px] rtl-flip">chevron_right</span>
                </button>
                @endif
                <span class="px-3 py-1 font-label-sm text-label-sm text-on-surface-variant">{{ $logs->currentPage() }}</span>
                @if ($logs->hasMorePages())
                <button wire:click="nextPage"
                    class="w-8 h-8 rounded border border-outline-variant dark:border-slate-600 flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined text-[18px] rtl-flip">chevron_left</span>
                </button>
                @else
                <button class="w-8 h-8 rounded border border-outline-variant dark:border-slate-600 flex items-center justify-center text-outline opacity-50 cursor-not-allowed" disabled>
                    <span class="material-symbols-outlined text-[18px] rtl-flip">chevron_left</span>
                </button>
                @endif
            </div>
        </div>
    </div>

    @if($showDetails && $selectedLog)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm" wire:click.self="closeDetails">
        <div class="bg-surface w-full max-w-lg rounded-2xl modal-shadow overflow-hidden" @click.stop>
            <header class="px-lg py-md border-b border-outline-variant flex items-center justify-between">
                <h3 class="font-headline-md text-headline-md text-on-surface">تفاصيل النشاط</h3>
                <button wire:click="closeDetails" class="p-xs rounded-full hover:bg-surface-container-high text-on-surface-variant transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </header>
            <div class="p-lg space-y-lg">
                <div class="grid grid-cols-2 gap-md">
                    <div>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">الإجراء</p>
                        <p class="font-body-md text-body-md text-on-surface mt-xs">
                            <span class="inline-flex items-center gap-xs px-sm py-0.5 rounded-full text-label-sm font-label-sm {{
                                $selectedLog->action === 'created' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : ($selectedLog->action === 'updated' ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300')
                            }}">{{
                                $selectedLog->action === 'created' ? 'إضافة' : ($selectedLog->action === 'updated' ? 'تعديل' : 'حذف')
                            }}</span>
                        </p>
                    </div>
                    <div>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">الكيان</p>
                        <p class="font-body-md text-body-md text-on-surface mt-xs">{{ class_basename($selectedLog->subject_type) }}</p>
                    </div>
                    <div>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">المستخدم</p>
                        <p class="font-body-md text-body-md text-on-surface mt-xs">{{ $selectedLog->user->name ?? 'غير معروف' }}</p>
                    </div>
                    <div>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">البريد الإلكتروني</p>
                        <p class="font-body-md text-body-md text-on-surface mt-xs" dir="ltr">{{ $selectedLog->user->email ?? '—' }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="font-label-sm text-label-sm text-on-surface-variant">الوصف</p>
                        <p class="font-body-md text-body-md text-on-surface mt-xs">{{ $selectedLog->description }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="font-label-sm text-label-sm text-on-surface-variant">الوقت</p>
                        <p class="font-body-md text-body-md text-on-surface mt-xs" dir="ltr">{{ $selectedLog->created_at->format('Y-m-d h:i A') }}</p>
                    </div>
                    @if($selectedLog->subject_label)
                    <div class="col-span-2">
                        <p class="font-label-sm text-label-sm text-on-surface-variant">العنوان</p>
                        <p class="font-body-md text-body-md text-on-surface mt-xs">{{ $selectedLog->subject_label }}</p>
                    </div>
                    @endif
                    @if($selectedLog->ip_address)
                    <div>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">عنوان IP</p>
                        <p class="font-body-md text-body-md text-on-surface mt-xs" dir="ltr">{{ $selectedLog->ip_address }}</p>
                    </div>
                    @endif
                    @if($selectedLog->properties)
                    <div class="col-span-2">
                        <p class="font-label-sm text-label-sm text-on-surface-variant">بيانات إضافية</p>
                        <pre class="mt-xs p-md bg-surface-container-high rounded-lg text-label-sm text-on-surface font-mono overflow-x-auto max-h-40" dir="ltr">{{ json_encode($selectedLog->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                    @endif
                </div>
            </div>
            <footer class="px-lg py-md border-t border-outline-variant flex justify-end">
                <button wire:click="closeDetails" class="px-lg py-sm rounded-lg border border-outline-variant text-on-surface hover:bg-surface-container-high transition-colors font-label-md text-label-md">
                    إغلاق
                </button>
            </footer>
        </div>
    </div>
    @endif
</div>
