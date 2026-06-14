<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DriverLicense;

class AdminLicenses extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $selectedLicense = null;
    public $showModal = false;

    protected $queryString = ['search', 'statusFilter'];

    public function viewLicense($id)
    {
        $this->selectedLicense = DriverLicense::with('user')->findOrFail($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedLicense = null;
    }

    public function verify($id)
    {
        $license = DriverLicense::findOrFail($id);
        $license->update([
            'is_verified' => true,
            'status' => 'verified',
        ]);
        if ($this->selectedLicense && $this->selectedLicense->id === $id) {
            $this->selectedLicense = $license->fresh()->load('user');
        }
        session()->flash('message', 'تم توثيق الرخصة بنجاح.');
    }

    public function reject($id)
    {
        $license = DriverLicense::findOrFail($id);
        $license->update([
            'is_verified' => false,
            'status' => 'rejected',
        ]);
        if ($this->selectedLicense && $this->selectedLicense->id === $id) {
            $this->selectedLicense = $license->fresh()->load('user');
        }
        session()->flash('message', 'تم رفض الرخصة.');
    }

    public function resetStatus($id)
    {
        $license = DriverLicense::findOrFail($id);
        $license->update([
            'is_verified' => false,
            'status' => 'pending',
        ]);
        if ($this->selectedLicense && $this->selectedLicense->id === $id) {
            $this->selectedLicense = $license->fresh()->load('user');
        }
        session()->flash('message', 'تم إعادة تعيين حالة الرخصة.');
    }

    public function render()
    {
        if ($this->search) {
            try {
                $licenses = DriverLicense::search($this->search)
                    ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
                    ->query(fn($q) => $q->with('user')->orderBy('created_at', 'desc'))
                    ->paginate(10);
            } catch (\Meilisearch\Exceptions\CommunicationException $e) {
                $licenses = DriverLicense::with('user')
                    ->where(function ($q) {
                        $q->where('full_name', 'like', '%' . $this->search . '%')
                          ->orWhere('license_number', 'like', '%' . $this->search . '%');
                    })
                    ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
                    ->orderBy('created_at', 'desc')->paginate(10);
            }
        } else {
            $query = DriverLicense::with('user');

            if ($this->statusFilter) {
                $query->where('status', $this->statusFilter);
            }

            $licenses = $query->orderBy('created_at', 'desc')->paginate(10);
        }

        $pendingCount = DriverLicense::where('status', 'pending')->count();
        $verifiedCount = DriverLicense::where('status', 'verified')->count();
        $rejectedCount = DriverLicense::where('status', 'rejected')->count();

        return view('livewire.admin-licenses', [
            'licenses' => $licenses,
            'pendingCount' => $pendingCount,
            'verifiedCount' => $verifiedCount,
            'rejectedCount' => $rejectedCount,
        ]);
    }
}
