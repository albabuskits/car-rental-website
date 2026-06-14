<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class DriverLicense extends Model
{
    use Searchable;

    protected $fillable = [
        'user_id', 'license_number', 'full_name', 'date_of_birth',
        'issue_date', 'expiration_date', 'address', 'license_image',
        'owner_photo', 'extracted_data', 'is_verified', 'status',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'issue_date' => 'date',
            'expiration_date' => 'date',
            'extracted_data' => 'array',
            'is_verified' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function toSearchableArray()
    {
        return [
            'full_name' => $this->full_name,
            'license_number' => $this->license_number,
            'status' => $this->status,
        ];
    }
}
