<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ContactMessage;

class AdminMessages extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = '';
    public $viewingMessage = null;
    public $reply = '';
    public $showReplyForm = false;

    protected $rules = [
        'reply' => 'required|string|min:1',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilter()
    {
        $this->resetPage();
    }

    public function viewMessage($messageId)
    {
        $this->viewingMessage = ContactMessage::findOrFail($messageId);
        if (!$this->viewingMessage->is_read) {
            $this->viewingMessage->update(['is_read' => true]);
        }
    }

    public function closeView()
    {
        $this->viewingMessage = null;
    }

    public function markAsRead($messageId)
    {
        ContactMessage::where('id', $messageId)->update(['is_read' => true]);
        session()->flash('message', 'تم تحديث حالة الرسالة.');
    }

    public function markAsUnread($messageId)
    {
        ContactMessage::where('id', $messageId)->update(['is_read' => false]);
        session()->flash('message', 'تم تحديث حالة الرسالة.');
    }

    public function openReply()
    {
        $this->showReplyForm = true;
        $this->reply = $this->viewingMessage->admin_reply ?? '';
    }

    public function closeReply()
    {
        $this->showReplyForm = false;
        $this->reply = '';
    }

    public function sendReply()
    {
        $this->validate();
        $this->viewingMessage->update([
            'admin_reply' => $this->reply,
            'replied_at' => now(),
            'is_read' => true,
        ]);
        $this->showReplyForm = false;
        session()->flash('message', 'تم إرسال الرد بنجاح.');
    }

    public function delete($messageId)
    {
        ContactMessage::findOrFail($messageId)->delete();
        if ($this->viewingMessage && $this->viewingMessage->id === (int) $messageId) {
            $this->viewingMessage = null;
        }
        session()->flash('message', 'تم حذف الرسالة.');
    }

    public function render()
    {
        if ($this->search) {
            try {
                $messages = ContactMessage::search($this->search)
                    ->when($this->filter === 'unread', fn($q) => $q->where('is_read', false))
                    ->when($this->filter === 'read', fn($q) => $q->where('is_read', true))
                    ->query(fn($q) => $q->latest())
                    ->paginate(10);
            } catch (\Meilisearch\Exceptions\CommunicationException $e) {
                $messages = ContactMessage::where(function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('email', 'like', '%' . $this->search . '%')
                          ->orWhere('subject', 'like', '%' . $this->search . '%');
                    })
                    ->when($this->filter === 'unread', fn($q) => $q->where('is_read', false))
                    ->when($this->filter === 'read', fn($q) => $q->where('is_read', true))
                    ->latest()->paginate(10);
            }
        } else {
            $query = ContactMessage::query();

            if ($this->filter === 'unread') {
                $query->where('is_read', false);
            } elseif ($this->filter === 'read') {
                $query->where('is_read', true);
            }

            $messages = $query->latest()->paginate(10);
        }

        $unreadCount = ContactMessage::where('is_read', false)->count();

        return view('livewire.admin-messages', compact('messages', 'unreadCount'));
    }
}
