<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing coupons
        Coupon::query()->delete();

        $now = Carbon::now();

        $coupons = [
            // Discount Percentage Coupons
            [
                'code' => 'DISCOUNT10',
                'type' => 'percentage',
                'value' => 10,
                'min_order_amount' => 500000,
                'max_uses' => 100,
                'used_count' => 0,
                'valid_from' => $now->copy(),
                'valid_until' => $now->copy()->addMonths(6),
                'is_active' => true,
                'description' => 'Diskon 10% untuk minimum pembelian Rp 500.000',
            ],
            [
                'code' => 'DISCOUNT20',
                'type' => 'percentage',
                'value' => 20,
                'min_order_amount' => 1000000,
                'max_uses' => 50,
                'used_count' => 0,
                'valid_from' => $now->copy(),
                'valid_until' => $now->copy()->addMonths(3),
                'is_active' => true,
                'description' => 'Diskon 20% untuk minimum pembelian Rp 1.000.000',
            ],
            [
                'code' => 'DISCOUNT25',
                'type' => 'percentage',
                'value' => 25,
                'min_order_amount' => 2000000,
                'max_uses' => 30,
                'used_count' => 0,
                'valid_from' => $now->copy(),
                'valid_until' => $now->copy()->addMonths(2),
                'is_active' => true,
                'description' => 'Diskon 25% untuk minimum pembelian Rp 2.000.000',
            ],
            [
                'code' => 'HEMAT50',
                'type' => 'percentage',
                'value' => 50,
                'min_order_amount' => 3000000,
                'max_uses' => 20,
                'used_count' => 0,
                'valid_from' => $now->copy(),
                'valid_until' => $now->copy()->addMonth(),
                'is_active' => true,
                'description' => 'Diskon 50% untuk minimum pembelian Rp 3.000.000',
            ],

            // Fixed Amount Coupons
            [
                'code' => 'DISKON100K',
                'type' => 'fixed',
                'value' => 100000,
                'min_order_amount' => 500000,
                'max_uses' => 200,
                'used_count' => 0,
                'valid_from' => $now->copy(),
                'valid_until' => $now->copy()->addMonths(6),
                'is_active' => true,
                'description' => 'Diskon Rp 100.000 untuk minimum pembelian Rp 500.000',
            ],
            [
                'code' => 'DISKON250K',
                'type' => 'fixed',
                'value' => 250000,
                'min_order_amount' => 1000000,
                'max_uses' => 100,
                'used_count' => 0,
                'valid_from' => $now->copy(),
                'valid_until' => $now->copy()->addMonths(4),
                'is_active' => true,
                'description' => 'Diskon Rp 250.000 untuk minimum pembelian Rp 1.000.000',
            ],
            [
                'code' => 'DISKON500K',
                'type' => 'fixed',
                'value' => 500000,
                'min_order_amount' => 2000000,
                'max_uses' => 50,
                'used_count' => 0,
                'valid_from' => $now->copy(),
                'valid_until' => $now->copy()->addMonths(3),
                'is_active' => true,
                'description' => 'Diskon Rp 500.000 untuk minimum pembelian Rp 2.000.000',
            ],
            [
                'code' => 'DISKON1JT',
                'type' => 'fixed',
                'value' => 1000000,
                'min_order_amount' => 5000000,
                'max_uses' => 25,
                'used_count' => 0,
                'valid_from' => $now->copy(),
                'valid_until' => $now->copy()->addMonths(2),
                'is_active' => true,
                'description' => 'Diskon Rp 1.000.000 untuk minimum pembelian Rp 5.000.000',
            ],

            // Special Promo Coupons
            [
                'code' => 'EARLYBIRD',
                'type' => 'percentage',
                'value' => 30,
                'min_order_amount' => 999000,
                'max_uses' => 40,
                'used_count' => 0,
                'valid_from' => $now->copy(),
                'valid_until' => $now->copy()->addMonths(2),
                'is_active' => true,
                'description' => 'Early Bird Promo - Diskon 30% untuk semua assessment',
            ],
            [
                'code' => 'FLASHSALE',
                'type' => 'percentage',
                'value' => 40,
                'min_order_amount' => 0,
                'max_uses' => 30,
                'used_count' => 0,
                'valid_from' => $now->copy(),
                'valid_until' => $now->copy()->addWeeks(2),
                'is_active' => true,
                'description' => 'Flash Sale - Diskon 40% untuk semua pembelian',
            ],
            [
                'code' => 'MEMBEREXCLUSIVE',
                'type' => 'percentage',
                'value' => 15,
                'min_order_amount' => 750000,
                'max_uses' => 150,
                'used_count' => 0,
                'valid_from' => $now->copy(),
                'valid_until' => $now->copy()->addYear(),
                'is_active' => true,
                'description' => 'Member Exclusive - Diskon 15% khusus member',
            ],
            [
                'code' => 'FRIENDSHIP',
                'type' => 'fixed',
                'value' => 200000,
                'min_order_amount' => 0,
                'max_uses' => 500,
                'used_count' => 0,
                'valid_from' => $now->copy(),
                'valid_until' => $now->copy()->addMonths(3),
                'is_active' => true,
                'description' => 'Friendship Promo - Diskon Rp 200.000 untuk semua pembelian',
            ],

            // Free Shipping / Additional Bonus Coupons
            [
                'code' => 'WELCOME100',
                'type' => 'fixed',
                'value' => 100000,
                'min_order_amount' => 250000,
                'max_uses' => 1000,
                'used_count' => 0,
                'valid_from' => $now->copy(),
                'valid_until' => $now->copy()->addMonths(12),
                'is_active' => true,
                'description' => 'Welcome Bonus - Diskon Rp 100.000 untuk user baru',
            ],
            [
                'code' => 'NEWYEAR2025',
                'type' => 'percentage',
                'value' => 35,
                'min_order_amount' => 1500000,
                'max_uses' => 60,
                'used_count' => 0,
                'valid_from' => $now->copy(),
                'valid_until' => $now->copy()->addMonths(4),
                'is_active' => true,
                'description' => 'New Year Promo - Diskon 35% untuk kickstart tahun baru',
            ],

            // Premium Coupons
            [
                'code' => 'PREMIUMVIP',
                'type' => 'percentage',
                'value' => 20,
                'min_order_amount' => 2500000,
                'max_uses' => 35,
                'used_count' => 0,
                'valid_from' => $now->copy(),
                'valid_until' => $now->copy()->addMonths(5),
                'is_active' => true,
                'description' => 'Premium VIP - Diskon 20% untuk Assessment Premium & Elite',
            ],
            [
                'code' => 'COACHINGDEAL',
                'type' => 'fixed',
                'value' => 1500000,
                'min_order_amount' => 3000000,
                'max_uses' => 15,
                'used_count' => 0,
                'valid_from' => $now->copy(),
                'valid_until' => $now->copy()->addMonths(2),
                'is_active' => true,
                'description' => 'Coaching Special - Diskon Rp 1.500.000 untuk paket coaching',
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }

        $this->command->info('Successfully seeded ' . count($coupons) . ' coupons.');
    }
}
