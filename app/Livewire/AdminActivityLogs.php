<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ActivityLog;

class AdminActivityLogs extends Component
{
    use WithPagination;

    public $search = '';
    public $actionFilter = '';
    public $userIdFilter = '';
    public $subjectFilter = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $selectedLog = null;
    public $showDetails = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'actionFilter' => ['except' => ''],
        'userIdFilter' => ['except' => ''],
        'subjectFilter' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedActionFilter()
    {
        $this->resetPage();
    }

    public function updatedUserIdFilter()
    {
        $this->resetPage();
    }

    public function updatedSubjectFilter()
    {
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->resetPage();
    }

    public function openDetails($logId)
    {
        $this->selectedLog = ActivityLog::with('user')->findOrFail($logId);
        $this->showDetails = true;
    }

    public function closeDetails()
    {
        $this->showDetails = false;
        $this->selectedLog = null;
    }

    public function clearFilters()
    {
        $this->reset(['search', 'actionFilter', 'userIdFilter', 'subjectFilter', 'dateFrom', 'dateTo']);
    }

    public function render()
    {
        $query = ActivityLog::with('user');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('description', 'like', '%' . $this->search . '%')
                  ->orWhere('subject_label', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function ($u) {
                      $u->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->actionFilter) {
            $query->where('action', $this->actionFilter);
        }

        if ($this->subjectFilter) {
            $query->where('subject_type', $this->subjectFilter);
        }

        if ($this->userIdFilter) {
            $query->where('user_id', $this->userIdFilter);
        }

        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        $logs = $query->latest()->paginate(20);

        $filterOptions = [
            'actions' => ActivityLog::select('action')->distinct()->pluck('action'),
            'subjects' => ActivityLog::select('subject_type')->distinct()->pluck('subject_type'),
            'users' => \App\Models\User::whereHas('activityLogs')->select('id', 'name')->get(),
        ];

        $totalLogs = ActivityLog::count();
        $todayLogs = ActivityLog::whereDate('created_at', today())->count();

        return view('livewire.admin-activity-logs', [
            'logs' => $logs,
            'filterOptions' => $filterOptions,
            'totalLogs' => $totalLogs,
            'todayLogs' => $todayLogs,
        ]);
    }
}
