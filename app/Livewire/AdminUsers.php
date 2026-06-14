<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUsers extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editingUser = null;
    public $confirmingDelete = null;

    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $role = 'user';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'nullable|string|min:8',
        'role' => 'required|exists:roles,name',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetInputFields();
        $this->showModal = true;
        $this->editingUser = null;
    }

    public function openEditModal($userId)
    {
        $user = User::findOrFail($userId);
        $this->editingUser = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->password_confirmation = '';
        $this->role = $user->roles->first()?->name ?? 'user';
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->role = 'user';
        $this->editingUser = null;
    }

    public function save()
    {
        $rules = $this->rules;

        if ($this->editingUser) {
            $rules['email'] = 'required|email|max:255|unique:users,email,' . $this->editingUser->id;
            if (!$this->password) {
                unset($rules['password']);
            }
        } else {
            $rules['email'] = 'required|email|max:255|unique:users,email';
            $rules['password'] = 'required|string|min:8';
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->editingUser) {
            $this->editingUser->update($data);
            $this->editingUser->syncRoles([$this->role]);
            session()->flash('message', 'تم تحديث المستخدم بنجاح.');
        } else {
            $user = User::create($data);
            $user->assignRole($this->role);
            session()->flash('message', 'تم إضافة المستخدم بنجاح.');
        }

        $this->closeModal();
    }

    public function confirmDelete($userId)
    {
        $this->confirmingDelete = $userId;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = null;
    }

    public function delete($userId)
    {
        if ((int) $userId === auth()->id()) {
            session()->flash('error', 'لا يمكن حذف المستخدم الحالي.');
            $this->confirmingDelete = null;
            return;
        }
        User::findOrFail($userId)->delete();
        $this->confirmingDelete = null;
        session()->flash('message', 'تم حذف المستخدم بنجاح.');
    }

    public function render()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        $users = $query->with('roles')->latest()->paginate(10);
        $roles = Role::all();
        $totalUsers = User::count();
        $adminCount = User::role('admin')->count();

        return view('livewire.admin-users', compact('users', 'roles', 'totalUsers', 'adminCount'));
    }
}
