<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-md mb-xl">
        <div>
            <h2 class="font-headline-lg text-headline-lg text-on-surface">إدارة المستخدمين</h2>
            <p class="text-on-surface-variant font-body-md text-body-md mt-xs">إدارة حسابات المستخدمين والأدوار والصلاحيات.</p>
        </div>
        <button wire:click="openCreateModal" class="bg-primary text-on-primary font-label-md text-label-md px-lg py-sm rounded-lg flex items-center gap-xs hover:opacity-90 active:scale-95 transition-all shadow-md">
            <span class="material-symbols-outlined">add</span>إضافة مستخدم
        </button>
    </div>

    @if (session()->has('message'))
    <div class="flash-message flash-message-success">
        <span class="material-symbols-outlined text-[18px]">check_circle</span>
        {{ session('message') }}
    </div>
    @endif

    @if (session()->has('error'))
    <div class="flash-message flash-message-error">
        <span class="material-symbols-outlined text-[18px]">error</span>
        {{ session('error') }}
    </div>
    @endif

    <div class="bg-surface custom-shadow rounded-xl p-md mb-lg">
        <div class="relative w-full md:w-96">
            <span class="material-symbols-outlined absolute right-sm top-1/2 -translate-y-1/2 text-outline">search</span>
            <input wire:model.live.debounce.300ms="search" class="w-full pr-10 pl-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary transition-all outline-none text-body-md" placeholder="ابحث عن اسم أو بريد..." type="text"/>
        </div>
    </div>

    <div class="bg-surface custom-shadow rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-surface-container-low">
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">المستخدم</th>
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">البريد الإلكتروني</th>
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">الدور</th>
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">تاريخ التسجيل</th>
                        <th class="px-md py-sm font-label-md text-label-md text-on-surface-variant text-left">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/50">
                    @forelse($users as $user)
                    <tr class="table-row-hover">
                        <td class="px-md py-md">
                            <div class="flex items-center gap-sm">
                                <img class="w-8 h-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=00288e&color=fff" alt="{{ $user->name }}"/>
                                <span class="font-label-md text-label-md text-on-surface">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-md py-md font-body-md text-body-md text-on-surface-variant">{{ $user->email }}</td>
                        <td class="px-md py-md">
                            @php
                            $roleName = $user->roles->first()?->name ?? 'user';
                            $roleBadge = $roleName === 'admin' ? 'role-badge-admin' : 'role-badge-user';
                            $roleLabel = $roleName === 'admin' ? 'مدير' : 'مستخدم';
                            @endphp
                            <span class="role-badge {{ $roleBadge }}">{{ $roleLabel }}</span>
                        </td>
                        <td class="px-md py-md font-label-sm text-label-sm text-on-surface-variant">{{ $user->created_at->format('Y-m-d') }}</td>
                        <td class="px-md py-md text-left">
                            <button wire:click="openEditModal({{ $user->id }})" class="p-xs hover:bg-surface-container-high rounded transition-colors text-on-surface-variant">
                                <span class="material-symbols-outlined">edit</span>
                            </button>
                            @if(auth()->id() !== $user->id)
                            <button wire:click="confirmDelete({{ $user->id }})" class="p-xs hover:bg-surface-container-high rounded transition-colors text-error">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-md py-xl text-center text-on-surface-variant font-body-md">لا يوجد مستخدمون.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-md py-sm bg-surface-container-low border-t border-outline-variant/50 flex items-center justify-between">
            <p class="font-label-sm text-label-sm text-on-surface-variant">عرض {{ $users->firstItem() ?? 0 }} إلى {{ $users->lastItem() ?? 0 }} من {{ $users->total() }} مستخدم</p>
            <div class="flex items-center gap-1">
                @if ($users->onFirstPage())
                <button class="w-8 h-8 flex items-center justify-center border border-outline-variant rounded-lg text-on-surface-variant opacity-30" disabled>
                    <span class="material-symbols-outlined text-[18px] rtl-flip">chevron_right</span>
                </button>
                @else
                <button wire:click="previousPage" class="w-8 h-8 flex items-center justify-center border border-outline-variant rounded-lg text-on-surface-variant hover:bg-surface transition-colors">
                    <span class="material-symbols-outlined text-[18px] rtl-flip">chevron_right</span>
                </button>
                @endif
                <span class="w-8 h-8 rounded-lg bg-secondary text-on-secondary font-bold text-label-sm flex items-center justify-center">{{ $users->currentPage() }}</span>
                @if ($users->hasMorePages())
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
    </div>

    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm" wire:click.self="closeModal">
        <div class="bg-surface w-full max-w-lg rounded-2xl modal-shadow overflow-hidden transform transition-all duration-300" @click.stop>
            <header class="px-lg py-md border-b border-outline-variant flex items-center justify-between">
                <h3 class="font-headline-md text-headline-md text-on-surface">{{ $editingUser ? 'تعديل المستخدم' : 'إضافة مستخدم جديد' }}</h3>
                <button wire:click="closeModal" class="p-xs rounded-full hover:bg-surface-container-high text-on-surface-variant transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </header>
            <form wire:submit="save" class="p-lg space-y-md">
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">الاسم</label>
                    <input wire:model="name" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="text"/>
                    @error('name') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">البريد الإلكتروني</label>
                    <input wire:model="email" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="email"/>
                    @error('email') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">{{ $editingUser ? 'كلمة المرور الجديدة (اختياري)' : 'كلمة المرور' }}</label>
                    <input wire:model="password" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" type="password"/>
                    @error('password') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface">الدور</label>
                    <select wire:model="role" class="w-full px-sm py-xs rounded-lg border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none bg-white">
                        @foreach($roles as $r)
                        <option value="{{ $r->name }}">{{ $r->name === 'admin' ? 'مدير' : 'مستخدم' }}</option>
                        @endforeach
                    </select>
                    @error('role') <span class="text-error text-label-sm">{{ $message }}</span> @enderror
                </div>
                <footer class="flex justify-end gap-md pt-md border-t border-outline-variant">
                    <button type="button" wire:click="closeModal" class="px-lg py-sm font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors">إلغاء</button>
                    <button type="submit" class="bg-primary text-on-primary px-xl py-sm rounded-lg font-label-md text-label-md hover:opacity-90 active:scale-95 transition-all">{{ $editingUser ? 'تحديث' : 'إضافة' }}</button>
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
                <p class="font-body-md text-on-surface-variant mt-xs">هل أنت متأكد من حذف هذا المستخدم؟ لا يمكن التراجع عن هذا الإجراء.</p>
            </div>
            <div class="flex justify-center gap-md mt-lg">
                <button wire:click="cancelDelete" class="px-lg py-sm border border-outline-variant rounded-lg font-label-md text-on-surface hover:bg-surface-container-low transition-colors">إلغاء</button>
                <button wire:click="delete({{ $confirmingDelete }})" class="px-lg py-sm bg-error text-on-error rounded-lg font-label-md hover:opacity-90 transition-all">حذف</button>
            </div>
        </div>
    </div>
    @endif
</div>
