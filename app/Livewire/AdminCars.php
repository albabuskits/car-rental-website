<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Support\Facades\Storage;

class AdminCars extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $statusFilter = '';
    public $showModal = false;
    public $editingCar = null;
    public $confirmingDelete = null;

    public $brand = '';
    public $model = '';
    public $year = '';
    public $category = 'economy';
    public $transmission = 'automatic';
    public $fuel_type = 'gasoline';
    public $seats = 5;
    public $ac = true;
    public $price_per_day = '';
    public $description = '';
    public $status = 'available';
    public $existingImages = [];
    public $newImages = [];

    protected $rules = [
        'brand' => 'required|string|max:255',
        'model' => 'required|string|max:255',
        'year' => 'nullable|string|max:10',
        'category' => 'required|string|max:255',
        'transmission' => 'required|string|max:255',
        'fuel_type' => 'required|string|max:255',
        'seats' => 'required|integer|min:1|max:15',
        'ac' => 'boolean',
        'price_per_day' => 'required|numeric|min:0',
        'description' => 'nullable|string',
        'status' => 'required|in:available,rented,maintenance',
        'newImages' => 'nullable|array',
        'newImages.*' => 'image|max:2048',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetInputFields();
        $this->showModal = true;
        $this->editingCar = null;
    }

    public function openEditModal($carId)
    {
        $car = Car::with('images')->findOrFail($carId);
        $this->editingCar = $car;
        $this->brand = $car->brand;
        $this->model = $car->model;
        $this->year = $car->year;
        $this->category = $car->category;
        $this->transmission = $car->transmission;
        $this->fuel_type = $car->fuel_type;
        $this->seats = $car->seats;
        $this->ac = $car->ac;
        $this->price_per_day = $car->price_per_day;
        $this->description = $car->description;
        $this->status = $car->status;
        $this->existingImages = $car->images->toArray();
        $this->newImages = [];
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->brand = '';
        $this->model = '';
        $this->year = '';
        $this->category = 'economy';
        $this->transmission = 'automatic';
        $this->fuel_type = 'gasoline';
        $this->seats = 5;
        $this->ac = true;
        $this->price_per_day = '';
        $this->description = '';
        $this->status = 'available';
        $this->existingImages = [];
        $this->newImages = [];
        $this->editingCar = null;
    }

    public function removeNewImage($index)
    {
        if (isset($this->newImages[$index])) {
            unset($this->newImages[$index]);
            $this->newImages = array_values($this->newImages);
        }
    }

    public function removeExistingImage($imageId)
    {
        $image = CarImage::find($imageId);
        if ($image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
        $this->existingImages = array_values(array_filter($this->existingImages, fn($img) => $img['id'] !== $imageId));
    }

    public function save()
    {
        $this->validate();

        $data = [
            'brand' => $this->brand,
            'model' => $this->model,
            'year' => $this->year,
            'category' => $this->category,
            'transmission' => $this->transmission,
            'fuel_type' => $this->fuel_type,
            'seats' => $this->seats,
            'ac' => $this->ac,
            'price_per_day' => $this->price_per_day,
            'description' => $this->description,
            'status' => $this->status,
        ];

        if ($this->editingCar) {
            $car = $this->editingCar;
            $car->update($data);

            if (!empty($this->newImages)) {
                foreach ($this->newImages as $index => $uploadedImage) {
                    $path = $uploadedImage->store('cars', 'public');
                    CarImage::create([
                        'car_id' => $car->id,
                        'image_path' => $path,
                        'is_primary' => empty($this->existingImages) && $index === 0,
                    ]);
                }
            }

            if (!$car->images()->exists()) {
                session()->flash('message', 'يرجى رفع صورة واحدة على الأقل.');
                return;
            }

            session()->flash('message', 'تم تحديث السيارة بنجاح.');
        } else {
            if (empty($this->newImages)) {
                session()->flash('message', 'يرجى رفع صورة واحدة على الأقل.');
                return;
            }

            $car = Car::create($data);

            foreach ($this->newImages as $index => $uploadedImage) {
                $path = $uploadedImage->store('cars', 'public');
                CarImage::create([
                    'car_id' => $car->id,
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                ]);
            }

            session()->flash('message', 'تم إضافة السيارة بنجاح.');
        }

        $this->closeModal();
    }

    public function confirmDelete($carId)
    {
        $this->confirmingDelete = $carId;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = null;
    }

    public function delete($carId)
    {
        $car = Car::with('images')->findOrFail($carId);
        foreach ($car->images as $img) {
            Storage::disk('public')->delete($img->image_path);
            $img->delete();
        }
        $car->delete();
        $this->confirmingDelete = null;
        session()->flash('message', 'تم حذف السيارة بنجاح.');
    }

    public function render()
    {
        if ($this->search) {
            $cars = Car::search($this->search)
                ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
                ->query(fn($q) => $q->with('images'))
                ->paginate(10);
        } else {
            $query = Car::with('images');

            if ($this->statusFilter) {
                $query->where('status', $this->statusFilter);
            }

            $cars = $query->latest()->paginate(10);
        }

        $totalCars = Car::count();
        $availableCount = Car::where('status', 'available')->count();
        $rentedCount = Car::where('status', 'rented')->count();
        $maintenanceCount = Car::where('status', 'maintenance')->count();

        return view('livewire.admin-cars', compact('cars', 'totalCars', 'availableCount', 'rentedCount', 'maintenanceCount'));
    }
}
