<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coupon_id',
        'course_id',
        'category_id',
        'amount',
        'status',
        'proof_image',
        'sender_name',
        'sender_bank',
        'transfer_date',
        'notes',
        'whatsapp_number',
        'expired_at',
    ];

    protected $casts = [
        'transfer_date' => 'date',
        'expired_at' => 'datetime',
    ];

    /**
     * Relasi dengan user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi dengan course
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Relasi dengan category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi dengan coupon
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Scope untuk status
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    /**
     * Cek apakah purchase sudah expired
     */
    public function isExpired()
    {
        return $this->status === 'expired' || ($this->expired_at && now()->gte($this->expired_at));
    }

    /**
     * Cek apakah purchase valid (confirmed atau belum expired jika pending)
     */
    public function isValid()
    {
        return $this->status === 'confirmed' || ($this->status === 'pending' && !$this->isExpired());
    }

    /**
     * Cek apakah purchase masih aktif (confirmed dan belum expired)
     */
    public function isActive(): bool
    {
        if ($this->status !== 'confirmed') {
            return false;
        }

        // Jika lifetime (tidak ada expired_at), selalu aktif
        if (is_null($this->expired_at)) {
            return true;
        }

        // Cek apakah sudah melewati tanggal expired
        return now()->lt($this->expired_at);
    }

    /**
     * Scope untuk mendapatkan active purchases
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'confirmed')
            ->where(function ($q) {
                $q->whereNull('expired_at')
                    ->orWhere('expired_at', '>', now());
            });
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($purchase) {
            // Delete quiz attempts and results for this user and course (cascade)
            QuizAttempt::where('user_id', $purchase->user_id)
                ->where('course_id', $purchase->course_id)
                ->delete();
        });
    }
}
