<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'features',
        'is_recommended',
        'is_active',
        'duration_days',
    ];

    protected $casts = [
        'features' => 'array',
        'is_recommended' => 'boolean',
        'is_active' => 'boolean',
        'duration_days' => 'integer',
    ];

    // Relasi dengan purchases
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    // Cek apakah tier ini lifetime (tidak ada durasi)
    public function isLifetime(): bool
    {
        return is_null($this->duration_days);
    }

    // Hitung tanggal expiry berdasarkan durasi
    public function calculateExpiryDate(): ?Carbon
    {
        if ($this->isLifetime()) {
            return null;
        }

        return now()->addDays($this->duration_days);
    }
}
