<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-md mb-xl">
        <div>
            <h2 class="font-headline-lg text-headline-lg text-on-surface">الرسائل</h2>
            <p class="text-on-surface-variant font-body-md text-body-md mt-xs">إدارة رسائل الاتصال والاستفسارات.</p>
        </div>
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
            <input wire:model.live.debounce.300ms="search" class="w-full pr-10 pl-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary transition-all outline-none text-body-md" placeholder="ابحث عن اسم أو بريد..." type="text"/>
        </div>
        <div class="flex gap-sm overflow-x-auto w-full md:w-auto pb-xs md:pb-0">
            <button wire:click="$set('filter', '')" class="px-sm py-xs rounded-full font-label-md text-label-md whitespace-nowrap {{ empty($filter) ? 'bg-primary-container text-on-primary-container' : 'bg-surface-container-low text-on-surface-variant border border-outline-variant hover:bg-surface-container-high' }}">
                الكل
            </button>
            <button wire:click="$set('filter', 'unread')" class="px-sm py-xs rounded-full font-label-md text-label-md whitespace-nowrap {{ $filter === 'unread' ? 'bg-primary-container text-on-primary-container' : 'bg-surface-container-low text-on-surface-variant border border-outline-variant hover:bg-surface-container-high' }}">
                غير مقروءة ({{ $unreadCount }})
            </button>
            <button wire:click="$set('filter', 'read')" class="px-sm py-xs rounded-full font-label-md text-label-md whitespace-nowrap {{ $filter === 'read' ? 'bg-primary-container text-on-primary-container' : 'bg-surface-container-low text-on-surface-variant border border-outline-variant hover:bg-surface-container-high' }}">
                مقروءة
            </button>
        </div>
    </div>

    <div class="bg-surface custom-shadow rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-outline-variant">
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">المرسل</th>
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">الموضوع</th>
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">التاريخ</th>
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">الحالة</th>
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">الرد</th>
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant text-left">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($messages as $message)
                    <tr class="hover:bg-slate-50 transition-colors group {{ !$message->is_read ? 'bg-blue-50/40' : '' }}">
                        <td class="px-md py-md">
                            <div>
                                <p class="font-label-md text-label-md text-on-surface {{ !$message->is_read ? 'font-bold' : '' }}">{{ $message->name }}</p>
                                <p class="text-xs text-on-surface-variant">{{ $message->email }}</p>
                            </div>
                        </td>
                        <td class="px-md py-md font-body-md text-body-md text-on-surface">{{ $message->subject }}</td>
                        <td class="px-md py-md font-label-sm text-label-sm text-on-surface-variant">{{ $message->created_at->diffForHumans() }}</td>
                        <td class="px-md py-md">
                            @if($message->is_read)
                            <span class="inline-flex items-center gap-xs px-xs py-[2px] rounded bg-surface-container-low text-on-surface-variant text-[10px] font-bold">
                                <span class="material-symbols-outlined text-[12px]">drafts</span>مقروءة
                            </span>
                            @else
                            <span class="inline-flex items-center gap-xs px-xs py-[2px] rounded bg-primary-container text-on-primary-container text-[10px] font-bold">
                                <span class="material-symbols-outlined text-[12px]">mark_email_unread</span>جديد
                            </span>
                            @endif
                        </td>
                        <td class="px-md py-md">
                            @if($message->admin_reply)
                            <span class="inline-flex items-center gap-xs px-xs py-[2px] rounded bg-secondary-fixed text-on-secondary-fixed text-[10px] font-bold">
                                <span class="material-symbols-outlined text-[12px]">reply</span>تم الرد
                            </span>
                            @else
                            <span class="text-on-surface-variant text-[10px]">—</span>
                            @endif
                        </td>
                        <td class="px-md py-md text-left">
                            <button wire:click="viewMessage({{ $message->id }})" class="p-xs hover:bg-surface-container-high rounded transition-colors text-secondary">
                                <span class="material-symbols-outlined">visibility</span>
                            </button>
                            @if(!$message->is_read)
                            <button wire:click="markAsRead({{ $message->id }})" class="p-xs hover:bg-surface-container-high rounded transition-colors text-on-surface-variant" title="تحديد كمقروءة">
                                <span class="material-symbols-outlined">mark_email_read</span>
                            </button>
                            @else
                            <button wire:click="markAsUnread({{ $message->id }})" class="p-xs hover:bg-surface-container-high rounded transition-colors text-on-surface-variant" title="تحديد كغير مقروءة">
                                <span class="material-symbols-outlined">mark_email_unread</span>
                            </button>
                            @endif
                            <button wire:click="delete({{ $message->id }})" class="p-xs hover:bg-surface-container-high rounded transition-colors text-error" onclick="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-md py-xl text-center text-on-surface-variant font-body-md">لا توجد رسائل.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-md py-sm bg-slate-50 flex items-center justify-between">
            <p class="text-xs text-on-surface-variant">عرض {{ $messages->firstItem() ?? 0 }} إلى {{ $messages->lastItem() ?? 0 }} من {{ $messages->total() }} رسالة</p>
            <div class="flex items-center gap-xs">
                @if ($messages->onFirstPage())
                <button class="w-8 h-8 rounded border border-outline-variant flex items-center justify-center text-outline opacity-50" disabled>
                    <span class="material-symbols-outlined text-[18px] rtl-flip">chevron_right</span>
                </button>
                @else
                <button wire:click="previousPage" class="w-8 h-8 rounded border border-outline-variant flex items-center justify-center text-outline hover:bg-white">
                    <span class="material-symbols-outlined text-[18px] rtl-flip">chevron_right</span>
                </button>
                @endif
                <span class="px-3 py-1 font-label-sm text-label-sm text-on-surface-variant">{{ $messages->currentPage() }}</span>
                @if ($messages->hasMorePages())
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

    @if($viewingMessage)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm" wire:click.self="closeView">
        <div class="bg-surface w-full max-w-2xl rounded-2xl modal-shadow overflow-hidden transform transition-all duration-300" @click.stop>
            <header class="px-lg py-md border-b border-outline-variant flex items-center justify-between">
                <h3 class="font-headline-md text-headline-md text-on-surface">تفاصيل الرسالة</h3>
                <button wire:click="closeView" class="p-xs rounded-full hover:bg-surface-container-high text-on-surface-variant transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </header>
            <div class="p-lg space-y-md">
                <div class="grid grid-cols-2 gap-md">
                    <div>
                        <label class="font-label-sm text-label-sm text-on-surface-variant">الاسم</label>
                        <p class="font-label-md text-label-md text-on-surface">{{ $viewingMessage->name }}</p>
                    </div>
                    <div>
                        <label class="font-label-sm text-label-sm text-on-surface-variant">البريد الإلكتروني</label>
                        <p class="font-label-md text-label-md text-on-surface">{{ $viewingMessage->email }}</p>
                    </div>
                </div>
                <div>
                    <label class="font-label-sm text-label-sm text-on-surface-variant">الموضوع</label>
                    <p class="font-label-md text-label-md text-on-surface">{{ $viewingMessage->subject }}</p>
                </div>
                <div>
                    <label class="font-label-sm text-label-sm text-on-surface-variant">الرسالة</label>
                    <div class="mt-xs p-md bg-surface-container-low rounded-lg font-body-md text-body-md text-on-surface leading-relaxed whitespace-pre-wrap">{{ $viewingMessage->message }}</div>
                </div>
                @if($viewingMessage->admin_reply)
                <div>
                    <label class="font-label-sm text-label-sm text-on-surface-variant">رد الإدارة</label>
                    <div class="mt-xs p-md bg-primary-container/20 rounded-lg font-body-md text-body-md text-on-surface leading-relaxed whitespace-pre-wrap">{{ $viewingMessage->admin_reply }}</div>
                    <p class="text-xs text-on-surface-variant mt-xs">تم الرد في {{ $viewingMessage->replied_at?->format('Y-m-d h:i A') }}</p>
                </div>
                @endif
                @if($showReplyForm)
                <div class="border-t border-outline-variant pt-md space-y-md">
                    <label class="font-label-md text-label-md text-on-surface">الرد على الرسالة</label>
                    <textarea wire:model="reply" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" rows="4" placeholder="اكتب ردك هنا..."></textarea>
                    @error('reply') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                    <div class="flex gap-md">
                        <button wire:click="closeReply" class="px-lg py-sm border border-outline-variant rounded-lg font-label-md text-on-surface hover:bg-surface-container-low transition-colors">إلغاء</button>
                        <button wire:click="sendReply" class="px-lg py-sm bg-primary text-on-primary rounded-lg font-label-md hover:opacity-90 transition-all">إرسال الرد</button>
                    </div>
                </div>
                @endif
                <div class="flex items-center gap-sm text-xs text-on-surface-variant">
                    <span class="material-symbols-outlined text-[14px]">schedule</span>
                    <span>{{ $viewingMessage->created_at->format('Y-m-d h:i A') }}</span>
                </div>
                <div class="flex justify-end gap-md pt-md border-t border-outline-variant">
                    <button wire:click="closeView" class="px-lg py-sm border border-outline-variant rounded-lg font-label-md text-on-surface hover:bg-surface-container-low transition-colors">إغلاق</button>
                    @if(!$showReplyForm)
                    <button wire:click="openReply" class="px-lg py-sm bg-secondary text-on-secondary rounded-lg font-label-md hover:opacity-90 transition-all">
                        <span class="material-symbols-outlined text-[16px] align-middle">reply</span> رد
                    </button>
                    @endif
                    @if(!$viewingMessage->is_read)
                    <button wire:click="markAsRead({{ $viewingMessage->id }}); closeView();" class="px-lg py-sm bg-primary text-on-primary rounded-lg font-label-md hover:opacity-90 transition-all">تحديد كمقروءة</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
