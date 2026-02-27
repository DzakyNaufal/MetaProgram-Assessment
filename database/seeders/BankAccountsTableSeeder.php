<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\BankAccount;

class BankAccountsTableSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama jika ada - dengan menangani constraint
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        BankAccount::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Buat data dummy bank account
        $bankAccounts = [
            [
                'bank_name' => 'Bank Negara Indonesia (BNI)',
                'account_number' => '1234567890',
                'account_holder' => 'PT. Talent Mapping Indonesia',
                'is_active' => true,
            ],
            [
                'bank_name' => 'Bank Central Asia (BCA)',
                'account_number' => '0987654321',
                'account_holder' => 'PT. Talent Mapping Indonesia',
                'is_active' => true,
            ],
            [
                'bank_name' => 'Bank Mandiri',
                'account_number' => '1122334455',
                'account_holder' => 'PT. Talent Mapping Indonesia',
                'is_active' => true,
            ]
        ];

        foreach ($bankAccounts as $bankAccount) {
            BankAccount::create($bankAccount);
        }
    }
}
