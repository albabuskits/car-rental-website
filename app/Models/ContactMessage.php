<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use App\Traits\LogsActivity;

class ContactMessage extends Model
{
    use Searchable, LogsActivity;

    protected $fillable = ['name', 'email', 'subject', 'message', 'is_read', 'admin_reply', 'replied_at'];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'replied_at' => 'datetime',
        ];
    }

    public function activityLabel(): string
    {
        return 'رسالة من ' . ($this->name ?? '') . ' - #' . $this->id;
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ];
    }
}
