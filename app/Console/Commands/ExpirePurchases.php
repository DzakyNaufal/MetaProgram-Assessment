<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Purchase;

class ExpirePurchases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purchases:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire purchases (pending and confirmed) that have exceeded the time limit';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Expire pending purchases (payment expiry)
        $pendingExpiredCount = Purchase::where('status', 'pending')
            ->where('expired_at', '<=', now())
            ->update(['status' => 'expired']);

        $this->info("Expired {$pendingExpiredCount} pending purchases (payment timeout).");

        // Expire confirmed purchases that have exceeded access duration
        // Note: Lifetime purchases have expired_at = null, so they won't be affected
        $accessExpiredCount = Purchase::where('status', 'confirmed')
            ->whereNotNull('expired_at')
            ->where('expired_at', '<=', now())
            ->update(['status' => 'expired']);

        $this->info("Expired {$accessExpiredCount} confirmed purchases (access duration ended).");

        $totalExpired = $pendingExpiredCount + $accessExpiredCount;
        $this->info("Total expired purchases: {$totalExpired}");
    }
}
