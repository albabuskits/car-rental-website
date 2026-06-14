<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverLicense extends Model
{
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
}
