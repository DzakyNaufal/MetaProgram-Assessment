<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'max_uses',
        'used_count',
        'valid_from',
        'valid_until',
        'is_active',
        'description',
        'course_types',
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
        'value' => 'decimal:2',
        'course_types' => 'array',
    ];

    /**
     * Check if coupon is valid
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now();

        if ($this->valid_from && $now->lt($this->valid_from)) {
            return false;
        }

        if ($this->valid_until && $now->gt($this->valid_until)) {
            return false;
        }

        if ($this->max_uses && $this->used_count >= $this->max_uses) {
            return false;
        }

        return true;
    }

    /**
     * Check if coupon is applicable for given order amount
     */
    public function isApplicableForOrder($orderAmount): bool
    {
        if ($this->min_order_amount && $orderAmount < $this->min_order_amount) {
            return false;
        }

        return true;
    }

    /**
     * Check if coupon is applicable for a specific course type
     */
    public function isApplicableForCourseType($courseType): bool
    {
        // If no course types specified, coupon applies to all courses
        if (empty($this->course_types)) {
            return true;
        }

        // Check if the course type is in the allowed types
        return in_array($courseType, $this->course_types);
    }

    /**
     * Calculate discount amount
     */
    public function calculateDiscount($orderAmount): float
    {
        if ($this->type === 'percentage') {
            return ($orderAmount * $this->value) / 100;
        }

        return min($this->value, $orderAmount);
    }

    /**
     * Increment used count
     */
    public function incrementUsedCount(): void
    {
        $this->increment('used_count');
    }
}
