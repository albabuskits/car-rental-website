<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\DriverLicense;
use App\Services\AiOcrService;
use Illuminate\Support\Facades\Storage;

class UserDriverLicense extends Component
{
    use WithFileUploads;

    public $licenseImage = null;
    public $license;
    public $editing = false;

    public $full_name = '';
    public $license_number = '';
    public $date_of_birth = '';
    public $issue_date = '';
    public $expiration_date = '';
    public $address = '';

    protected $rules = [
        'licenseImage' => 'nullable|image|max:5120',
        'full_name' => 'required|string|max:255',
        'license_number' => 'required|string|max:50',
        'date_of_birth' => 'nullable|date',
        'issue_date' => 'nullable|date',
        'expiration_date' => 'nullable|date|after:issue_date',
        'address' => 'nullable|string|max:500',
    ];

    public function mount()
    {
        $this->license = DriverLicense::where('user_id', auth()->id())->first();
        if ($this->license) {
            $this->loadLicense();
        }
    }

    public function loadLicense()
    {
        $this->full_name = $this->license->full_name ?? '';
        $this->license_number = $this->license->license_number ?? '';
        $this->date_of_birth = $this->license->date_of_birth?->format('Y-m-d') ?? '';
        $this->issue_date = $this->license->issue_date?->format('Y-m-d') ?? '';
        $this->expiration_date = $this->license->expiration_date?->format('Y-m-d') ?? '';
        $this->address = $this->license->address ?? '';
    }

    public function startEdit()
    {
        $this->editing = true;
    }

    public function cancelEdit()
    {
        $this->editing = false;
        if ($this->license) $this->loadLicense();
        else $this->resetFields();
    }

    public function resetFields()
    {
        $this->full_name = '';
        $this->license_number = '';
        $this->date_of_birth = '';
        $this->issue_date = '';
        $this->expiration_date = '';
        $this->address = '';
        $this->licenseImage = null;
    }

    public function scanLicense()
    {
        $this->validate(['licenseImage' => 'required|image|max:5120']);

        $path = $this->licenseImage->store('licenses', 'public');

        $ocr = app(AiOcrService::class);
        $data = $ocr->extract(storage_path('app/public/' . $path));

        $this->full_name = $data['full_name'] ?: $this->full_name;
        $this->license_number = $data['license_number'] ?: $this->license_number;
        $this->date_of_birth = $data['date_of_birth'] ?: $this->date_of_birth;
        $this->issue_date = $data['issue_date'] ?: $this->issue_date;
        $this->expiration_date = $data['expiration_date'] ?: $this->expiration_date;
        $this->address = $data['address'] ?: $this->address;

        if ($this->license) {
            $this->license->update([
                'license_image' => $path,
                'extracted_data' => $data,
            ]);
            Storage::disk('public')->delete($this->license->getOriginal('license_image') ?? '');
        }

        session()->flash('message', 'تم مسح الرخصة ضوئياً. يرجى مراجعة البيانات المدخلة.');
        $this->editing = true;
    }

    public function saveLicense()
    {
        $this->validate();

        $data = [
            'user_id' => auth()->id(),
            'full_name' => $this->full_name,
            'license_number' => $this->license_number,
            'date_of_birth' => $this->date_of_birth ?: null,
            'issue_date' => $this->issue_date ?: null,
            'expiration_date' => $this->expiration_date ?: null,
            'address' => $this->address,
            'status' => 'pending',
            'is_verified' => false,
        ];

        if ($this->license) {
            $this->license->update($data);
            $this->dispatch('refreshNotifications');
            session()->flash('message', 'تم تحديث بيانات الرخصة.');
        } else {
            if ($this->licenseImage) {
                $data['license_image'] = $this->licenseImage->store('licenses', 'public');
            }
            $license = DriverLicense::create($data);
            $this->license = $license;
            $this->dispatch('refreshNotifications');
            session()->flash('message', 'تم حفظ بيانات الرخصة.');
        }

        $this->editing = false;
        $this->loadLicense();
    }

    public function render()
    {
        return view('livewire.user-driver-license');
    }
}
